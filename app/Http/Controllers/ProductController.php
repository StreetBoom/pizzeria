<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\LazyCollection;

class ProductController extends Controller
{
    /**
     * Отображение главной страницы с продуктами
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = Product::query()->limit(9)->get();

        return view('home', ['products' => $products]);
    }
}
