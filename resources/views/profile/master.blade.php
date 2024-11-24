@extends('layouts.master')

@section('content')
    <div class="col-md-8">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-pills card-header-pills">
                            <li class="nav-item">
                                <a href="{{ url('/profile') }}" class="nav-link {{ request()->path() === 'profile' ? 'active' : ''}}">Index</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('profile.2fa.manage') }}" class="nav-link {{ request()->path() === 'profile/twofactor' ? 'active' : ''}}">Twofactor Auth</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        @yield('section')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
