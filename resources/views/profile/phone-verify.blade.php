@extends('layouts.master')

@section('content')
    <div class="col-md-8">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-pills card-header-pills">
                            <h2>phone verify</h2>
                        </ul>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.2fa.phone') }}" method="post">
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
