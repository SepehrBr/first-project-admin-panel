@extends('layouts.master')

@section('content')
    <div class="col-md-8">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>two factor auth</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('2fa.token') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="token" class="col-form-label">Token</label>
                                <input type="text" name="token" id="token" placeholder="enter your token" class="form-control @error('token') is-invalid @enderror">
                                @error('token')
                                    <span class="invalid-feedbacl">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Validate</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
