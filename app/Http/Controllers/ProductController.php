<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = [
            ['id' => 1, 'name' => 'T-Shirt', 'price' => 500],
            ['id' => 2, 'name' => 'Shoes', 'price' => 1500],
            ['id' => 3, 'name' => 'Cap', 'price' => 300],
        ];

        return view('products', compact('products'));
    }
}
