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
        $products =  Product::paginate(9);

        return view('home', ['products' => $products]);
    }
}
