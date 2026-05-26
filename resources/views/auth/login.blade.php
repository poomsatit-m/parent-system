<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>@yield('page-title') :: {{ config('app.name') }}</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
        content="Able Pro is a trending dashboard template built with the Bootstrap 5 design framework. It is available in multiple technologies, including Bootstrap, React, Vue, CodeIgniter, Angular, .NET, and more.">
    <meta name="keywords"
        content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard">
    <meta name="author" content="Phoenixcoded">

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('front/assets/images/favicon.svg') }}" type="image/x-icon">
    <!-- [Font] Family -->
    <link rel="stylesheet" href="{{ asset('front/assets/fonts/inter/inter.css') }}" id="main-font-link" />
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('front/assets/fonts/tabler-icons.min.css') }}">
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('front/assets/fonts/feather.css') }}">
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('front/assets/fonts/fontawesome.css') }}">
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('front/assets/fonts/material.css') }}">
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('front/assets/css/style-preset.css') }}">
</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr"
    data-pc-theme_contrast="" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <div class="auth-main">
        <div class="auth-wrapper v1">
            <div class="auth-form">
                <div class="card my-5" style="border-radius: 12px; border: none; box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h4 class="f-w-500 mb-2">เข้าสู่ระบบ</h4>
                            <h5 class="f-w-500 text-muted mb-1">{{ config('app.name') }}</h5>
                            <small class="text-muted d-block">สำหรับบุคลากรสำนักวิทยบริการและเทคโนโลยีสารสนเทศ</small>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.pkru') }}" class="space-y-4">
                            @csrf

                            <div class="form-group mb-3">
                                <input type="text"
                                    class="form-control @error('username') is-invalid @enderror"
                                    name="username"
                                    placeholder="Username"
                                    value="{{ old('username') }}"
                                    required>
                                @error('username')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <input type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password"
                                    placeholder="Password"
                                    required>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="customCheckc1" name="remember">
                                    <label class="form-check-label text-muted" for="customCheckc1">Remember me?</label>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-md">Login</button>
                            </div>

                        </form>

                        <div class="text-center mt-4">
                            <small class="text-muted">@ {{ env('APP_NAMESUB') }}
                                <span class="badge bg-light-success rounded-pill ms-2">{{ env('APP_VERSION') }}</span>
                            </small>
                            <div class="mt-2">
                                <a href="https://www.pkru.ac.th" class="text-decoration-none text-primary small">มหาวิทยาลัยราชภัฏภูเก็ต</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
    <!-- Required Js -->
    <script src="{{ asset('front/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('front/assets/js/script.js') }}"></script>
    <script src="{{ asset('front/assets/js/theme.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/feather.min.js') }}"></script>
    <!-- Buy Now Link Script -->
    <script defer src="https://fomo.codedthemes.com/pixel/CDkpF1sQ8Tt5wpMZgqRvKpQiUhpWE3bc"></script>

</body>
<!-- [Body] end -->

</html>









    <script>
        change_box_container('false');
    </script>


    <script>
        layout_caption_change('true');
    </script>




    <script>
        layout_rtl_change('false');
    </script>


    <script>
        preset_change("preset-1");
    </script>

</body>
<!-- [Body] end -->

</html>
