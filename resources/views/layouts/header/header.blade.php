<header>
  <nav class="navbar navbar-expand-lg bg-light">
      <div class="container">
        <a class="navbar-brand" href="{{ route('ad.index') }}">{{ config('app.name', 'usedThings') }}</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      @auth
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li>
              <a href="{{ route('ad.create') }}" title="Create you own Ad">Create Ad</a>
            </li>
          </ul>
        </div>
      @endauth
    </div>
  </nav>
</header>
@if($errors->any())
  <div class="alert alert-warning" role="alert">
    {{$errors->first()}}
  </div>
@endif 