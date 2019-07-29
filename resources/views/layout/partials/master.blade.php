<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    @include('layout.partials.head')
    <title>@yield('title',config('app.name'))</title>
    @yield('head')
</head>

<body id="commerce">
    @include('layout.partials.navbar')
    @yield('content')

    @include('layout.partials.footer')
    @yield('footer')
</body>

</html>