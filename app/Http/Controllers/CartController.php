<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart()
    {
        return view('home.cart');
    }
    public function addToCart(Request $request, Product $product)
    {
        // dd($product);

        if (Cart::has($product)) {
            if (Cart::count($product) < $product->inventory) {
                Cart::update($product, 1);
            }
        } else {
            Cart::put(
                [
                    'quantity' => 1
                ],
                $product
            );
        }
        return redirect('/cart');

        // return session()->get('cart');
    }

    public function quantityChange(Request $request)
    {
        // access cart item via request
        $data = $request->validate([
            'quantity' => ['required'],
            'id' => ['required'],
            // 'cart' => ['required'],
        ]);

        if (Cart::has($data['id'])) {
            // chech qunatity < inventory
            // $product = Cart::get($data['id'])['product'];

            Cart::update($data['id'], [
                'quantity' => $data['quantity']
            ]);

            return response([
                'status' => 'success'
            ]);
        }

        return response([
            'status' => 'error'
        ], 404);
    }

    public function deleteFromCart($id)
    {
        Cart::delete($id);

        return back();
    }
}
