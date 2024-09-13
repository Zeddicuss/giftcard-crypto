@extends('layouts.partial')

@section('content')

@include('sweetalert::alert')
<div class="content-body default-height ">
	<div class="container-fluid">
		<div class="card-body">
            <div class="basic-form">
            <form action="{{route('setting.save')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Site Name</label>
                            <input type="text" name ="site_name" class="form-control" value="{{ $settings['site_name'] ?? '' }}" placeholder="Website Name" id="site_name">
                            @error('site_name')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name ="site_phone" class="form-control" value="{{ $settings['site_phone'] ?? '' }}" placeholder="Website Phone Number" id="site_phone">
                            @error('site_phone')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="text-label form-label">Email</label>
                            <span class="input-group-text" style="background-color: white;"><i class="fa fa-lock"></i>
                                &nbsp;<input type="text" name="site_email" class="form-control" value="{{ $settings['site_email'] ?? '' }}" placeholder="Website Contact Email" id ="site_email"></span>
                                @error('site_email')
                                    <div>{{ $message }}</div>
                                @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="formFileMultiple" class="form-label">Site Logo</label>
                            <input class="form-control" name="site_logo" type="file" placeholder="Website Logo">
                            @error('site_logo')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="text-label form-label">Wallet Address</label>
                            <span class="input-group-text" style="background-color: white;"><i class="fa fa-lock"></i>
                                &nbsp;<input type="text" name="wallet_address" class="form-control" value="{{ $settings['wallet_address'] ?? '' }}" placeholder="Website Wallet Address" id ="wallet_address"></span>
                                @error('wallet_address')
                                    <div>{{ $message }}</div>
                                @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="text-label form-label">Wallet Name</label>
                            <span class="input-group-text" style="background-color: white;"><i class="fa fa-lock"></i>
                                &nbsp;<input type="text" name="wallet_name" class="form-control" value="{{ $settings['wallet_name'] ?? '' }}" placeholder="Website Wallet Name" id ="wallet_name"></span>
                                @error('wallet_name')
                                    <div>{{ $message }}</div>
                                @enderror
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Currency</label>
                            <input type="text" name="currency" class="form-control" placeholder="Eg. USD, EUR, PND">
                            @error('code')
                            <div>{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Exchange Rate</label>
                            <input type="text" name="exchange_rate" class="form-control" placeholder = "Rate of Exchange in your country"">
                            @error('code')
                            <div>{{ $message }}</div>
                            @enderror
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label>Exchange Currency</label>
                            <input type="text" name="exchange_currency" class="form-control" placeholder = "Eg. USD, EUR, PND">
                            @error('code')
                            <div>{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Expiry Date</label>
                            <input type="date" name="expiration_date" class="form-control" placeholder="Expiry Date">
                            @error('code')
                            <div>{{ $message }}</div>
                            @enderror
                        </div>
                --}}
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-danger">Cancel</button>
            </form>
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
        </div>
    </div>
</div>
@endsection
