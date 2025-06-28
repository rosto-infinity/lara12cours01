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
}
