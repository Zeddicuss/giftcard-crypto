@extends('layouts.lpartials')

@section('content')
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
                    <h4 class="text-center mb-4">Sign into your account</h4>
                    <form action="{{url('/login')}}" method="POST" id="loginForm">
                        {{-- <div class="mb-3">
                            <label class="mb-1"><strong>Username</strong></label>
                            <input type="text" class="form-control" placeholder="username">
                        </div> --}}
                        @csrf
                        <div class="mb-3">
                            <label class="mb-1"><strong>Email</strong></label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="hello@example.com">
                        </div>
                        <div class="mb-3">
                            <label class="mb-1"><strong>Password</strong></label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-block" style="background-color: #19066B;">Sign in</button>
                            <script>
                                function validateForm(event) {
                                    event.preventDefault();
                                    
                                    var email = document.getElementById("email").value.trim();
                                    var password = document.getElementById("password").value.trim();
                            
                                    // Required field validation
                                    if (!email || !password) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'All fields are required!',
                                        });
                                        return;
                                    }
                            
                                    // Email validation
                                    if (!isValidEmail(email)) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Please enter a valid email address!',
                                        });
                                        return;
                                    }
                            
                                    // Submit the form if validations pass
                                    event.target.submit();
                                }
                            
                                function isValidEmail(email) {
                                    // Basic email validation using regex
                                    var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                                    return regex.test(email);
                                }
                            
                                // // Attach validateForm function to form's onsubmit event
                                // document.getElementById('loginForm').onsubmit = validateForm;
                            
                                // // SweetAlert Notifications from the server
                                // @if (session('error'))
                                //     Swal.fire({
                                //         icon: 'error',
                                //         title: 'Error',
                                //         text: '{{ session('error') }}',
                                //     }).then((result) => {
                                //         if (result.isConfirmed) {
                                //             window.location.href = "{{ url('/') }}";
                                //         }
                                //     });
                                // @elseif (session('success'))
                                //     Swal.fire({
                                //         icon: 'success',
                                //         title: 'Success!',
                                //         text: '{{session('success')}}',
                                //     }).then((result) => {
                                //         if (result.isConfirmed) {
                                //             window.location.href = "{{ route('dashboard') }}";
                                //         }
                                //     });
                                // @endif
                            </script>
                        </div>
                    </form>
                    <div class="new-account mt-3">
                        <p>Don't have an account? <a class="text-primary" href="{{route('signup')}}">Sign up</a></p>
                    </div>
                    <div class="new-account mt-3">
                        <p>Forgot Password? <a class="text-primary" href="{{route('reset.password')}}">Reset Password</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>			
</div>
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

	