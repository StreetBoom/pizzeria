<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Отображение главной страницы с продуктами
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('home', ['products' => Product::all()]);
    }
}
