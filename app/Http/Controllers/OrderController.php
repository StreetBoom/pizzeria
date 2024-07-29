<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Services\Cart\CartService;
use App\Services\Order\OrderService;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected CartService $cartService;
    protected OrderService $orderService;

    /**
     * @param CartService $cartService
     * @param OrderService $orderService
     */
    public function __construct(CartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }


    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('cart.index')->with('error', 'Пожалуйста, войдите в систему для оформления заказа.');
        }

        return view('order.create');
    }


    public function store(OrderRequest $request)
    {
        if (!Auth::check()) {
            return redirect()->route('cart.index')->with('error', 'Пожалуйста, войдите в систему для оформления заказа.');
        }
        $order = $this->orderService->createOrder($request->validated());
        return redirect()->route('profile.show')->with('success', 'Заказ успешно оформлен!');

    }

    public function show($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Пожалуйста, войдите в систему для просмотра заказа.');
        }
        $order = $this->orderService->getOrder($id);
        return view('order.show',
            [
                'order' => $order,
                'items' => json_decode($order->items, true),
            ]);
    }
}
