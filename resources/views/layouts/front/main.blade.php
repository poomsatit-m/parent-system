<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('page-title') :: {{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('front/assets/images/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('front/assets/fonts/inter/inter.css') }}" id="main-font-link" />
    <link rel="stylesheet" href="{{ asset('front/assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('front/assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('front/assets/css/style-preset.css') }}">

    @stack('styles')
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr"
    data-pc-theme="light">
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <nav class="pc-sidebar">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="#" class="b-brand text-primary">
                    <span class="badge bg-light-info rounded-pill ms-2">{{ env('APP_NAMESUB') }}</span>
                    <span class="badge bg-light-success rounded-pill ms-2">{{ env('APP_VERSION') }}</span>
                </a>
            </div>
            <div class="navbar-content">
                <div class="card pc-user-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('front/assets/images/user/avatar-1.jpg') }}" alt="user-image"
                                    class="user-avtar wid-45 rounded-circle" />
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">{{ auth()->user()->name }}</h6>

                            </div>
                        </div>
                    </div>
                </div>
                <ul class="pc-navbar">
                    <li class="pc-item pc-caption"><label>Menu</label></li>
                    @if (session('studentdoce') != null)
                        <li class="pc-item">
                            <a href="{{ route('school.dashboard') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                                <span class="pc-mtext">Dashboard</span>
                            </a>
                        </li>

                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <header class="pc-header">
        <div class="header-wrapper">
            <div class="me-auto pc-mob-drp">
                <ul class="list-unstyled">
                    <li class="pc-h-item pc-sidebar-collapse"><a href="#" class="pc-head-link ms-0"
                            id="sidebar-hide"><i class="ti ti-menu-2"></i></a></li>
                    <li class="pc-h-item pc-sidebar-popup"><a href="#" class="pc-head-link ms-0"
                            id="mobile-collapse"><i class="ti ti-menu-2"></i></a></li>
                </ul>
            </div>
            <div class="ms-auto">
                <ul class="list-unstyled">
                    <li class="dropdown pc-h-item">
                        <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                            role="button">
                            <img src="{{ asset('front/assets/images/user/avatar-2.jpg') }}" alt="user-image"
                                class="user-avtar" />
                            <span class="ms-2">{{ auth()->user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="ti ti-power"></i> <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="pc-container">
        <div class="pc-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                @yield('breadcrumb')
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h4 class="mb-0">@yield('page-title')</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @yield('content')
        </div>
    </div>

    <footer class="pc-footer">
        <div class="footer-wrapper container-fluid">
            <div class="row">
                  <div class="row">
                <div class="col my-1"><p class="m-0">© {{ date('Y') }} - {{ config('app.name') }}  <span class="badge bg-light-success rounded-pill ms-2">{{ env('APP_VERSION') }}</span></p></div>
            </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('front/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('front/assets/js/script.js') }}"></script>
    <script src="{{ asset('front/assets/js/theme.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/feather.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        layout_caption_change('true');
        layout_rtl_change('false');
        preset_change("preset-1");
    </script>

    @stack('scripts')
</body>

</html>
