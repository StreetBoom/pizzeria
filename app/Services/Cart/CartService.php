<?php

namespace App\Services\Cart;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    const CART_SESSION_KEY = 'cart';
    const MAX_PIZZA_QUANTITY = 10;
    const MAX_DRINK_QUANTITY = 20;

    /**
     * все товары
     *
     * @return array
     */
    public function getItems(): array
    {
        return session()->get(self::CART_SESSION_KEY, []);
    }
    /**
     * +1 товар
     *
     * @param Product $product
     * @param int $quantity
     * @return string|null
     */
    public function addItem(Product $product, int $quantity = 1): ?string
    {
        $cart = session()->get(self::CART_SESSION_KEY, []);

        if (isset($cart[$product->id])) {
            if ($this->isLimitReached($product, $quantity, $cart)) {
                return $this->getLimitErrorMessage($product);
            }

            $cart[$product->id]['quantity'] += $quantity;
        } else {
            if ($this->isLimitReached($product, $quantity, $cart)) {
                return $this->getLimitErrorMessage($product);
            }

            $cart[$product->id] = [
                'productId' => $product->id,
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $product->price,
                'category' => $product->category->name,
            ];
        }

        session()->put(self::CART_SESSION_KEY, $cart);

        return null;
    }


    /**
     * Уудаление товара
     *
     * @param int $productId
     */
    public function removeItem(int $productId): void
    {
        $cart = session()->get(self::CART_SESSION_KEY, []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put(self::CART_SESSION_KEY, $cart);
        }
    }

    /**
     * кол-во товара
     *
     * @return int
     */
    public function getTotalQuantity(): int
    {
        $cart = session()->get(self::CART_SESSION_KEY, []);
        $totalQuantity = 0;

        foreach ($cart as $details) {
            $totalQuantity += $details['quantity'];
        }

        return $totalQuantity;
    }

    /**
     * общая сумма
     *
     * @return float
     */
    public function getTotalPrice(): float
    {
        $cart = session()->get(self::CART_SESSION_KEY, []);
        $totalPrice = 0.0;

        foreach ($cart as $details) {
            $totalPrice += $details['quantity'] * $details['price'];
        }

        return $totalPrice;
    }

    /**
     * проверка капа
     *
     *
     * @param Product $product
     * @param int $newQuantity
     * @param array $cart
     * @return bool
     */
    private function isLimitReached(Product $product, int $newQuantity, array $cart): bool
    {
        // Получаем категорию товара
        $category = $product->category->name;

        // Подсчитываем общее количество товаров данной категории в корзине
        $totalCategoryQuantity = 0;
        foreach ($cart as $item) {
            if ($item['category'] === $category) {
                $totalCategoryQuantity += $item['quantity'];
            }
        }

        // Проверяем, не будет ли превышен лимит
        if ($category === 'Пицца' && ($totalCategoryQuantity + $newQuantity) > self::MAX_PIZZA_QUANTITY) {
            return true;
        }

        if ($category === 'Напиток' && ($totalCategoryQuantity + $newQuantity) > self::MAX_DRINK_QUANTITY) {
            return true;
        }

        return false;
    }



    /**
     * @param Product $product
     * @return string
     */
    private function getLimitErrorMessage(Product $product): string
    {
        $category = $product->category->name;

        if ($category === 'Пицца') {
            return "Нельзя добавить больше " . self::MAX_PIZZA_QUANTITY . " пицц.";
        }

        if ($category === 'Напитки') {
            return "Нельзя добавить больше " . self::MAX_DRINK_QUANTITY . " напитков.";
        }

        return "Нельзя добавить больше этого товара.";
    }

    /**
     * чистка корзины
     *
     * @return void
     */
    public function clearCart(): void
    {
        session()->forget(self::CART_SESSION_KEY);
    }
}
