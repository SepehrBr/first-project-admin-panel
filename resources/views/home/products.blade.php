@extends('layouts.master')

@section('content')
    <div class="col-lg-8">
        @foreach ($products->chunk(4) as $row)
            <div class="row">
                @foreach ($row as $product)
                    <div class="col-sm-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                            <h5 class="card-title">{{$product->title}}</h5>
                            <p class="card-text">{{$product->description}}</p>
                            <a href="/products/{{$product->id}}" class="btn btn-primary">Details</a>
                            @if (Modules\Cart\Helpers\Cart::count($product) < $product->inventory)
                                <form action="{{ route('cart.add', ['product' => $product->id]) }}" method="post">
                                    @csrf
                                    <button class="btn btn-danger mt-3">Add To Cart</button>
                                </form>
                            @endif
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">{{$product->view_count}}</small>
                              </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach

    </div>
@endsection
