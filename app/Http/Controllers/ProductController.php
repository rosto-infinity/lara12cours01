<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
   public function index()
   {
        // $products = Product::all();
        return Inertia::render('SuperAdmin/Products/ProductIndex', [
            // 'products' => $products,
        ]);
   }
   public function create()
   {
        // $products = Product::all();
        return Inertia::render('SuperAdmin/Products/ProductCreate', [
            // 'products' => $products,
        ]);
   }
   public function store (Request $request)
   {
    // dd($request);
    $data = $request->validate([
        'name' => [
            'required',
            'string',
            'max:255'
        ],
        'price' => [
            'required',
            'numeric',
            'min:0'
        ],
        'description' => [
            'required',
            'string'
        ],
    ]);

    Product::create($data);
    return redirect()->route('products.index')->with('success','Products Create with successefully');
   }
}
