<!DOCTYPE html>
<html>
<head>
    @include('scheduler.layouts.meta')
    @include('scheduler.layouts.css')
    @stack('page-css')

</head>
<body>
    <div class="d-md-flex fullheight-m align-items-center login-full-bg" style="background-image: url('{{ asset('assets/images/bg_login.jpg') }}')">

        <div class="col-md-4 padding-0 bg-white fullheight-m loginarea">
            <div class="d-md-flex align-items-center fullheight-m padding-6 justify-content-center">
                <div class="pt-5 pb-5 text-center fullwidth">
                    <div>
                        <img src="{{ asset('assets/images/logo_dark_stacked.png') }}" class="logo-login">
                    </div>

                    @yield('content')

                    <div>
                        Copyright &copy; scheduler {{ date('Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
