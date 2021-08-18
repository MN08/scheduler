<!DOCTYPE html>
<html lang="id">
<head>
    @include('scheduler.layouts.meta')
    @include('scheduler.layouts.css')
    @stack('page-css')

</head>
<body>
    <div id="wrapper">
        @include('scheduler.layouts.sidebar')
        @include('scheduler.layouts.header')

        <section id="middle">
            @yield('content')
        </section>
    </div>

    @include('scheduler.layouts.js')
    @stack('page-js')

</body>
</html>
