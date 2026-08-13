<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">
    @css('css/theme.css')
    @css('css/admin.css')
</head>
<body>
    <div class="login-wrap">
        <div class="login-card">

            <div class="login-logo">
                <div class="login-mark">AN</div>
            </div>

            <h1>Admin Panel</h1>
            <p class="sub">Sign in to manage your portfolio</p>

            @if (session('error'))
                <div class="alert alert-error">⚠ {{ session('error') }}</div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">✓ {{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}">
                @csrf

                <div class="field">
                    <label for="email">Email Address</label>
                    <input id="email"
                           class="input"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="admin@ahsannawaz.dev"
                           required
                           autofocus
                           autocomplete="username">
                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input id="password"
                           class="input"
                           type="password"
                           name="password"
                           placeholder="••••••••"
                           required
                           autocomplete="current-password">
                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label class="check">
                        <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                        <span>Keep me signed in</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary full">Sign In →</button>
            </form>

        </div>
    </div>
</body>
</html>
