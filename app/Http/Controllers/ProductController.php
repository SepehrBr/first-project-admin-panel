<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->paginate(12);
        return view('home.products', [
            'products' => $products
        ]);
    }

    public function single(Product $product)
    {
        return view('home.single-product', [
            'product' => $product
        ]);
    }

}

