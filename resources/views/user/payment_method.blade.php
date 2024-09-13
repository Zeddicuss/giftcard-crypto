@extends('layouts.partial')
@section('content')
<div class="content-body default-height ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Payment Method</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div><button type="button" class="btn btn-outline-secondary btn-xs" data-bs-toggle="modal"
                                data-bs-target="#addBank"><span class="btn-icon-start text-secondary"><i
                                    class="fa fa-plus"></i>
                                    </span>Add Bank Details</button>
                            </div>
                            @if($user && $user->account_number)
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
                                        <th><strong>ACOUNT NO</strong></th>
                                        <th><strong>BANK</strong></th>
										@if(auth()->check() && auth()->user()->role == 'admin')
                                        <th><strong>Action</strong></th>
										@endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count =1; @endphp
                                    <tr>
                                        <td>
                                            <div class="form-check custom-checkbox checkbox-success check-lg me-3">
                                                <input type="checkbox" class="form-check-input" id="customCheckBox2"
                                                    required="">
                                                <label class="form-check-label" for="customCheckBox2"></label>
                                            </div>
                                        </td>
    									<td>{{ $count++ }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="w-space-no">{{ $user->account_name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $user->account_number }} </td>
										<td>{{ $user->bank_name }} </td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal"
                                                data-bs-target="#editBank" onclick="getPaymentDetails({{ $user->id }})"><i
                                                        class="fa fa-pencil"></i></a>
                                                        <form action="{{route('payment.delete', ['id'=>$user->id ])}}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger shadow btn-xs sharp">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @else
							<h4>No account details found.</h4>
							@endif
                        </div>
						<br>
						<br>
						&nbsp;

						<div class="table-responsive">
                            <div><button type="button" class="btn btn-outline-secondary btn-xs" data-bs-toggle="modal"
                                data-bs-target="#addWallet"><span class="btn-icon-start text-secondary"><i
                                    class="fa fa-plus"></i>
                                    </span>Add Wallet Address</button>
                            </div>
                            @if ($wallets->isEmpty())
                            <h4>No wallet addresses found.</h4>
                            @else
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
                                        <th><strong>CRYPTO</strong></th>
                                        <th><strong>WALLET ADDRESS</strong></th>
                                        <th><strong>WALLET PROVIDER</strong></th>
										@if(auth()->check() && auth()->user()->role == 'admin')
                                        <th><strong>Action</strong></th>
										@endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wallets as $wallet)
                                    <tr>
                                        <td>
                                            <div class="form-check custom-checkbox checkbox-success check-lg me-3">
                                                <input type="checkbox" class="form-check-input" id="customCheckBox2"
                                                    required="">
                                                <label class="form-check-label" for="customCheckBox2"></label>
                                            </div>
                                        </td>
    									<td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="w-space-no">{{ $wallet->crypto_name}}</span>
                                            </div>
                                        </td>
										<td>{{ $wallet->wallet_address }} </td>
                                        <td>{{ $wallet->wallet_provider ?? 'N/A' }} </td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal"
                                                data-bs-target="#editWallet" onclick="getWalletDetails({{ $wallet->id }})"><i
                                                        class="fa fa-pencil"></i></a>
                                                        <form action="{{route('wallet.delete', ['id'=>$wallet->id ])}}" method="POST" style="display: inline;">
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
                            @endif
                        </div>
                        <div class="modal fade" id="addBank" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add Bank Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                        
                                <form method="POST" action="{{route('store.pay')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <label class="form-label d-block mt-3">Bank Name</label>
                                        <input type="text" name="bank_name" class="form-control w-100" placeholder="Bank Name">
                                        @error('bank_name')
                                            <div>{{ $message }}</div>
                                        @enderror
                        
                                        <label class="form-label d-block mt-3">Account Number</label>
                                        <input type="text" name="account_number" class="form-control w-100" placeholder="Bank Account Number">
                                        @error('account_name')
                                            <div>{{ $message }}</div>
                                        @enderror

										<label class="form-label d-block mt-3">Account Name</label>
                                        <input type="text" name="account_name" class="form-control w-100" placeholder="Must be the same with your user name">
                                        @error('account_name')
                                            <div>{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        @if(session('success'))
                                            Swal.fire({
                                                icon: 'success',
                                                title: '<span style="color: white;">Success:</span>',
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
                                                title: '<span style="color: white;">Error:</span>',
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
                        <div class="modal fade" id="editBank" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Bank Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                        
                                <form method="POST" action= "{{ isset($user) ? route('payment.update', ['id' => $user->id]) : route('store.pay') }}" enctype="multipart/form-data" id="updateBankForm">
                                    @csrf
                                    <div class="modal-body">
                                        <label class="form-label d-block mt-3">Bank Name</label>
                                        <input type="text" id="bank_name" name="bank_name" class="form-control w-100" placeholder="Bank Name">
                                        @error('bank_name')
                                            <div>{{ $message }}</div>
                                        @enderror
                        
                                        <label class="form-label d-block mt-3">Account Number</label>
                                        <input type="text" id="account_number" name="account_number" class="form-control w-100" placeholder="Bank Account Number">
                                        @error('account_number')
                                            <div>{{ $message }}</div>
                                        @enderror

										<label class="form-label d-block mt-3">Account Name</label>
                                        <input type="text" id="account_name" name="account_name" class="form-control w-100" placeholder="Must be the same with your user name">
                                        @error('account_name')
                                            <div>{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                                <script>
                                    function getPaymentDetails(userId) {
                                        $.ajax({
                                            url: '/settings/payment-methods/' +userId+ '/edit',
                                            type: 'GET',
                                            success: function(data) {
                                                $('#bank_name').val(data.bank_name);
                                                $('#account_number').val(data.account_number);
                                                $('#account_name').val(data.account_name);
                                                $('#updateBankForm').attr('action', '/settings/payment-methods/' +userId+ '/update');
                                                $('#editBank').modal('show');
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
                                                title: '<span style="color: white;">Success:</span>',
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
                                                title: '<span style="color: white;">Error:</span>',
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
                        <div class="modal fade" id="addWallet" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add Wallet</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                        
                                <form method="POST" action="{{route('wallet.pay')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <label class="form-label d-block mt-3">Crypto Name</label>
                                        <select class="form-control" name="crypto_name" id="crypto_name">
                                            <option>Select Crypto</option>
                                            @foreach($cryptos as $crypto)
                                            <option value="{{$crypto->name}}">{{$crypto->name}}</option>
                                            @endforeach
                                        </select>
                                        {{-- <label class="form-label d-block mt-3">Crypto Name</label>
                                        <input type="text" name="crypto_name" class="form-control w-100" placeholder="Eg Bitcoin, Etherum"> --}}
                                        @error('crypto_name')
                                            <div>{{ $message }}</div>
                                        @enderror
                        
                                        <label class="form-label d-block mt-3">Wallet Address</label>
                                        <input type="text" name="wallet_address" class="form-control w-100" placeholder="Wallet Address">
                                        @error('wallet_address')
                                            <div>{{ $message }}</div>
                                        @enderror

										<label class="form-label d-block mt-3">Network</label>
                                        <input type="text" name="wallet_provider" class="form-control w-100" placeholder="Eg Trust, Binance">
                                        @error('wallet_provider')
                                            <div>{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        @if(session('success'))
                                            Swal.fire({
                                                icon: 'success',
                                                title: '<span style="color: white;">Success:</span>',
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
                                                title: '<span style="color: white;">Error:</span>',
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
                    <div class="modal fade" id="editWallet" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Wallet</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                    
                            <form method="POST" action=""{{ isset($wallet) ? route('wallet.update', ['id' => $wallet->id]) : route('wallet.pay') }}" enctype="multipart/form-data" id="updateWalletForm">
                                @csrf
                                @method('put')
                                <div class="modal-body">
                                    <label class="form-label d-block mt-3">Crypto Name</label>
                                        <select class="form-control" name="crypto_name" id="crypto_name">
                                            <option value="" disabled>Select Crypto</option>
                                            @foreach($cryptos as $crypto)
                                            <option value="{{$crypto->name}}">{{$crypto->name}}</option>
                                            @endforeach
                                        </select>
                                    @error('crypto_name')
                                        <div>{{ $message }}</div>
                                    @enderror
                    
                                    <label class="form-label d-block mt-3">Wallet Address</label>
                                    <input type="text" id="wallet_address" name="wallet_address" class="form-control w-100" placeholder="Wallet Address">
                                    @error('wallet_address')
                                        <div>{{ $message }}</div>
                                    @enderror

                                    <label class="form-label d-block mt-3">Network</label>
                                    <input type="text" id="wallet_provider" name="wallet_provider" class="form-control w-100" placeholder="Eg Trust, Binance">
                                    @error('wallet_provider')
                                        <div>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                            <script>
                                function getWalletDetails(walletId) {
                                    $.ajax({
                                        url: '/settings/wallet/' +walletId+ '/edit',
                                        type: 'GET',
                                        success: function(data) {
                                                if (data.wallet) {
                                                    const cryptoName = data.wallet.crypto_name;
                                                    const $cryptoSelect = $('#crypto_name');

                                                    if ($cryptoSelect.find(`option[value="${cryptoName}"]`).length) {
                                                            $cryptoSelect.val(cryptoName).trigger('change');
                                                        } else {
                                                            console.warn('Crypto name not found in dropdown options:', cryptoName);
                                                        }

                                                    $('#wallet_address').val(data.wallet.wallet_address);
                                                    $('#wallet_provider').val(data.wallet.wallet_provider);

                                                    $('#updateWalletForm').attr('action', '/settings/wallet/' + walletId + '/update');

                                                    $('#editWalletModal').modal('show');
                                                } else {
                                                    console.error('Error fetching wallet details:', data.error);
                                                }
                                            },
                                            error: function(error) {
                                                console.error('Error fetching wallet details:', error);
                                            }
                                        });
                                    }
                            </script>
                            </div>
                        </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection