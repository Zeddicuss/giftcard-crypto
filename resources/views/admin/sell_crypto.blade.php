@extends('layouts.partial')
@section('content')

<div class="content-body default-height ">
	<div class="container-fluid">
		<div class="card-body">
            <div class="basic-form">
            <form action="{{route('admin-crypto.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Crypto Name</label>
                        <span class="input-group-text" style="background-color: white;"><i class="fas fa-pencil-alt"></i>
                            &nbsp;<select id="crypto_name" name="name" class="custom-select" style="height: 40px; font-size:13px;">
                                <option selected>Crypto Name</option>
                                @foreach($cryptos as $crypto)
                                <option value="{{$crypto->id}}" id="crypto_name">{{$crypto->name}}</option>
                                @endforeach
                            </select>
                        </span>
                        </div>
                        <div id="wallet_address_container" style="display: none;" class="mb-3 col-md-6">
                            <label for="wallet_address">Transfer the crypto to this Wallet Address:</label>
                            <input type="text" id="wallet_address" name="wallet_address" readonly class="form-control">
                            <input type="text" id="wallet_provider" name="wallet_address" readonly class="form-control">
                        </div>
                    <div class="mb-3 col-md-6">
                        <label for="formFileMultiple" class="form-label">Crypto Picture</label>
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
                                    if (!isNaN(amountInUSD)) {
                                        fetchExchangeRate()
                                            .then(exchangeRate => {
                                                const amountInNGN = amountInUSD * exchangeRate;
                                                const formattedAmount = amountInNGN.toLocaleString('en-US', {
                                                    minimumFractionDigits: 2,
                                                    maximumFractionDigits: 2
                                                });
                                                document.getElementById('ngn_amount').textContent = `You will get NGN: ₦${formattedAmount}`;
                                            })
                                            .catch(error => {
                                                document.getElementById('ngn_amount').textContent = 'Error fetching exchange rate';
                                            });
                                    } else {
                                        document.getElementById('ngn_amount').textContent = 'Please enter a valid amount';
                                    }
                                });
                                function fetchExchangeRate() {
                                    return fetch('{{ route('get-currency-rate') }}')
                                        .then(response => {
                                            if (!response.ok) {
                                                throw new Error('Network response was not ok');
                                            }
                                            return response.json();
                                        })
                                        .then(data => {
                                            if (data.success) {
                                                return data.exchange_rate;
                                            } else {
                                                throw new Error(data.message);
                                            }
                                        });
                                }
                                </script>
                            </div>
                            {{-- <script type="text/javascript">
                                document.getElementById('crypto_name').addEventListener('change', function() {
                                    const selectedCrypto = this.value;
                                    const walletAddressContainer = document.getElementById('wallet_address_container');
                                    const walletAddressInput2 = document.getElementById('wallet_address');
                                    const walletAddressInput3 = document.getElementById('wallet_provider');
                                    fetch(`/get-wallet-address/${selectedCrypto}`)
                                            .then(response => response.json())
                                            .then(data => {
                                                if (data.wallet_address) {
                                                    walletAddressInput2.value = data.wallet_address;
                                                    walletAddressInput3.value = data.wallet_provider;
                                                    walletAddressContainer.style.display = 'block';
                                                } else {
                                                    walletAddressInput.value = 'No Wallet Address for this crypto';
                                                    walletAddressContainer.style.display = 'none';
                                                }
                                            })
                                            .catch(error => {
                                                console.error('Error fetching wallet address:', error);
                                                walletAddressInput.value = 'Error fetching wallet address';
                                                walletAddressContainer.style.display = 'block';
                                            });
                                    });
                                </script> --}}
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
@endsection