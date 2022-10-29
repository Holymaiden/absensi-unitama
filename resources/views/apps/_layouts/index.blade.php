<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Absensi Akba</title>
    <link rel="icon" type="image/x-icon" href="{{ url('images/akba.png') }}">

    @stack('cssScript')

</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>

            @include('apps._layouts.header')

            <!-- Main Content -->
            <div style="padding-left:30px;padding-right: 30px;padding-top: 80px;width: 100%;position: relative">
                @yield('content')
            </div>
            <!-- End Main Content -->

            @include('apps._layouts.footer')

        </div>
    </div>

    @stack('jsScript')

    @stack('jsScriptAjax')

</body>

</html>
