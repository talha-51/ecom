{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EZone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center bg-light">
        <div class="card shadow border-0 w-100" style="max-width: 420px;">
            <div class="card-body p-4">

                <!-- Back Link -->
                <div class="mb-3">
                    <a href="{{ route('home.index') }}" class="text-decoration-none fs-5">&larr; Back</a>
                </div>

                <!-- Tabs -->
                <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a href="{{ route('login') }}">
                            <button class="nav-link active" id="login-tab" data-bs-toggle="pill" data-bs-target="#login"
                                type="button" role="tab">Login</button>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="{{ route('register') }}">
                            <button class="nav-link" id="register-tab" data-bs-toggle="pill" data-bs-target="#register"
                                type="button" role="tab">Register</button>
                        </a>
                    </li>
                </ul>

                <!-- Login Form -->
                <div class="tab-pane fade show active" id="login" role="tabpanel">
                    <h4 class="text-center mb-3">Welcome Back!</h4>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="loginEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="loginEmail" name="email"
                                value="{{ old('email') }}" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="loginPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="loginPassword" name="password"
                                placeholder="Enter your password" required>
                        </div>
                        @if ($errors->any())
                            <div class="mb-3 alert alert-danger text-center">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
