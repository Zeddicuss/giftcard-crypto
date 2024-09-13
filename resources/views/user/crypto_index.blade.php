@extends('layouts.partial')
@section('content')
<div class="content-body default-height ">
    <div class="container-fluid">
        <div class="row">
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Pending Crypto Transactions</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
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
                            <th><strong>CRYPTO NAME</strong></th>
                            <th><strong>CRYPTO PRICE</strong></th>
                            <th><strong>EXCHANGE RATE</strong></th>
                            <th><strong>PAYMENT PHOTO</strong></th>
                            <th><strong>SELLER</strong></th>
                            <th><strong>SELLER ACCOUNT</strong></th>
                            <th><strong>SELLER BANK</strong></th>
                            <th><strong>VERIFICATION STATUS</strong></th>
                            <th><strong>Action</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $count =1; @endphp
                        @foreach($cryptos as $crypto)
                        @if ($crypto->listed_by && $crypto->listed_by !== auth()->id())
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
                                    <span class="w-space-no"> {{ $crypto->name }}</span>
                                </div>
                            </td>
                            <td>{{$crypto->crypto_price}}</td>
                            <td>{{$crypto->exchange_rate}}</td>
                            <td> @if($crypto->photo)
                                    <img src="{{ asset('storage/' . $crypto->photo) }}" alt="Crypto Image" style="width: 50px; height: 50px;">
                                @else
                                    No image
                                @endif
                            </td>
                            <td>{{ $crypto->seller ? $crypto->seller->firstname .' '.$crypto->seller->lastname : 'No Seller' }}</td>
                            <td>{{ $crypto->seller ? $crypto->seller->account_number : 'No Account' }}</td>
                            <td>{{ $crypto->seller ? $crypto->seller->bank_name : 'No bank' }}</td>
                            <td>
                                <div class="d-flex align-items-center"><span class="badge light" style="background-color: 
                                    @if($crypto->v_status == 'pending') orange
                                    @elseif($crypto->v_status == 'rejected') red
                                    @elseif($crypto->v_status == 'approved') green
                                    @endif;">{{$crypto->v_status}}</span></div>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal"
                                    data-bs-target=".status-change" onclick="viewCoinDetails({{ $crypto->id }})">
                                    <i class="fa fa-pencil"></i></a>
                                    <a href="#" class="btn btn-success shadow btn-xs sharp me-1" data-bs-toggle="modal"
                                    data-bs-target=".buy-crypto">
                                    <i class="fa fa-shopping-cart"></i></a>
                                    &nbsp;
                                    <form action="{{route('delete.coin', ['id'=>$crypto->id])}}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger shadow btn-xs sharp">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
               
            </div>
            <div class="modal fade status-change" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Change Status</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="basic-form">
                                <form action="{{ isset($crypto) ? route('update.coin', ['id' => $crypto->id]) : route('crypto.store') }}"
                                     method="POST" enctype="multipart/form-data" id="editGiftcardForm">
                                        @csrf
                                        @if(isset($crypto))
                                            @method('PUT')
                                        @endif
                                        <div class="row">
                                            <div class="mb-3">
                                                <label class="form-label">Proof of Payment</label><br>
                                                <img id="proofPhoto" src="#" alt="Proof of Payment" class="img-thumbnail" style="max-width: 750px; height:500;">
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label d-block mt-3">Verification Status</label>
                                                <select class="form-control" name="v_status" id="v_status">
                                                    <option value="" disabled>Verification Status</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="approved">Approved</option>
                                                    <option value="rejected">Rejected</option>
                                                </select>
                                                @error('v_status')
                                                <div>{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                                <button type="reset" class="btn btn-danger">Cancel</button>
                                            </div>
                                        </div>
                                        
                                </form>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade buy-crypto" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Buy Crypto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="basic-form">
                                <form action="{{ isset($crypto) ? route('admin.order', ['id' => $crypto->id]) : route('crypto.store') }}"
                                     method="POST" enctype="multipart/form-data" id="editGiftcardForm">
                                        @csrf
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label class="text-label form-label">Wallet Address:</label>
                                                <input type="hidden" name="crypto_id" value="{{ $crypto->id }}">
                                                <span class="input-group-text" style="background-color: white;"><i class="fas fa-money-bill-alt"></i>
                                                    &nbsp;<input type="text" name="wallet_address" id="wallet_address" class="form-control" placeholder="Wallet Address"></span>
                                                    @error('wallet_address')
                                                        <div>{{ $message }}</div>
                                                    @enderror
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="text-label form-label">Network:</label>
                                                <span class="input-group-text" style="background-color: white;"><i class="fas fa-money-bill-alt"></i>
                                                    &nbsp;<input type="text" name="network" id="network" class="form-control" placeholder="Eg SOL, USDT"></span>
                                                    @error('network')
                                                        <div>{{ $message }}</div>
                                                    @enderror
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="formFileMultiple" class="form-label">Proof of Payment</label>
                                                <span class="input-group-text" style="background-color: white;"><i class="fas fa-image"></i>
                                                    &nbsp;<input class="form-control" name="photo" type="file" placeholder="Upload photo"></span>
                                                @error('photo')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                                <button type="reset" class="btn btn-danger">Cancel</button>
                                            </div>
                                        </div>
                                        
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
    function viewCoinDetails(id){
    $.ajax({
        url: '/crypto/crypto/' + id + '/show',
        type: 'GET',
        success: function(data) {
            console.log("Setting Values:", data.v_status);
            $('#editGiftcardForm').attr('action', '/crypto/crypto/' +id+ '/update');
            $('.status-change').modal('show');
            if(data.photo) {
                $('#proofPhoto').attr('src', '/storage/' + data.photo).show();
                } else {
                $('#proofPhoto').hide();
                }
            $('#v_status').val(data.v_status);
        },
        error: function(){
            alert('Failed to fetch crypto details.');
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