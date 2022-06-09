@guest
    <form action="{{ route('auth.signIn') }}" class="d-flex" method="POST">
        <fieldset>
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Your username</label>
                <input 
                    type="username" 
                    name="username" 
                    id="username" 
                    class="form-control form-control-sm @error('username') is-invalid @enderror"
                    value="{{ old('username') }}"
                required>
                @error('username')
                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Your password</label>
                <input type="password" name="password" id="password" class="form-control form-control-sm me-1" minlength="8" required>
                @error('password')
                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <button class="btn btn-outline-secondary btn-sm text-nowrap" type="sybmit" id="signin">Sign in</button>
        </fieldset>
    </form>
    <ul class="list-inline pt-3">
        <li class="list-inline-item">
            <a href="{{ \App\Http\Controllers\Oauth\FacebookController::getRequestOauthLink() }}">
                <i class="bi bi-facebook"></i>
            </a>
            
        </li>
    </ul>
@endguest
@auth
    <p>
        Hi {{ auth()->user()->username ?? '' }}
    </p>
    <ul>
        <li>
            <a href="#">my profile</a>
        </li>
        <li>
            <a href="#">my ads</a>
        </li>
        <li>
            <small>
                <a href="{{ route('auth.logOut') }}" rel="nofollow">
                    logout
                </a>
            </small>
        </li>
    </ul>
@endauth

