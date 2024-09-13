@extends('layouts.partial')
@section('content')
<div class="content-body default-height ">
    <div class="container-fluid">
    <div class="row">
    <div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Exchange Rates</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div><button type="button" class="btn btn-outline-secondary btn-xs" data-bs-toggle="modal"
                    data-bs-target="#setCrypto"><span class="btn-icon-start text-secondary"><i
                        class="fa fa-plus"></i>
                        </span>Set Currency Rate</button>
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
                            <th><strong>Currency</strong></th>
                            <th><strong>SYMBOL</strong></th>
                            <th><strong>Exchange Rate</strong></th>
                            <th><strong>Exchange Currency</strong></th>
                            <th><strong>SYMBOL</strong></th>
                            <th><strong>Action</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $count =1; @endphp
                        @foreach($exchange_rates as $exchange)
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
                                    <span class="w-space-no">{{$exchange->currency}}</span>
                                </div>
                            </td>
                            <td>{{$exchange->symbol}}</td>
                            <td>{{$exchange->exchange_rate}}</td>
                            <td>{{$exchange->exchange_currency}}</td>
                            <td>{{$exchange->exchange_symbol}}</td>
                            <td>
                                <div class="d-flex align-items-center"><span class="badge light badge-success">Active</span></div>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal"
                                    data-bs-target="#editCrypto"><i
                                            class="fa fa-pencil"></i></a>
                                    <a href="#" class="btn btn-danger shadow btn-xs sharp"><i
                                            class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal fade" id="setCrypto" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Set Currency Exchange</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
            
                    <form method="POST" action="{{route('currency.set')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <label class="form-label d-block mt-3">Currency</label>
                            <input type="text" name="currency" class="form-control w-100" placeholder="Eg Australian Dollar">
                            @error('currency')
                                <div>{{ $message }}</div>
                            @enderror
            
                            <label class="form-label d-block mt-3">Symbol</label>
                            <input type="text" name="symbol" class="form-control w-100" placeholder="Eg USD, NGA">
                            @error('symbol')
                                <div>{{ $message }}</div>
                            @enderror

                            <label class="form-label d-block mt-3">Exchange Rate</label>
                            <input type="text" name="exchange_rate" class="form-control w-100" placeholder="1500">
                            @error('exchange_rate')
                                <div>{{ $message }}</div>
                            @enderror

                            
                            <label class="form-label d-block mt-3">Exchange Currency</label>
                            <input type="text" name="exchange_currency" class="form-control w-100" placeholder="Eg Us Dollar">
                            @error('exchange_currency')
                                <div>{{ $message }}</div>
                            @enderror

                            
                            <label class="form-label d-block mt-3">Exchange Symbol</label>
                            <input type="text" name="exchange_symbol" class="form-control w-100" placeholder="Eg USD, AUD">
                            @error('exchange_symbol')
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit Currency Exchange</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
            
                    <form method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <label class="form-label d-block mt-3">Currency</label>
                            <input type="text" name="currency" class="form-control w-100" placeholder="Eg Australian Dollar">
                            @error('firstname')
                                <div>{{ $message }}</div>
                            @enderror
            
                            <label class="form-label d-block mt-3">Symbol</label>
                            <input type="text" name="symbol" class="form-control w-100" placeholder="Eg USD, NGA">
                            @error('lastname')
                                <div>{{ $message }}</div>
                            @enderror

                            <label class="form-label d-block mt-3">Exchange Rate</label>
                            <input type="text" name="exchange_rate" class="form-control w-100" placeholder="1500">
                            @error('lastname')
                                <div>{{ $message }}</div>
                            @enderror

                            
                            <label class="form-label d-block mt-3">Exchange Currency</label>
                            <input type="text" name="exchange_currency" class="form-control w-100" placeholder="Eg Us Dollar">
                            @error('lastname')
                                <div>{{ $message }}</div>
                            @enderror

                            
                            <label class="form-label d-block mt-3">Exchange Symbol</label>
                            <input type="text" name="exchange_symbol" class="form-control w-100" placeholder="Eg USD, AUD">
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
        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection