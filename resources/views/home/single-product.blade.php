@extends('layouts.master')

@section('script')
    <script>
        // $('#sendComment').on('show.bs.modal', function (event) {
        //     var button = $(event.relatedTarget);

        //     var modal = $(this)
        // })

        let addNewComment = document.querySelector('#addNewComment').addEventListener('click', function (e) {
            console.log(e)
        })

        let replyTo = document.querySelector('#replyTo').addEventListener('click', function (e) {
            console.log(e)
        })

        // if you want to send in ajax use as below
            /*
            document.getElementById('sendCommentForm').addEventListener('submit', function (e) {
                e.preventDefault();
                let target = e.target;
                let data = {
                    commentable_id: target.querySelector('input[name="commentable_id"]'),
                    commentable_type: target.querySelector('input[name="commentable_type"]'),
                    parent_id: target.querySelector('input[name="parent_id"]'),
                    comment: target.querySelector('textarea[name="comment"]')
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN' : document.head.querySelector('meta[name=""csrf-token"]').content,
                        'Content-Type' : 'application/json'
                    }
                })
                $.ajax({
                    type: 'POST',
                    url: '/comments',
                    data: JSON.stringfy(data),
                    success : function (data) {
                        console.log(data)
                    }
                })
            });*/
    </script>
@endsection


@section('content')
<div class="col-lg-8">
    <div class="card-body">
        <form action="{{route('send.comment')}}" method="POST" id="sendCommentForm">
            @csrf
            <h5 class="form-text" id="exampleModalLabel">Send Comment</h5>
            <div class="form-group">
                <input class="form-control" type="hidden" name="commentable_id" value="{{ $product->id }}">
                <input class="form-control" type="hidden" name="commentable_type" value="{{ get_class($product) }}">
                <input class="form-control" type="hidden" name="parent_id" value="0">
                <div class="form-group">
                    <label for="message-text" class="col-form-label">Comment</label>
                    <textarea name="comment" id="message-text" class="form-control mb-3"></textarea>
                </div>
            </div>
            <div class="form-group mb-4 d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" >Send Comment</button>
            </div>
        </form>
    </div>
    <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            {{$product->title}}
                            @if (Modules\Cart\Helpers\Cart::count($product) < $product->inventory)
                                <form action="{{ route('cart.add', ['product' => $product->id]) }}" method="post">
                                    @csrf
                                    <button class="btn btn-danger mt-3">Add To Cart</button>
                                </form>
                            @endif
                        </div>
                        <div class="card-body">
                            {{$product->description}}
                        </div>
                    </div>
                </div>
            {{-- comments --}}
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="mt-4">Comments</h4>
                        @auth
                            <span class="btn btn-sm btn-primary" id="addNewComment">Add New Comment</span>
                        @endauth
                    </div>

                    @guest
                        <div class="alert alert-warning">Unable to Send Comments! please Login First</div>
                    @endguest

                    @include('layouts.comments', [ 'comments' => $product->comments()->where('approved', 0)->where('parent_id', 0)->get()])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
