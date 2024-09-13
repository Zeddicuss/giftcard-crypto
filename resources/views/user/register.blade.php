@extends('layouts.lpartials')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session("success") }}',
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session("error") }}',
        });
    </script>
@endif
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6">
                <div class="authincation-content">
                    <div class="row no-gutters">
                        <div class="col-xl-12">
                            <div class="auth-form">
                                <div class="text-center mb-3">
                                    <a href="#"><img src="../images/logo/logo-full.png" alt=""></a>
                                </div>
                        <h4 class="text-center mb-4">Sign up your account</h4>
                        <form action="{{url('/register')}}" method="POST" id="registrationForm">
                        @csrf
                        <div class="mb-3">
                            <label class="mb-1"><strong>First Name</strong></label>
                            <input type="text" id="firstname" name="firstname" class="form-control" placeholder="First Name">
                        </div>
                        <div class="mb-3">
                            <label class="mb-1"><strong>Last Name</strong></label>
                            <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Last Name">
                        </div>
                        <div class="mb-3">
                            <label class="mb-1"><strong>Email</strong></label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="hello@example.com">
                        </div>
                        <div class="mb-3">
                            <label class="mb-1"><strong>Password</strong></label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="mb-3">
                            <label class="mb-1"><strong> Confirm Password</strong></label>
                            <input type="password" id="confirm_password" name ="confirm_password" class="form-control" placeholder="Password">
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" onclick="validateForm()" class="btn btn-primary btn-block">Sign me up</button>
                            <script>
                                function validateForm(event) {
                                    event.preventDefault();
                                    
                                    var firstname = document.getElementById("firstname").value.trim();
                                    var lastname = document.getElementById("lastname").value.trim();
                                    var email = document.getElementById("email").value.trim();
                                    var password = document.getElementById("password").value.trim();
                                    var confirm_password = document.getElementById("confirm_password").value.trim();
                            
                                    // Required field validation
                                    if (!firstname || !lastname || !email || !password || !confirm_password) {
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
                            
                                    // Password validation
                                    if (password !== confirm_password) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Passwords do not match!',
                                        });
                                        return;
                                    }
                            
                                    // If all validations pass
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Great!',
                                        text: 'Registration successful!',
                                    }).then(() => {
                                        document.getElementById("registrationForm").submit();
                                    });
                                }
                            
                                function isValidEmail(email) {
                                    // Basic email validation using regex
                                    var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                                    return regex.test(email);
                                }
                            
                                // Attach validateForm function to form's onsubmit event
                                document.getElementById('registrationForm').onsubmit = validateForm;
                            </script>
                        </div>
                    </form>
                    <div class="new-account mt-3">
                        <p>Already have an account? <a class="text-primary" href="{{route('login.form')}}">Sign in</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>			
</div>
</div>
</div>
@endsection
