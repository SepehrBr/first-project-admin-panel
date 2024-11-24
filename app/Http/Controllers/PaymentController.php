<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentController extends Controller
{
    public function payment()
    {
        $cartItems = Cart::all();
    // redirect to payment if there is sth to  be payed
        if ($cartItems->count()) {
        // get total price
            $price = $cartItems->sum(function ($cart) {
                return $cart['discount_percent'] == 0
                            ? $cart['product']->price * $cart['quantity']
                            : ($cart['product']->price - ($cart['product']->price * $cart['discount_percent'])) * $cart['quantity'];
            });

        // set order quantity
            $orderItems = $cartItems->mapWithKeys(function ($cart) {
                return [
                    $cart['product']->id => [
                        'quantity' => $cart['quantity']
                    ]
                ];
            });

        // set authed user order to sql
            $order = auth()->user()->orders()->create([
                'status' => 'unpaid',
                'price' => $price
            ]);

        // attach/sync relation tables
            $order->products()->attach($orderItems);


        /* this section because i dont need it just typing the code */
            $token = config('services.payping.token');
            $resource_number = \Str::random(10);
            $args = [
                "amount" => 1000, /* in test mode minimum price is 1000 for payping. otherwise put "amount" => $price */
                "payerIdentity" => auth()->user()->id,
                "payerName" => auth()->user()->name,
                "description" => "success",
                "returnUrl" => route('payment.callback'),
                "clientRefId" => $resource_number
            ];

            $payment = new \PayPing\Payment($token);

            try {
                $payment->pay($args);
            } catch (\Exception $e) {
                throw new \Exception($e);
            }
            //echo $payment->getPayUrl();

        // relations
            $order->payments()->create([
                'resource_number' => $resource_number,
                'price' => $price
            ]);

            $cartItems->flush();

            return redirect($payment->getPayUrl());

        }

        return back();
    }

    public function callback(Request $request)
    {
        $payment = Payment::where('resource_number', $request->clientrefid)->firstOrFail();

    // if payment is succeded =>
        $token = config('services.payping.token');

        $payping = new \PayPing\Payment($token);

        try {

            if($payping->verify($request->refid, 1000 /* in test mode minimum price is 1000 for payping. otherwise put: $payment->price*/)){
                $payment->update([
                    'status' => 1
                ]);

                $payment->order()->update([
                    'status' => 'paid'
                ]);

                return redirect(route('products'));
            }else{
                Alert::error('not paid', 'error occured');
                return redirect(route('error.in.payment'));
            }
        }
        catch (PayPingException $e) {
            $errors = collect(json_decode($e->getMessage(), true));

            Alert::error($errors->first());

            return redirect(route('failed'));
        }
    }
}
