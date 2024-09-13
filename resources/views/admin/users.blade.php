@extends('layouts.partial')
@section('content')
<div class="content-body default-height ">
    <div class="container-fluid">
        <div class="row">
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Users</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div><button type="button" class="btn btn-outline-secondary btn-xs" data-bs-toggle="modal"
                    data-bs-target="#addUser"><span class="btn-icon-start text-secondary"><i
                        class="fa fa-plus"></i>
                        </span>Add Users</button>
                </div>
                <table class="table table-responsive-md">
                    <thead>
                        <tr>
                            <th style="width:50px;">
                                <div class="form-check custom-checkbox checkbox-success check-lg me-3">
                                    <input type="checkbox" class="form-check-input" id="checkAll" required="">
                                    <label class="form-check-label" for="checkAll"></label>
                                </div>
                            </th>
                            <th><strong>S/N</strong></th>
                            <th><strong>NAME</strong></th>
                            <th><strong>D O B</strong></th>
                            <th><strong>ADDRESS</strong></th>
                            <th><strong>GENDER</strong></th>
                            <th><strong>EMAIL</strong></th>
                            <th><strong>PHONE</strong></th>
                            <th><strong>ROLE</strong></th>
                            <th><strong>ACCNT DETAILS</strong></th>
                            <th><strong>2FA ENABLED</strong></th>
                            <th><strong>Status</strong></th>
                            <th><strong>Action</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $count =1; @endphp
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="form-check custom-checkbox checkbox-success check-lg me-3">
                                    <input type="checkbox" class="form-check-input" id="customCheckBox2"
                                        required="">
                                    <label class="form-check-label" for="customCheckBox2"></label>
                                </div>
                            </td>
                            <td><strong>{{$count ++}}</strong></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('images/avatar/' . $user->photo) }}" class="rounded-lg me-2" width="24" alt="Profile Picture">
                                    <span class="w-space-no">{{$user->firstname}} {{$user->lastname}}</span>
                                </div>
                            </td>
                            <td>{{$user->date_of_birth}}</td>
                            <td> @php
                                $address = json_decode($user->address, true);
                                @endphp
                                {{ $address['street'] ?? '' }}, {{ $address['city'] ?? '' }}, {{ $address['state'] ?? '' }}</td>
                            <td>{{$user->gender}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->phone}}</td>
                            <td>{{$user->role}}</td>
                            @if($user->bank_name && $user->account_number)
                            <td>{{$user->bank_name}}
                            <p>{{$user->account_number}}</p></td>
                            @elseif($user->wallet_address)
                            <td>{{$user->wallet_address}}</td>
                            @else
                            <td>No details</td>
                            @endif
                            <td>@if($user->{'2fa_enabled'} == false)
                                    off
                                @else
                                    on
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center"><span class="badge light" style="background-color: 
                                    @if($user->verification_status == 'Pending') orange
                                    @elseif($user->verification_status == 'Rejected') red
                                    @elseif($user->verification_status == 'Verified') green
                                    @endif;">{{$user->verification_status}}</span></div>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal"
                                    data-bs-target=".view-user" onclick="viewUserDetails({{ $user->id }})"><i
                                            class="fa fa-eye"></i></a>
                                    <form action="{{route('admin.users.delete', ['id'=>$user->id])}}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger shadow btn-xs sharp">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- {{$users->links()}} --}}
            <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
            
                    <form method="POST" action="{{route('users.add')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">

                            <label class="form-label d-block mt-3">Role</label>
                            <select class="default-select form-control wide" name="role">
                                <option>Select</option>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                            @error('code')
                            <div>{{ $message }}</div>
                            @enderror
                            &nbsp;
                            <label class="form-label d-block mt-3">First Name</label>
                            <input type="text" name="firstname" class="form-control w-100" placeholder="First Name">
                            @error('firstname')
                                <div>{{ $message }}</div>
                            @enderror

                            <label class="form-label d-block mt-3">Last Name</label>
                            <input type="text" name="lastname" class="form-control w-100" placeholder="Last Name">
                            @error('firstname')
                                <div>{{ $message }}</div>
                            @enderror

                            <label class="form-label d-block mt-3">Email</label>
                            <input type="text" name="email" class="form-control w-100" placeholder="Email">
                            @error('firstname')
                                <div>{{ $message }}</div>
                            @enderror

                            <label class="form-label d-block mt-3">Password</label>
                            <input type="password" name="password" class="form-control w-100" placeholder="Password">
                            @error('firstname')
                                <div>{{ $message }}</div>
                            @enderror
            
                            <label class="form-label d-block mt-3">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control w-100" placeholder="Confirm Password">
                            @error('lastname')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            <div class="modal fade view-user" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">View User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="basic-form">
                                <form action="{{route('admin.users.update', ['id' => $user->id ?? ''])}}" method="POST" enctype="multipart/form-data" id="updateUserForm">
                                        @csrf
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label d-block mt-3">Role</label>
                                                <select class="form-control" name="role" id="role">
                                                    <option>Select Role</option>
                                                    <option value="user">User</option>
                                                    <option value="admin">Admin</option>
                                                </select>
                                                @error('role')
                                                <div>{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">First Name</label>
                                                <input type="text" name ="firstname" class="form-control" placeholder="First Name" id="firstname">
                                                @error('firstname')
                                                    <div>{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Last Name</label>
                                                <input type="text" name ="lastname" class="form-control" placeholder="Last Name" id="lastname">
                                                @error('lastname')
                                                    <div>{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Phone Number</label>
                                                <input type="text" name ="phone" class="form-control" placeholder="Phone Number" id="phone">
                                                @error('phone')
                                                    <div>{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="text-label form-label">Email</label>
                                                <span class="input-group-text" style="background-color: white;"><i class="fa fa-lock"></i>
                                                    &nbsp;<input type="text" name="email" class="form-control" placeholder="Email" id ="email"></span>
                                                    @error('email')
                                                        <div>{{ $message }}</div>
                                                    @enderror
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="text-label form-label">Password</label>
                                                <span class="input-group-text" style="background-color: white;"><i class="fa fa-lock"></i>
                                                    &nbsp;<input type="text" name="password" class="form-control" placeholder="Password" id ="password"></span>
                                                    @error('password')
                                                        <div>{{ $message }}</div>
                                                    @enderror
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label d-block mt-3">Status</label>
                                                <select class="form-control" name="verification_status" id="verification_status">
                                                    <option>Select Status</option>
                                                    <option value="Verified">Verified</option>
                                                    <option value="Pending">Pending</option>
                                                    <option value="Rejected">Rejected</option>
                                                </select>
                                                @error('role')
                                                <div>{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <button type="reset" class="btn btn-danger">Cancel</button>
                                </form>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
</div>
<script>
    function viewUserDetails(userId) {
        $.ajax({
            url: '/admin/users/' +userId+ '/details',
            type: 'GET',
            success: function(data) {
                $('#firstname').val(data.user.firstname);
                $('#lastname').val(data.user.lastname);
                $('#email').val(data.user.email);
                $('#role').val(data.user.role);
                $('#phone').val(data.user.phone);
                $('#verification_status').val(data.user.verification_status);
                $('#password').attr('placeholder', '••••••••').val(data.user.password);
                $('#updateUserForm').attr('action', '/admin/users/' +userId+ '/update');
                $('.view-user').modal('show');
            },
            error: function(error){
                console.error('Error fetching user details:', error);
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
@endsection