@extends('index')

@section('main')
    <main class="container pt-3">
        <div class="row">
            <section class="content col-9">
                <h1>@yield('title')</h1>
                @yield('content')
            </section>
            <section class="sidebar col-3 mt-5">
                @include('parts._auth')
            </section>
        </div>
    </main>
@endsection