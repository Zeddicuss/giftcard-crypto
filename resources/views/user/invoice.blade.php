@extends('layouts.partial')

@section('content')

<div class="content-body default-height ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
    
                <div class="card mt-3">
                    <div class="card-header" style="color:black;"> Invoice for {{ $giftCard->name }}<strong>{{ Carbon\Carbon::now()->format('d-m-Y') }}</strong>
                        <span class="float-end">
                          <strong>Status:</strong> Pending
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
                                <div> <strong>{{ $giftCard->seller->firstname ?? 'N/A' }}&nbsp;{{ $giftCard->seller->lastname ?? 'N/A' }}</strong> </div>
                                @if(!empty($giftCard->seller->address))
                                @php
								$sellerAddress = json_decode($giftCard->seller->address, true); // Decode to associative array
								@endphp
                                {{ $sellerAddress['street'] ?? 'N/A' }}, {{ $sellerAddress['city'] ?? 'N/A' }}, {{ $sellerAddress['state'] ?? 'N/A' }}
                                @else
                                    N/A
                                @endif
                                <div>{{ $giftCard->seller->email ?? 'N/A' }}</div>
                                <div>{{ $giftCard->seller->phone ?? 'N/A' }}</div>
                            </div>
                            <div class="mt-4 col-xl-6 col-lg-6 col-md-12 col-sm-12 d-flex justify-content-lg-end justify-content-md-center justify-content-xs-start" style="color: black;">
                                <div class="row align-items-center">
                                    <div class="col-sm-9">
                                        <div class="brand-logo mb-2">
                                            <img src="{{asset('images/logo/logo-color.png')}}" alt="" class="width-50 me-2">
                                            <img src="{{asset('images/logo/logo-text-color.png')}}" alt="" class="width-120">
                                        </div>
                                        <span>Please send exact amount: <strong class="d-block">₦{{ number_format($giftCard->amount_in_naira, 2) }}</strong><br>
                                            <strong>Seller Account No:&nbsp;{{ $giftCard->seller->account_number ?? 'N/A' }}</strong><hr>
                                            <strong>Seller Account Name:&nbsp;{{ $giftCard->seller->account_name ?? 'N/A'}}</strong><hr>
                                            <strong>Seller Bank:&nbsp;{{ $giftCard->seller->bank_name ?? 'N/A'}}</strong></span><br>
                                        <small class="text-muted" style="color: black;"><strong>Current exchange rate 1 {{$giftCard->currency}} = ₦{{ number_format($giftCard->exchange_rate, 2) }}</strong></small>
                                    </div>
                                    <div class="col-sm-3 mt-3">  
                                        @if($giftCard->image->isNotEmpty())
                                        <img src="{{ $giftCard->image->first()->url }}" class="card-img-top" alt="{{ $giftCard->name }}">
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
                                        <th>Brand</th>
                                        <th>Name</th>
                                        <th>Pin</th>
                                        <th>Verification Code</th>
                                        <th>Expiry Date</th>
                                        <th class="right">Amount</th>
                                        <th class="center">Amount in Naira</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="center">#</td>
                                        <td class="center">{{$giftCard->brand}}</td>
                                        <td class="center">{{$giftCard->name}}</td>
                                        <td class="center">{{$giftCard->pin}}</td>
                                        <td class="center">{{$giftCard->verification_code}}</td>
                                        <td class="center">{{$giftCard->expiry_date}}</td>
                                        <td class="right">{{ number_format($giftCard->amount, 2) }}&nbsp;{{$giftCard->currency}}</td>
                                        <td class="right">₦{{ number_format($giftCard->amount_in_naira, 2) }}</td>
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
        <div class="row">
            <div class="col-lg-12">
                <div class="card mt-3">
                    <div class="card-body">
                        <form action="{{ url('/giftcard/'.$giftCard->id.'/order') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="proof_of_payment" style="color: black;">Upload Proof of Payment</label>
                                <input type="file" class="form-control" id="proof_of_payment" name="proof_of_payment" required>
                            </div><hr>
                            <button type="submit" class="btn btn-secondary">Make Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>		
    </div> 
    
@endsection