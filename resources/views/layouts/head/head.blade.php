<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('metaTitle')</title>
    @include('parts.head._css')
    @include('parts.head._js')
    @stack('headCss')
    @stack('headJs')
</head>