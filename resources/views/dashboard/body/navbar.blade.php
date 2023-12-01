<header class="navbar navbar-expand-md d-print-none" >
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('static/logo.svg') }}" width="110" height="32" alt="Tabler" class="navbar-brand-image">
            </a>
        </h1>
        <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                    <span class="avatar avatar-sm" style="background-image: url({{ Avatar::create(Auth::user()->name)->toBase64() }})"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="mt-1 small text-muted">{{ Auth::user()->email }}</div>
                    </div>

                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="./profile.html" class="dropdown-item">Profile</a>
                    <a href="./sign-in.html" class="dropdown-item">Logout</a>
                </div>
            </div>
        </div>
    </div>
</header>

<header class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar">
        <div class="container-xl">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <x-icon.home/>
                        </span>
                        <span class="nav-link-title">
                            {{ __('Dashboard') }}
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" /><path d="M12 12l8 -4.5" /><path d="M12 12l0 9" /><path d="M12 12l-8 -4.5" /><path d="M16 5.25l-8 4.5" /></svg>
                        </span>
                        <span class="nav-link-title">
                            {{ __('Inventaris') }}
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <x-icon.car/>
                        </span>
                        <span class="nav-link-title">
                            {{ __('Kendaraan') }}
                        </span>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <x-icon.star/>
                        </span>
                        <span class="nav-link-title">
                            {{ __('Lainnya') }}
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item" href="{{ route('offices.index') }}">
                                    {{ __('Kantor') }}
                                </a>
                                <a class="dropdown-item" href="./cookie-banner.html">
                                    {{ __('Brand') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>

            <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">
            <form action="#" method="get" autocomplete="off" novalidate>
                <div class="input-icon">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                </span>
                <input type="text" value="" class="form-control" placeholder="Search…" aria-label="Search in website">
                </div>
            </form>
            </div>
        </div>
        </div>
    </div>
</header>