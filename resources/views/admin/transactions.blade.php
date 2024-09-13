@extends('layouts.partial')
@section('content')
<div class="content-body default-height ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Giftcard Transactions</h4>
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
                                        <th><strong>PRODUCT NAME</strong></th>
                                        <th><strong>EXCHANGE RATE</strong></th>
                                        <th><strong>TRANSACTION TYPE</strong></th>
                                        <th><strong>Status</strong></th>
                                        @if(auth()->check() && auth()->user()->role == 'admin')
                                        <th><strong>Action</strong></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count =1; @endphp
                                    @foreach($transactions as $transaction)
                                    @if($transaction->status == 'completed')
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
                                                <span class="w-space-no">{{$transaction->order_number}}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($transaction->order_type === 'giftcard' && $transaction->giftcard)
                                                {{ $transaction->giftcard->name }}
                                            @elseif($transaction->order_type === 'crypto' && $transaction->crypto)
                                                {{ $transaction->crypto->name }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{$transaction->exchange_rate}}</td>
                                        <td>
                                            @if ($transaction->buyer && $transaction->buyer === auth()->id())
                                                You Purchased from <strong>{{ $transaction->seller_name ?? 'N/A' }}</strong>
                                             @else
                                                You Sold to <strong>{{ $transaction->buyer_name ?? 'N/A' }}</strong>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center"><span class="badge light" style="background-color: 
                                                @if($transaction->status == 'completed') green
                                                @endif;">{{$transaction->status}}</span></div>
                                        </td>
                                        <td>
                                            @if(auth()->check() && auth()->user()->role == 'admin')
                                            <div class="d-flex">
                                                <a href="{{route('invoice.crypto', ['order' => $transaction->id])}}" class="btn btn-primary shadow btn-xs sharp me-1">
                                                    <i class="fa fa-eye"></i></a>
                                                    <form action="{{route('order.delete', ['id'=>$transaction->id])}}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger shadow btn-xs sharp">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endif
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