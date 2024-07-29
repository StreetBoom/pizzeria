<?php

namespace App\Services\Order;

use App\DTO\Order\OrderDTO;
use App\DTO\Order\OrderItemDTO;
use App\Models\Order;
use App\Services\Cart\CartService;

class OrderService
{
    protected CartService $cartService;

    /**
     * @param CartService $cartService
     */
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * @param array $contactData
     * @return mixed
     */
    public function createOrder(array $contactData)
    {
        $orderDTO = new OrderDTO($contactData);

        $orderDTO->items = json_encode($this->getCartItems());
        $orderDTO->total = $this->cartService->getTotalPrice();
        $orderDTO->userId = auth()->id();
        $orderData = [
            'user_id' => $orderDTO->userId,
            'total' => $orderDTO->total,
            'phone' => $orderDTO->phone,
            'email' => $orderDTO->email,
            'address' => $orderDTO->address,
            'delivery_time' => $orderDTO->deliveryTime,
            'items' => $orderDTO->items,
        ];
        $order = Order::create($orderData);

        session()->forget(CartService::CART_SESSION_KEY);

        return $order;

    }

    /**
     * @return array
     */
    public function getCartItems(): array
    {
        $cart = $this->cartService->getItems();
        $orderItems = [];
        foreach ($cart as $item) {
            $orderItemDTO = new OrderItemDTO($item);

            $orderItems[] = $orderItemDTO;
        }

        return $orderItems;
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function ordersByUserId(int $userId)
    {
        return Order::where('user_id', $userId)->get();
    }

    /**
     * @param int $orderId
     */
    public function getOrder(int $orderId) :Order
    {
        return Order::where('id', $orderId)->firstOrFail();

    }

}
