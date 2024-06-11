<!DOCTYPE html>
<html lang="en">
    <head>
        <title>RESETPASSWORD| DIT-IMS</title>
        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="" />
        <meta name="keywords" content="">
        <meta name="author" content="Phoenixcoded" />
        <!-- Favicon icon -->
        <link rel="icon" href="{{ asset('assets/images/LOGO-ICON.PNG ') }}" type="image/x-icon">
        <!-- vendor css -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    </head>

<!-- [ signin-img ] start -->
<div class="auth-wrapper align-items-stretch aut-bg-img">
	<div class="flex-grow-1">
        <div class="h-100 d-md-flex align-items-center auth-side-img">
            <div class="col-sm-10 auth-content w-auto">
                <img src="{{ asset('assets/images/auth/GAF logo corrected.png') }}" alt="LOGO" class="img-fluid"
                    width="750px">
                <h1 class="text-white my-4">DIT-INVENTORY-MANAGEMENT SYSTEM.</h1>
            </div>
        </div>
		<div class="auth-side-form">
			<div class=" auth-content">
                <form method="POST" action="{{ route('password.update.reset') }}">
                    @csrf
				<div class="mb-4">
					<h4 class="mb-4 f-w-400">Reset your password</h4>
					<div class="form-group mb-3">
						<label class="floating-label" for="Password1">Email</label>
						<input  id="email" class="form-control" type="email" name="email" :value="old('email', $request->email)" required autofocus>
					</div>
					<div class="form-group mb-3">
						<label class="floating-label" for="Password2">New Password</label>
						<input type="password" class="form-control" id="password" name="password" required autocomplete="new-password">
					</div>
					<div class="form-group mb-4">
						<label class="floating-label" for="Password3">Re-Type New Password</label>
						<input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password">
					</div>
				</div>
				<button class="btn btn-block btn-primary mb-4">{{ __('Reset Password') }}</button>
                </form>
			</div>
		</div>
	</div>
</div>
<!-- [ signin-img ] end -->
 <!-- Required Js -->
 <script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
 <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
 <script src="{{ asset('assets/js/ripple.js') }}"></script>
 <script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
</body>
</body>
</html>
