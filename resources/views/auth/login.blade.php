<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login|{{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Phoenixcoded" />
    <link rel="icon" href="{{ asset('assets/images/LOGO-ICON.PNG ') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>
    <div class="auth-wrapper align-items-stretch aut-bg-img">
        <div class="flex-grow-1">
            <div class="auth-side-form">
                <div class=" auth-content">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('login.dashboard') }}">
                        @csrf
                        <h3 class="mb-4 f-w-400">Sign in</h3>
                        <div class="form-group mb-3">
                            <label class="floating-label" for="Email">Email address</label>
                            <input type="text" class="form-control" id="email" type="email" name="email">
                            @if ($error = $errors->first('email'))
                                <div class="alert alert-danger">
                                    {{ $error }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group mb-4">
                            <label class="floating-label" for="Password">Password</label>
                            <input type="password" class="form-control" id="password" type="password" name="password">
                            @if ($error = $errors->first('password'))
                                <div class="alert alert-danger">
                                    {{ $error }}
                                </div>
                            @endif
                        </div>
                        <button class="btn btn-block btn-dark mb-4">Login</button>
                        <div class="text-center">
                            <p class="mb-2 mt-4 text-muted">Forgot password? <a href="{{ route('password.request') }}"
                                    class="f-w-400">Reset</a></p>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/ripple.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
</body>

</html>
