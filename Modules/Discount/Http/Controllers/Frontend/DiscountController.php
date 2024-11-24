<?php

namespace Modules\Discount\Http\Controllers\Frontend;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Cart\Helpers\Cart;
use Modules\Discount\Entities\Discount;

class DiscountController extends Controller
{
    public function check(Request $request)
    {
        // dd($request->all());
        $valid_data = $request->validate([
            'discount' => ['required', 'exists:discounts,code'],
            'cart' => ['required'],
        ]);

        if (!auth()->check()) {
            return back()->withErrors([
                'discount' => 'برای اعمال کد تخفیف لطفا ابندا به حساب کاربری خود وارد شوید!'
            ]);
        }

        $discount = Discount::whereCode($valid_data['discount'])->first();

    // check for discount's expired time
        if ($discount->expired_at < now()) {
            return back()->withErrors([
                'discount' => 'مهلت استفاده از این کد به پایان رسیده است :('
            ]);
        }

    // check for discount, that it has any user or not
        if ($discount->users()->count()) {
        // check for discount, that its users are able to use it or not
            if (!in_array(auth()->user()->id, $discount->users->pluck('id')->toArray())) {
                return back()->withErrors([
                    'discount' => 'متاسفانه شما قادر به استفاده از این کد تخفیف نیستید :('
                ]);
            }
        }

        $cart = Cart::instance($valid_data['cart']);
        $cart->addDiscount($discount->code);
        return back();
    }

    public function destroy(Request $request)
    {
        $cart = Cart::instance($request->cart);
        $cart->addDiscount(null);

        return back();
    }
}
