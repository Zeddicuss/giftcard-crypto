@extends('layouts.lpartials')

@section('content')

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<body class="vh-100">
	<div class="authincation h-100">
		<div class="container h-100">
			<div class="row justify-content-center h-100 align-items-center">
				<div class="col-md-6">
                <div class="authincation-content">
        <div class="row no-gutters">
            <div class="col-xl-12">
                <div class="auth-form">
                    <div class="text-center mb-3">
                        <a href=""><img src="../images/logo/logo-full.png" alt=""></a>
                    </div>
                    <h4 class="text-center mb-4">Enter the code that was sent to your Email</h4>
                    <br>
                    <form action="{{route('verification.verify')}}" method = "POST">
                        @csrf
                        <div class="mb-3">
                            <label><strong>A code has been sent to your email address...</strong></label>
                            <input type="password" name = "verification_token" class="form-control" value="" placeholder="Verification Code">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-block">Verify</button>
                        </div>
                    </form>
                    <form action="{{ route('verification.resend') }}" method="POST">
                        @csrf
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-secondary btn-block">Resend Code</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>			</div>
		</div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if(session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: '<span style="color: white;">Success</span>',
                        html: '<span style="color: white;">{{ session('success') }}</span>',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 4000,
                        background: '#28a745', // Green background
                        iconColor: '#ffffff', // White icon
                    });
                @endif
                @if(session('error'))
                    Swal.fire({
                        icon: 'error',
                        title: '<span style="color: white;">Error</span>',
                        html: '<span style="color: white;">{{ session('error') }}</span>',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 4000,
                        background: '#dc3545', // Red background
                        iconColor: '#ffffff', // White icon
                    });
                @endif
            });
        </script>
	</div>
    
@endsection