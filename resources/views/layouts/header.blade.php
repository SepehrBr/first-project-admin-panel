<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <a class="navbar-brand" href="#!">Laravel Pro</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                {{-- <li class="nav-item"><a class="nav-link" href="{{ route('/about') }}">About</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('/contact') }}">Contact</a></li>
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{ route('/articles') }}">Blog</a></li> --}}
                <a class="btn btn-info mx-2" href="{{ url('/profile') }}">profile</a>
                <a class="btn btn-warning mx-2" href="{{ route('products') }}">Products</a>
                <a class="btn btn-primary mx-2" href="{{ url('admin') }}">users panel</a>
                @if (auth()->check())
                    {{-- <a href="/admin/articles" class="btn btn-primary mx-2">Admin</a> --}}
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="btn btn-danger mx-2">Log Out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-warning mx-2">Log In</a>
                @endif
            </ul>
        </div>

</nav>
