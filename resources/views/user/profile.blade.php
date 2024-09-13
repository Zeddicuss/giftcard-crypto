@extends('layouts.partial')

@section('content')
@include('sweetalert::alert')
        <!--**********************************
            Content body start
        ***********************************-->
<div class="content-body default-height ">
	<div class="container-fluid">
		<h4 class="font-w700">Profile</h4>
		<div class="row">
			<div class="col-xl-16">
				@auth
				<div class="row">
					<div class="col-xl-16 col-md-16">
						<div class="card justify-content-center">
							<div class="card-body d-flex">
								<div class="d-block">
									@if (Auth::user()->photo) <img src="{{ asset('storage/' . Auth::user()->photo) }}" class="avatar avatar-xxl" alt="">
									@else
									<img src="../images/profile/pic1.jpg" class="avatar avatar-xxl" alt="">
									@endif
								</div>
								<div class="w-100 ps-4">
									<div class="d-flex justify-content-between">
										<div class="">
											<h4 class="font-w700"> {{ Auth::user()->firstname }}&nbsp;{{ Auth::user()->lastname }} </h4>
											@php
											$user = Auth::user();
											$addressData = json_decode($user->address, true); // Decode JSON to an array
											$country = (isset($addressData['country'])) ? $addressData['country'] : null;
											@endphp
											<span>{{ $country }} </span>
										</div>
										<div class="d-flex">
											<div class="icon-box icon-box-sm bg-primary">
												<a href="#" data-bs-toggle="modal" data-bs-target="#editProfile" onclick="viewUserDetails({{ $user->id }})">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
														xmlns="http://www.w3.org/2000/svg">
														<path
															d="M12 3C7.05 3 3 7.05 3 12C3 16.95 7.05 21 12 21C16.95 21 21 16.95 21 12C21 7.05 16.95 3 12 3ZM12 19.125C8.1 19.125 4.875 15.9 4.875 12C4.875 8.1 8.1 4.875 12 4.875C15.9 4.875 19.125 8.1 19.125 12C19.125 15.9 15.9 19.125 12 19.125Z"
															fill="white"></path>
														<path
															d="M16.3503 11.0251H12.9753V7.65009C12.9753 7.12509 12.5253 6.67509 12.0003 6.67509C11.4753 6.67509 11.0253 7.12509 11.0253 7.65009V11.0251H7.65029C7.12529 11.0251 6.67529 11.4751 6.67529 12.0001C6.67529 12.5251 7.12529 12.9751 7.65029 12.9751H11.0253V16.3501C11.0253 16.8751 11.4753 17.3251 12.0003 17.3251C12.5253 17.3251 12.9753 16.8751 12.9753 16.3501V12.9751H16.3503C16.8753 12.9751 17.3253 12.5251 17.3253 12.0001C17.3253 11.4751 16.8753 11.0251 16.3503 11.0251Z"
															fill="white"></path>
													</svg>
												</a>
											</div>
										</div>

									</div>
									<div class="d-flex flex-wrap pt-4">
										<div class="d-flex align-items-center pe-4 mb-2">
											<div class="pe-2">
												<i class="material-icons" style="color: #F79F19;">mail</i>
											</div>
											<h5 class="font-w400 mb-0">{{Auth::user()->email}}</h5>
										</div>
										<p>
										<div class="d-flex align-items-center pe-4 mb-2">
											<div class="pe-2">
												<i class="material-icons" style="color:#FF5B5B;">phone</i>
											</div>
											<h5 class="font-w400 mb-0">{{Auth::user()->phone}}</h5>
										</div>
										</p>
										<br>
										<div class="d-flex align-items-center pe-4 mb-2">
											<div class="pe-2">
												<i class="material-icons" style="color:#00A389;">person</i>
											</div>
											@php
											$address = json_decode(Auth::user()->address, true); // Decode to associative array
											@endphp
											<h5 class="font-w400 mb-0">
												@if(isset($address) && is_array($address))
													{{ $address['street'] ?? 'N/A' }}, {{ $address['state'] ?? 'N/A' }}, {{ $address['country'] ?? 'N/A' }}
												@else
													Address not available
												@endif
											</h5>
										</div>
									</div>
									<div class="d-flex flex-wrap pt-4">
										<div class="d-flex align-items-center pe-4 mb-2">
											<div class="pe-2">
												<i class="material-icons verification-icon" 
												style="color: {{ Auth::user()->verification_status === 'Verified' ? 'green' : 
												   (Auth::user()->verification_status === 'Pending' ? 'orange' : 
												    (Auth::user()->verification_status === 'Rejected' ? 'red' : 'red')) }}">
												{{ Auth::user()->verification_status === 'Verified' ? 'verified' : 
													(Auth::user()->verification_status === 'Pending' ? 'hourglass_empty' : 
														(Auth::user()->verification_status === 'Rejected' ? 'cancel' : 'not_verified')) 
													}}
												</i>
											</div>
											<h5 class="font-w400 mb-0"><b>{{Auth::user()->verification_status}}</b></h5>
										</div>
										<div class="d-flex align-items-center pe-4 mb-2">
											<div class="pe-2">
												<!-- For male -->
												<i class="material-icons gender-icon">male</i>

												<!-- For female -->
												<i class="material-icons gender-icon" style="color: crimson;">{{Auth::user()->gender}}</i>
											</div>
											<h5 class="font-w400 mb-0">Male</h5>
										</div>
										<div class="d-flex align-items-center pe-4 mb-2">
											<div class="pe-2">
												<i class="material-icons verification-icon" style="color: blue;">date_range</i>
											</div>
											@php
											$dob = Carbon\Carbon::parse(Auth::user()->date_of_birth);
											@endphp
											<h5 class="font-w400 mb-0"><b>{{ $dob->format('j M Y') }}</b></h5>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				@endauth
			</div>
		</div>
	<br>
	<div class="row">
		<div class="col-xl-16">
			<h4 class="font-w700">Security Settings</h4>
			<div class="row">
				<div class="col-xl-16 col-md-16">
					<div class="card justify-content-center">
						<div class="card-body d-flex">
							<div class="mb-2 col-md-6">
								<form action="{{route('fa.status')}}" method="POST" enctype="multipart/form-data">
									@csrf
									<label class="form-label">2 Factor Authentication</label>
									<select name="2fa_enabled" class="default-select form-control wide bleft">
										<option value="1" {{ auth()->user()->{'2fa_enabled'} ? 'selected' : '' }}>ON</option>
										<option value="0" {{ !auth()->user()->{'2fa_enabled'} ? 'selected' : '' }}>OFF</option>
									</select>
								<br>
								&nbsp;
								&nbsp;
								<p><button type="submit" class="btn btn-outline-secondary btn-xs"><span class="btn-icon-start text-secondary"><i
                                    class="fa fa-lock"></i>
                                    </span>Save</button></p>
								</form>
								
								<p><button type="button" class="btn btn-outline-secondary btn-xs" data-bs-toggle="modal"
                                data-bs-target="#changePass"><span class="btn-icon-start text-secondary"><i
                                    class="fa fa-lock"></i>
                                    </span>Change Password</button></p>
							</div>
							<br>
							<div class= "mb-2 col-md-6><button">
								
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="editProfile" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Update Profile</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

		<form method="POST" action="{{route('profile.update')}}" enctype="multipart/form-data" id="editUserForm">
			@csrf
			<div class="modal-body">
				<label class="form-label d-block mt-3">First Name</label>
				<input type="text" name="firstname" id="firstname" class="form-control w-100" placeholder="First Name">
				@error('firstname')
                	<div>{{ $message }}</div>
                @enderror

				<label class="form-label d-block mt-3">Last Name</label>
				<input type="text" name="lastname" id="lastname" class="form-control w-100" placeholder="Last Name">
				@error('lastname')
                	<div>{{ $message }}</div>
                @enderror

				<label class="form-label d-block mt-3">Street Address</label>
				<input type="text" name="address[street]" id="street" class="form-control w-100" placeholder="Street Address">
				@error('address')
                	<div>{{ $message }}</div>
                @enderror
				
				<label class="form-label d-block mt-3">State/Province</label>
            	<input type="text" name="address[state]"  id="state" class="form-control" placeholder="State/Province">
				@error('address')
                	<div>{{ $message }}</div>
                @enderror

				<label class="form-label d-block mt-3">Country</label>
					<select name="address[country]" id="country" class="form-control">
						<option value="" selected>Select Country</option>
						<option value="">United States</option>
						<option value="">United Kingdom</option>
						<option value="">Nigeria</option>
						<option value="">Ghana</option>
						<option value="">South Africa</option>
						<option value="">Sierra Leone</option>
						<option value="">Kenya</option>
					</select>
					@error('address')
                		<div>{{ $message }}</div>
                	@enderror

					<label class="form-label d-block mt-3">Gender</label>
					<select id="gender" class="form-control" name="gender">
						<option value="male">Male</option>
						<option value="female">Female</option>
					</select>
					@error('gender')
                		<div>{{ $message }}</div>
                	@enderror

					<label class="form-label d-block mt-3">Date Of Birth</label>
					<input type="date" name="date_of_birth" id="date_of_birth" class="form-control w-100" placeholder="Date of Birth">
					@error('date_of_birth')
                		<div>{{ $message }}</div>
                	@enderror

					<label class="form-label d-block mt-3">Email (Optional, Only if you want to change your mail)</label>
					<input type="text" name="email" id="email" class="form-control w-100" placeholder="Email">
					@error('email')
                		<div>{{ $message }}</div>
                	@enderror

					<label class="form-label d-block mt-3">Phone Number</label>
					<input type="text" name="phone" id="phone" class="form-control" placeholder="Enter phone number">
						@error('phone')
                			<div>{{ $message }}</div>
                		@enderror

				<label class="form-label d-block mt-3">Change Picture</label>
				<div class="mb-3">
					<img id="currentPhoto" src="#" alt="Current Profile Picture" class="img-thumbnail" style="display: none; max-width: 150px;">
				</div>
				<input class="form-control" name="photo" id="photo" type="file" placeholder="Upload Profile Picture">
				@error('photo')
                	<div>{{ $message }}</div>
                @enderror
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save changes</button>
			</div>
		</form>
		</div>
	</div>
