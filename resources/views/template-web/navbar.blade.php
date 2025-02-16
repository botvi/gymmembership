<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand me-lg-5 me-0" href="index.html">
            <img src="{{ asset('web') }}/images/logo.png" class="logo-image img-fluid" alt="templatemo pod talk">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-lg-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">Home</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('about') ? 'active' : '' }}" href="/about">About</a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ Request::is('pages/*') ? 'active' : '' }}" href="#" id="navbarLightDropdownMenuLink" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">Pages</a>
                
                    <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                        <li><a class="dropdown-item" href="/pages/listing">Listing Page</a></li>
                        <li><a class="dropdown-item" href="/pages/detail">Detail Page</a></li>
                    </ul>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('contact') ? 'active' : '' }}" href="/contact">Contact</a>
                </li>
                @guest
                <li class="nav-item ms-lg-4 mb-lg-0 mb-1">
                    <a class="btn custom-btn custom-border-btn smoothscroll {{ Request::is('login') ? 'active' : '' }}" href="/login">Login</a>
                </li>
                <li class="nav-item ms-lg-4 mb-lg-0 mb-1">
                    <a class="btn custom-btn custom-border-btn smoothscroll {{ Request::is('register') ? 'active' : '' }}" href="/register">Register</a>
                </li>
                @endguest

                @auth
                <li class="nav-item ms-lg-4 mb-lg-0 mb-1">
                    <a class="btn custom-btn custom-border-btn smoothscroll {" href="/logout">Logout</a>
                </li>
                <li class="nav-item ms-lg-4 mb-lg-0 mb-1">
                    <a class="nav-link" href="/profile">Profile {{ Auth::user()->nama }}</a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>