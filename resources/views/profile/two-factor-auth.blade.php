@extends('profile.master')

@section('section')
    <h2>Two Factor Auth:</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

    @endif
    <form action="{{ route('profile.2fa.manage') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="type">Type</label>
            <select name="type" id="type" class="form-control" >
                @foreach (config('twoFactor.type') as $key => $name)
                    <option  value="{{ $key }}" {{ old('type') === $key || auth()->user()->two_factor_auth === $key ? 'selected' : ''}}>{{ $name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" name="phone" id="phone" class="form-control" placeholder="add your phone number" value="{{ old('phone_number') ?? auth()->user()->phone_number}}">
        </div>
        <br>
        <div class="form-group">
            <button type="submit" class="btn btn-primary ">Update</button>
        </div>
</form>
@endsection
