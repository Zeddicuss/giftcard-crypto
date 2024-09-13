@extends('layouts.partial')
@section('content')
<div class="content-body default-height ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Crypto Transactions</h4>
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
                                        <th><strong>TRANSACTION NUMBER</strong></th>
                                        <th><strong>USER</strong></th>
                                        <th><strong>PRICE</strong></th>
                                        <th><strong>NAME</strong></th>
                                        <th><strong>WALLET ADDRESS</strong></th>
                                        <th><strong>TRANSACTION TYPE</strong></th>
                                        <th><strong>Status</strong></th>
                                        @if(auth()->check() && auth()->user()->role == 'admin')
                                        <th><strong>Action</strong></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count =1; @endphp
                                    @foreach($cryptotransactions as $cryptotransaction)
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
                                                <span class="w-space-no">{{$cryptotransaction->transaction_number}}</span>
                                            </div>
                                        </td>
                                        <td>@if ($cryptotransaction->user->id)
                                            {{ $cryptotransaction->user->firstname ?? 'No User' }}
                                        @endif</td>
                                        <td>{{$cryptotransaction->crypto_price}}</td>
                                        <td>@if ($cryptotransaction->cryptocurrency)
                                            {{ $cryptotransaction->cryptocurrency->name ?? 'No Product' }}
                                        @endif</td>
                                        <td>{{$cryptotransaction->wallet_address}}</td>
                                        <td>{{$cryptotransaction->transaction_type}}</td>
                                        <td>
                                            <div class="d-flex align-items-center"><span class="badge light" style="background-color: 
                                                @if($cryptotransaction->status == 'pending') orange
                                                @elseif($cryptotransaction->status == 'failed') red
                                                @elseif($cryptotransaction->status == 'completed') green
                                                @endif;">{{$cryptotransaction->status}}</span></div>
                                        </td>
                                        <td>
                                            @if(auth()->check() && auth()->user()->role == 'admin')
                                            <div class="d-flex">
                                                <a href="#" class="btn btn-danger shadow btn-xs sharp"><i
                                                        class="fa fa-trash"></i></a>
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection