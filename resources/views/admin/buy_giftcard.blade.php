@extends('layouts.partial')

@section('content')

@include('sweetalert::alert')
<div class="content-body default-height ">
	<div class="container-fluid">
		<div class="card-body">
            <div class="basic-form">
                <form action="{{route('admin.order')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Giftcard Brand</label>
                            <select class="default-select form-control wide bleft" name="brand">
                                <option selected>Giftcard Brand</option>
                                @foreach($giftcards as $giftcard)
                                <option value="{{$giftcard->brand}}">{{$giftcard->brand}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Giftcard Name</label>
                            <select class="default-select form-control wide bleft" name="name">
                                <option selected> Select Giftcard</option>
                                @foreach($giftcards as $giftcard)
                                <option value="{{$giftcard->name}}">{{$giftcard->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                    </div>
                        <div class="mb-3 col-md-6">
                            <label for="formFileMultiple" class="form-label">Prove of Payment</label>
                            <span class="input-group-text" style="background-color: white;"><i class="fas fa-image"></i>
                                &nbsp;<input class="form-control" name="photo" type="file" placeholder="Upload photo"></span>
                            @error('photo')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                       
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="text-label form-label">Amount in USD</label>
                            <span class="input-group-text" style="background-color: white;"><i class="fas fa-money-bill-alt"></i>
                                &nbsp;<input type="text" name="crypto_price" id="crypto_price" class="form-control" placeholder="Eg 1500, 3000"></span>
                                @error('crypto_price')
                                    <div>{{ $message }}</div>
                                @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Our Exchange Rate:</label>
                                @foreach ($currencies as $currency)
                                <input type="hidden" name="exchange_rate" id= "exchange_rate" value="{{$currency->exchange_rate}}">
                                <h4><span id="ngn_amount" class="form-text"></span></h4>
                                @endforeach
                        </div>
                        <script type="text/javascript">
                            document.getElementById('crypto_price').addEventListener('input', function(){
                                const amountInUSD = parseFloat(this.value);
                                if(!isNaN(amountInUSD)) {
                                    fetchExchangeRate()
                                    .then(exchangeRate => {
                                        const amountInNGN = amountInUSD * exchangeRate;
                                        const formattedAmount = amountInNGN.toLocaleString('en-US', {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        });
                                        document.getElementById('ngn_amount').textContent = `You will pay NGN: ₦${formattedAmount}`;
                                    });
                                }else{
                                    document.getElementById('ngn_amount').textContent = 'No Exchange rate';
                                }
                            });

                            function fetchExchangeRate(){
                                return fetch('{{ route('get-exchange-rate') }}')
                                .then(response => response.json())
                                .then(data => data.exchange_rate);
                            }
                        </script>
                       
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
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
@endsection
