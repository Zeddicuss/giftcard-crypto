@extends('layouts.partial')
@section('content')
<div class="content-body default-height ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Active Cryptocurrency</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div><button type="button" class="btn btn-outline-secondary btn-xs" data-bs-toggle="modal"
                                data-bs-target="#addCrypto"><span class="btn-icon-start text-secondary"><i
                                    class="fa fa-plus"></i>
                                    </span>Add Cyptocurrency</button>
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
                                        <th><strong>SYMBOL</strong></th>
                                        <th><strong>EXCHANGE RATE</strong></th>
                                        <th><strong>CURRENCY</strong></th>
                                        <th><strong>PICTURE</strong></th>
                                        <th><strong>Status</strong></th>
                                        <th><strong>Action</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count =1; @endphp
                                    @foreach($active_cryptos as $crypto)
                                    <tr>
                                        <td>
                                            <div class="form-check custom-checkbox checkbox-success check-lg me-3">
                                                <input type="checkbox" class="form-check-input" id="customCheckBox2"
                                                    required="">
                                                <label class="form-check-label" for="customCheckBox2"></label>
                                            </div>
                                        </td>
                                        <td><strong>{{$count++}}</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="w-space-no">{{$crypto->name}}</span>
                                            </div>
                                        </td>
                                        <td>{{$crypto->symbol}}</td>
                                        <td>{{$crypto->exchange_rate}}</td>
                                        <td>{{$crypto->currency}}</td>
                                        <td>@if ($crypto->photo) <img src="{{ asset('storage/' . $crypto->photo) }}" class="" width="50" height="50" alt="">
                                            @else
                                            <h4>No Picture Found</h4>
                                            @endif</td>
                                        <td>
                                            <div class="d-flex align-items-center"><span class="badge light badge-success">{{$crypto->status}}</span></div>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal"
                                                data-bs-target="#editCrypto" onclick="getCryptoDetails({{ $crypto->id }})"><i
                                                        class="fa fa-pencil"></i></a>
                                                        <form action="{{route('delete.crypto', ['id'=>$crypto->id])}}" method="POST" style="display: inline;">
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
                        <div class="modal fade" id="addCrypto" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add Crypto</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                        
                                <form method="POST" action="{{route('crypto.add')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <label class="form-label d-block mt-3">Name</label>
                                        <input type="text" name="name" class="form-control w-100" placeholder="Eg Bitcoin, Etherum">
                                        @error('name')
                                            <div>{{ $message }}</div>
                                        @enderror
                        
                                        <label class="form-label d-block mt-3">Symbol</label>
                                        <input type="text" name="symbol" class="form-control w-100" placeholder="Eg BTC, ETH">
                                        @error('symbol')
                                            <div>{{ $message }}</div>
                                        @enderror

                                        <label class="form-label d-block mt-3">Exchange Rate</label>
                                        <input type="text" name="exchange_rate" class="form-control w-100" placeholder="Eg 1500, 2000">
                                        @error('exchange_rate')
                                            <div>{{ $message }}</div>
                                        @enderror

                                        <label class="form-label d-block mt-3">Currency</label>
                                        <input type="text" name="currency" class="form-control w-100" placeholder="Eg USD, AUD">
                                        @error('currency')
                                            <div>{{ $message }}</div>
                                        @enderror

                                        <label for="formFileMultiple" class="form-label">Crypto Picture</label>
                                        <input class="form-control" name="crypto_photo" id="crypto_photo" type="file" id="formFileMultiple" multiple="">
                                        @error('crypto_photo')
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
                        <div class="modal fade" id="editCrypto" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Crypto</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                        
                                <form method="POST" action="{{ isset($crypto) ? route('crypto.update', ['id' => $crypto->id]) : route('crypto.add') }}" enctype="multipart/form-data" id="updateCryptoForm">
                                    @csrf
                                    <div class="modal-body">
                                        <label class="form-label d-block mt-3">Name</label>
                                        <input type="text" name="name" id="name" class="form-control w-100" placeholder="Eg Bitcoin, Etherum">
                                        @error('name')
                                            <div>{{ $message }}</div>
                                        @enderror
                        
                                        <label class="form-label d-block mt-3">Symbol</label>
                                        <input type="text" name="symbol" id="symbol" class="form-control w-100" placeholder="Eg BTC, ETH">
                                        @error('symbol')
                                            <div>{{ $message }}</div>
                                        @enderror

                                        <label class="form-label d-block mt-3">Exchange Rate</label>
                                        <input type="text" name="exchange_rate" id="exchange_rate" class="form-control w-100" placeholder="Eg 1500, 2000">
                                        @error('exchange_rate')
                                            <div>{{ $message }}</div>
                                        @enderror

                                        <label class="form-label d-block mt-3">Currency</label>
                                        <input type="text" name="currency" id="currency" class="form-control w-100" placeholder="Eg USD, AUD">
                                        @error('currency')
                                            <div>{{ $message }}</div>
                                        @enderror

                                        <label for="formFileMultiple" class="form-label">Crypto Picture</label>
                                        <div class="mb-3">
                                            <img id="cryptoPhoto" src="#" alt="Crypto Picture" class="img-thumbnail" style="max-width: 150px;">
                                        </div>
                                        <input class="form-control" name="crypto_photo" id="photo" type="file" id="formFileMultiple" multiple="">
                                        @error('crypto_photo')
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
                </div>
            </div>
        </div>
        <script>
            function getCryptoDetails(cryptoId) {
                $.ajax({
                    url: '/admin/crypto/' +cryptoId+ '/edit',
                    type: 'GET',
                    success: function(data) {
                        $('#name').val(data.crypto.name);
                        $('#symbol').val(data.crypto.symbol);
                        $('#exchange_rate').val(data.crypto.exchange_rate);
                        $('#currency').val(data.crypto.currency);
                        if(data.crypto.photo) {
                                $('#cryptoPhoto').attr('src', '/storage/' + data.crypto.photo).show();
                            } else {
                                $('#cryptoPhoto').hide();
                            }
                        $('#updateCryptoForm').attr('action', '/admin/crypto/' +cryptoId+ '/update');
                        $('#editCrypto').modal('show');
                    },
                    error: function(error){
                        console.error('Error fetching user details:', error);
                    }
                });
            }
        </script>
    </div>
</div>
@endsection