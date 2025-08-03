<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request, $id)
{
    // Hardcoded products list
    $products = [
        1 => ['id' => 1, 'name' => 'T-Shirt', 'price' => 500],
        2 => ['id' => 2, 'name' => 'Shoes', 'price' => 1500],
        3 => ['id' => 3, 'name' => 'Cap', 'price' => 300],
    ];

    // Check if product exists
    if (!isset($products[$id])) {
        return redirect()->route('products.index')->with('error', 'Invalid product.');
    }

    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        // If already in cart, increment quantity
        $cart[$id]['quantity']++;
    } else {
        // Add new item
        $cart[$id] = [
            'id' => $products[$id]['id'],
            'name' => $products[$id]['name'],
            'price' => $products[$id]['price'],
            'quantity' => 1,
        ];
    }

    session()->put('cart', $cart);

    return redirect()->route('cart.show')->with('success', 'Product added to cart!');
}


    public function show()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->input('quantity');
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.show');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        return redirect()->route('cart.show');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.show');
    }

    public function checkout()
    {
        session()->forget('cart');
        return redirect()->route('cart.show')->with('success', 'Thank you for your purchase!');
    }
}