</div>		
<div class="modal fade" id="changePass" tabindex="-1" aria-labelledby="accountDetailsLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
		<form method="POST" action="{{route('pass.change')}}" enctype="multipart/form-data">
			@csrf
			<div class="modal-body">
				<label class="form-label d-block mt-3"><strong>Old Password</strong></label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Old Password">

				<label class="form-label d-block mt-3"><strong>New Password</strong></label>
				<input type="password" id="new_password" name="new_password" class="form-control" placeholder="New Password">

				<label class="form-label d-block mt-3"><strong>Confirm Password</strong></label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm Password">

			<div class="modal-footer">
				<button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Change Password</button>
			</div>
		</form>
		</div>
	</div>
</div>
<script>
	function viewUserDetails(id){
		$.ajax({
			url: '/profile/' + id + '/edit',
			type: 'GET',
			success: function(data){
				console.log("Setting Values:", data);

				$('#editUserForm').attr('action', '/profile/update');
				const parsedAddress = JSON.parse(data.address);

				$('#street').val(parsedAddress.street);
				$('#state').val(parsedAddress.state);
				$('#country').val(parsedAddress.country);
				$('#firstname').val(data.firstname);
				$('#lastname').val(data.lastname);
				$('#gender').val(data.gender);
				$('#date_of_birth').val(data.date_of_birth);
				$('#email').val(data.email);
				$('#phone').val(data.phone);

				if(data.photo) {
					$('#currentPhoto').attr('src', '/storage/' + data.photo).show();
				} else {
					$('#currentPhoto').hide();
				}

				$('#editProfile').modal('show');
			},
			error: function(){
				alert('Failed to fetch user details.');
			}
		});
	}
</script>
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
				timer: 3000,
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
				timer: 3000,
				background: '#dc3545', // Red background
				iconColor: '#ffffff', // White icon
			});
		@endif
	});
</script>	
</div>    
        <!--**********************************
            Content body end
        ***********************************-->
    @endsection
      