@extends('layouts.partial')

@section('content')

@include('sweetalert::alert')
<div class="content-body default-height ">
	<div class="container-fluid">
		<div class="card-body">
            <div class="basic-form">
                <form action="{{route('buy.order')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Crypto Name</label>
                            <span class="input-group-text" style="background-color: white;"><i class="fas fa-coins"></i>
                                &nbsp;<select id="crypto_name" name="name" class="form-control" style="height: 40px; font-size:13px;">
                                    <option selected>Crypto Name</option>
                                    @foreach($cryptos as $crypto)
                                    <option value="{{$crypto->id}}" id="crypto_name">{{$crypto->name}}</option>
                                    @endforeach
                                </select>
                            </span>
                            </div>
                        <div id="account_number_container" style="display: none;" class="mb-3 col-md-6">
                            <label for="wallet_address">Transfer the Money to this Account Number:</label>
                            <input type="text" id="account_number" name="wallet_address" readonly class="form-control">
                            <input type="text" id="account_name" name="wallet_address" readonly class="form-control">
                            <input type="text" id="bank_name" name="wallet_address" readonly class="form-control">
                            <button type="button" class="btn btn-outline-success" onclick="copyText(document.getElementById('account_number').value)">
                                <i class="fas fa-copy"></i> Copy
                            </button>
                            <script>
                                function copyText(walletAddress) {
                                            const tempInput = document.createElement('input');
                                            tempInput.value = walletAddress;
                                            document.body.appendChild(tempInput);

                                            tempInput.select();
                                            tempInput.setSelectionRange(0, 99999); // For mobile devices

                                            try {
                                                document.execCommand('copy');
                                                alert('Account Number successfully copied to clipboard!');
                                            } catch (err) {
                                                console.error('Failed to copy account:', err);
                                                alert('Failed to copy Account. Please try again.');
                                            }

                                            // Remove the temporary input from the document
                                            document.body.removeChild(tempInput);
                                        }
                            </script>
                        </div>
                        <script type="text/javascript">
                            document.getElementById('crypto_name').addEventListener('change', function() {
                                const selectedCrypto = this.value;
                                const walletAddressContainer = document.getElementById('account_number_container');
                                const walletAddressInput1 = document.getElementById('account_number');
                                const walletAddressInput2 = document.getElementById('account_name');
                                const walletAddressInput3 = document.getElementById('bank_name');
                                fetch(`/get-account-number/${selectedCrypto}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.account_number) {
                                                walletAddressInput1.value = data.account_number;
                                                walletAddressInput2.value = data.account_name;
                                                walletAddressInput3.value = data.bank_name;
                                                walletAddressContainer.style.display = 'block';
                                            } else {
                                                walletAddressInput.value = 'No Account Number for this crypto';
                                                walletAddressContainer.style.display = 'none';
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error fetching wallet address:', error);
                                            walletAddressInput.value = 'Error fetching wallet address';
                                            walletAddressContainer.style.display = 'block';
                                        });
                                });
                            </script>
                        <div class="mb-3 col-md-6">
                            <label for="formFileMultiple" class="form-label">Proof of Payment</label>
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
                            @foreach($cryptos as $crypto)
                            <input type="hidden" name="exchange_rate" id="" class="form-control" value="{{$crypto->exchange_rate}}">
                            @endforeach
                            <h4><span id="exchange_rate" class="form-text"></span></h4>
                            <h4><span id="ngn_amount" class="form-text"></span></h4>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="text-label form-label">Wallet Address</label>
                            <span class="input-group-text" style="background-color: white;"><i class="fas fa-money-bill-alt"></i>
                                &nbsp;<input type="text" name="wallet_address" id="wallet_address" class="form-control" placeholder="Wallet Address"></span>
                                @error('wallet_address')
                                    <div>{{ $message }}</div>
                                @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="text-label form-label">Network</label>
                            <span class="input-group-text" style="background-color: white;"><i class="fas fa-money-bill-alt"></i>
                                &nbsp;<input type="text" name="network" id="network" class="form-control" placeholder="Eg SOL, USDT"></span>
                                @error('network')
                                    <div>{{ $message }}</div>
                                @enderror
                        </div>
                        <script type="text/javascript">
                             document.getElementById('crypto_name').addEventListener('change', function(){
                                const selectedCryptoId = this.value;
                                const cryptoPrice = parseFloat(document.getElementById('crypto_price').value);

                                if (!selectedCryptoId) return; 
                                

                                fetch('{{ url("get-currency-rate") }}/' + selectedCryptoId, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                                    },
                                    body: JSON.stringify({})
                                })
                                .then(response=> response.json())
                                .then(data => {
                                    if(data.success) {
                                        const exchangeRate = data.exchange_rate;
                                        document.getElementById('exchange_rate').textContent = 'Exchange Rate: ' +exchangeRate;
                                        document.getElementById('ngn_amount').textContent = '';
                                    }else {
                                        alert(data.message);
                                        document.getElementById('exchange_rate').textContent = 'Exchange Rate Not Found';
                                        document.getElementById('ngn_amount').textContent = '';
                                    }
                                })
                                .catch(error => console.error('Error fetching exchange rate:', error));
                            });

                            document.getElementById('crypto_price').addEventListener('input', function(){
                                const cryptoPrice = parseFloat(this.value);
                                const exchangeRateText = document.getElementById('exchange_rate').textContent;

                                const exchangeRateMatch = exchangeRateText.match(/Exchange Rate: (\d+(\.d+)?)/);
                                if(exchangeRateMatch) {
                                    const exchangeRate = parseFloat(exchangeRateMatch[1]);

                                    if(isNaN(cryptoPrice) || cryptoPrice <= 0) {
                                        document.getElementById('ngn_amount').textContent = 'Invalid price entered.';
                                        return;
                                    }

                                    const calculatedPrice = cryptoPrice * exchangeRate;
                                    const formattedAmount = calculatedPrice.toLocaleString('en-US', {
                                                    minimumFractionDigits: 2,
                                                    maximumFractionDigits: 2
                                                });
                                    document.getElementById('ngn_amount').textContent = `You will pay: ₦${formattedAmount}`; 
                                } else {
                                    document.getElementById('ngn_amount').textContent = 'Exchange rate not available.';
                                }
                            });
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
