<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.head.head')
<body>
    @include('layouts.header.header')
    
    @yield('main')

    @include('layouts.footer.footer')
    @stack('bottomJs')
</body>
</html>