<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\Cart\CartService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
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
     * @return Factory|View|Application|\Illuminate\View\View
     */
    public function index()
    {
        $cartItems = $this->cartService->getItems();
        $totalQuantity = $this->cartService->getTotalQuantity();
        $totalPrice = $this->cartService->getTotalPrice();

        return view('cart.index', compact('cartItems', 'totalQuantity', 'totalPrice'));
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function add(Request $request, Product $product)
    {
        $quantity = (int) $request->input('quantity', 1);

        $error = $this->cartService->addItem($product, $quantity);

        if ($error) {
            return redirect()->route('home')->with('error', $error);
        }

        return redirect()->route('home')->with('success', 'Товар добавлен в корзину!');
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function remove(Request $request, Product $product)
    {
        $this->cartService->removeItem($product->id);
        return redirect()->route('cart.index')->with('success', 'Товар удален из корзины!');
    }
}
