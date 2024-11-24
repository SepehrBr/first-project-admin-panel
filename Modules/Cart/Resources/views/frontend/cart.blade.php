@extends('layouts.master')

@section('script')
    <script>
        function changeQuantity(event, id, cartName = null) {
            const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
            const url = '/cart/quantity/change';
            const data = {
                id: id,
                quantity: event.target.value,
                // cart: cartName,
                _method: 'patch'
            };

            const xhr = new XMLHttpRequest();
            xhr.open('POST', url, true);
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhr.setRequestHeader('Content-Type', 'application/json');

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        location.reload();
                    } else {
                        console.error('There was a problem with the request:', xhr.statusText);
                    }
                }
            };

            xhr.send(JSON.stringify(data));
        }

    </script>
@endsection

@section('content')
    <div class="container px-3 my-5 clearfix">
        <!-- Shopping cart table -->
        <div class="card">
            <div class="card-header">
                <h2>Cart</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered m-0">
                        <thead>
                            <tr>
                                <!-- Set columns width -->
                                <th class="text-center py-3 px-4" style="min-width: 400px;">Product</th>
                                <th class="text-right py-3 px-4" style="width: 150px;">Price</th>
                                <th class="text-center py-3 px-4" style="width: 120px;">Quantity</th>
                                <th class="text-right py-3 px-4" style="width: 150px;">Total Price</th>
                                <th class="text-right py-3 px-4" style="width: 150px;">Actions</th>
                                <th class="text-center align-middle py-3 px-0" style="width: 40px;"><a href="#" class="shop-tooltip float-none text-light" title="" data-original-title="Clear cart"><i class="ino ion-md-trash"></i></a></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (Modules\Cart\Helpers\Cart::all() as $cart)
                                @if (isset($cart['product']))
                                    @php
                                        $product = $cart['product']
                                    @endphp
                                    <tr>
                                        <td class="p-4">
                                            <div class="media align-items-center">
                                                <div class="media-body">
                                                    <a href="#" class="d-block text-dark">{{ $product->title }}</a>
                                                     {{-- attributes
                                                    @if($product->attributes)
                                                     <small>
                                                        @foreach ($product->attributes as $attr)
                                                            <span class="text-muted">{{ $attr->name }}</span> {{ $attr->pivot->value->value }}
                                                        @endforeach
                                                    </small>
                                                    @endif --}}
                                                </div>
                                            </div>
                                        </td>
                                        @if (!$cart['discount_percent'])
                                            <td class="text-right font-weight-semibold align-middle p-4">{{ $product->price }}$</td>
                                        @else
                                            <td class="text-right font-weight-semibold align-middle p-4">
                                                <del class="text-danger text-sm">{{ $product->price }}$</del>
                                                <span>{{ $product->price - ($product->price * $cart['discount_percent']) }}$</span>
                                            </td>
                                        @endif
                                        <td class="align-middle p-4">
                                            <select onchange="changeQuantity(event, '{{ $cart['id'] }}')" class="form-control text-center">
                                                @foreach (range(1, $product->inventory) as $item)
                                                    <option value="{{ $item }}" {{ $cart['quantity'] == $item ? 'selected' : ''}}>{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        @if (!$cart['discount_percent'])
                                            <td class="text-right font-weight-semibold align-middle p-4">{{ $product->price * $cart['quantity'] }}$</td>
                                        @else
                                            <td class="text-right font-weight-semibold align-middle p-4">
                                                <del class="text-danger text-sm">{{ $product->price * $cart['quantity'] }}$</del>
                                                <span>{{ ($product->price - ($product->price * $cart['discount_percent'])) * $cart['quantity'] }}$</span>
                                            </td>
                                        @endif
                                        <td class="d-flex justify-content-center align-items-center pt-4">
                                            <a href="" class="btn btn-danger m-1">-</a>
                                            <form action="" method="post">
                                                @csrf
                                                <button class="btn btn-success m-1">+</button>
                                            </form>
                                        </td>
                                        <td class="text-center align-middle px-0">
                                            <form action="{{ route('cart.destroy',  $cart['id'] )}}" method="POST" id="delete-cart-{{$product->id}}">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <a href="#" onclick="event.preventDefault();document.getElementById('delete-cart-{{$product->id}}').submit()" class="shop-tooltip close float-none text-danger" >×</a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- / Shopping cart table -->
                <div class="d-flex flex-wrap justify-content-between align-items-center pb-4">
                    @if (Module::isEnable('Discount'))
                        @if ($discount = Modules\Cart\Helpers\Cart::getDiscountCode())
                            <div class="mt-4">
                                <form action="{{ route('discount.delete',  ['discount' => $discount->id] )}}" method="POST" id="delete-discount-{{$discount->id}}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" value="default" name="cart">
                                </form>
                                <div>کد تخفیف فعال:
                                    <span class="text-success">{{$discount->code}}</span>
                                    <a href="#" class="btn btn-danger btn-sm" onclick="event.preventDefault();document.getElementById('delete-discount-{{$discount->id}}').submit()">Delete</a>
                                </div>
                                <div>درصد تخفیف:
                                    <span class="text-success">%{{$discount->percent}}</span>
                                </div>
                            </div>
                        @else
                            @auth
                            <form action="{{ route('cart.discount.check') }}" method="POST" class="mt-4">
                                @csrf
                                <input type="hidden" value="default" name="cart">
                                <input type="text" name="discount" id="" class="form-control @error('discount') is-invalid @enderror" placeholder="کد تخفیف دارید؟">
                                <button type="submit" class="btn btn-success mt-3">اعمال کد تخفیف</button>
                                @error('discount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </form>
                            @endauth
                        @endif
                    @endif
                    <div class="d-flex">
{{--                        <div class="text-right mt-4 mr-5">--}}
{{--                            <label class="text-muted font-weight-normal m-0">Discount</label>--}}
{{--                            <div class="text-large"><strong>$20</strong></div>--}}
{{--                        </div>--}}
                        <div class="text-right mt-4">
                            <label class="text-muted font-weight-normal m-0">Cart Total Price</label>
                            @if (!$cart['discount_percent'])
                                @php
                                $totalPrice = Modules\Cart\Helpers\Cart::all()->sum(function ($cart) {
                                    return $cart['product']->price * $cart['quantity'];
                                })
                                @endphp
                                <div class="text-large"><strong>{{ $totalPrice }}$</strong></div>
                            @else
                                @php
                                $totalPrice = Modules\Cart\Helpers\Cart::all()->sum(function ($cart) {
                                    return($cart['product']->price - ($cart['product']->price * $cart['discount_percent'])) * $cart['quantity'];
                                })
                                @endphp
                                <div class="text-large"><strong>{{ $totalPrice }}$</strong></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="float-left">
                    <form action="{{ route('cart.payment') }}" method="post" id="cart-payment">
                        @csrf
                    </form>
                    <button onclick="document.getElementById('cart-payment').submit()" type="button" class="btn btn-lg btn-primary mt-2">پرداخت</button>
                </div>

            </div>
        </div>
    </div>
@endsection
