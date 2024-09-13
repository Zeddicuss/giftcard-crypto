@extends('layouts.partial')

@section('content')

<div class="content-body default-height ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
    
                <div class="card mt-3">
                    <div class="card-header" style="color:black;"> Invoice for {{ $cryptoName }}<strong>{{ Carbon\Carbon::now()->format('d-m-Y') }}</strong>
                        <span class="float-end">
                          <strong>Status:</strong> {{$order->status}}
                        </span> 
                    </div>
                    <div class="card-body">
                        <div class="row mb-5">
                            <div class="mt-4 col-xl-3 col-lg-3 col-md-6 col-sm-12" style="color:black;">
                                <h6>Buyer:</h6>
                                <div> <strong>{{$buyer->firstname}}&nbsp;{{$buyer->lastname}}</strong> </div>
                                <div>{{$buyer->email}}</div>
                                @php
								$address = json_decode($buyer->address, true); // Decode to associative array
								@endphp
                                <div>{{ $address['street'] ?? 'N/A' }}, {{ $address['state'] ?? 'N/A' }}, {{ $address['country'] ?? 'N/A' }}</div>
                                <div>{{$buyer->phone}}</div>
                            </div>
                            <div class="mt-4 col-xl-3 col-lg-3 col-md-6 col-sm-12" style="color:black;">
                                <h6>Seller:</h6>
                                <div> <strong>{{ $seller->firstname ?? 'N/A' }}&nbsp;{{ $seller->lastname ?? 'N/A' }}</strong> </div>
                                @if(!empty($seller->address))
                                @php
								$sellerAddress = json_decode($seller->address, true); // Decode to associative array
								@endphp
                                {{ $sellerAddress['street'] ?? 'N/A' }}, {{ $sellerAddress['city'] ?? 'N/A' }}, {{ $sellerAddress['state'] ?? 'N/A' }}
                                @else
                                    N/A
                                @endif
                                <div>{{ $seller->email ?? 'N/A' }}</div>
                                <div>{{ $seller->phone ?? 'N/A' }}</div>
                            </div>
                            <div class="mt-4 col-xl-6 col-lg-6 col-md-12 col-sm-12 d-flex justify-content-lg-end justify-content-md-center justify-content-xs-start" style="color: black;">
                                <div class="row align-items-center">
                                    <div class="col-sm-9">
                                        <div class="brand-logo mb-2">
                                            <img src="{{asset('images/logo/logo-color.png')}}" alt="" class="width-50 me-2">
                                            <img src="{{asset('images/logo/logo-text-color.png')}}" alt="" class="width-120">
                                        </div>
                                        <span>Please send exact amount: <strong class="d-block">₦{{ number_format($order->amount_in_naira, 2) }}</strong><br>
                                            <strong>Seller Account No:&nbsp;{{ $sellerAccountDetails['account_number'] ?? 'N/A' }}</strong><hr>
                                            <strong>Seller Account Name:&nbsp;{{ $sellerAccountDetails['account_name'] ?? 'N/A' }}</strong><hr>
                                            <strong>Seller Bank:&nbsp;{{ $sellerAccountDetails['bank_name'] ?? 'N/A' }}</strong></span><br>
                                        <small class="text-muted" style="color: black;"><strong>Current exchange rate 1 USD = ₦{{ number_format($order->exchange_rate, 2) }}</strong></small>
                                    </div>
                                    <div class="col-sm-3 mt-3">  
                                        @if(is_array($order->photo) && $order->photo->isNotEmpty())
                                            <img src="{{ $order->photo->first()->url }}" class="card-img-top" alt="{{ $cryptoName }}">
                                        @else
                                            {{-- <img src="{{asset('images/logo/logo-color.png')}}" class="card-img-top" alt="{{ $giftCard->name }}"> --}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-border">
                                <thead>
                                    <tr>
                                        <th class="center">#</th>
                                        <th>Name</th>
                                        <th>Amount in USD</th>
                                        <th>Exchange Rate</th>
                                        <th>Amount in Naira</th>
                                        <th class="right">Photo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="center">#</td>
                                        <td class="center">{{$cryptoName}}</td>
                                        <td class="center">${{ number_format($order->amount_in_usd, 2) }}</td>
                                        <td class="center">{{$order->exchange_rate}}</td>
                                        <td class="center">₦{{ number_format($order->amount_in_naira, 2) }}</td>
                                        <td class="right">@if ($order->photo) <img src="{{ asset('storage/' . $order->photo) }}" class="" width="50" height="50" alt="">
                                            @else
                                            <h4>No Picture Found</h4>
                                            @endif</td>
                                    </tr>
                                </tbody>
                            </table>
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
                </div>
            </div>
        </div>
    </div>		
    </div> 
    
@endsection