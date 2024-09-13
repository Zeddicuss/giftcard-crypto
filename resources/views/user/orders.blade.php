@extends('layouts.partial')
@section('content')
@if (auth()->check())
<div class="content-body default-height ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Orders</h4>
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
                                        <th><strong>ORDER NUMBER</strong></th>
                                        <th><strong>BUYER NAME</strong></th>
                                        <th><strong>SELLER NAME</strong></th>
                                        <th><strong>ORDER TYPE</strong></th>
                                        <th><strong>ORDER NAME</strong></th>
                                        <th><strong>WALLET ADDRESS</strong></th>
                                        <th><strong>NETWORK</strong></th>
                                        <th><strong>AMOUNT (USD)</strong></th>
                                        <th><strong>EXCHANGE RATE</strong></th>
                                        <th><strong>AMOUNT (NAIRA)</strong></th>
                                        <th><strong>PHOTO</strong></th>
                                        <th><strong>STATUS</strong></th>
                                            <th><strong>ACTION</strong></th>
                                    </tr>
                                </thead>
                                <tbody>  
                                    @foreach($orders as $order)    
                                    @if($order->status == 'pending' || $order->status == 'cancelled')            
                                    <tr>
                                        <td>
                                            <div class="form-check custom-checkbox checkbox-success check-lg me-3">
                                                <input type="checkbox" class="form-check-input" id="orderCheck{{ $order->id }}" required="">
                                                <label class="form-check-label" for="orderCheck{{ $order->id }}"></label>
                                            </div>
                                        </td>
                                        <td><strong>{{ $loop->iteration }}</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                
                                                    <span class="w-space-no">{{ $order->order_number }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($order->buyer && $order->buyer === auth()->id())
                                                You
                                             @else
                                                {{ $order->buyer_name ?? 'N/A' }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($order->seller && $order->seller === auth()->id())
                                            You
                                        @else
                                             {{ $order->seller_name ?? 'N/A' }}
                                        @endif
                                        </td>
                                        <td>{{ ucfirst($order->order_type) }}</td>
                                        <td>@if($order->order_type === 'giftcard' && $order->giftcard)
                                                {{ $order->giftcard->name }}
                                            @elseif($order->order_type === 'crypto' && $order->crypto)
                                                {{ $order->crypto->name }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            {{ $order->wallet_address }}
                                        </td>
                                        <td>
                                            {{ $order->network }}
                                        </td>
                                        <td>
                                            {{ number_format($order->amount_in_usd, 2) }} USD
                                        </td>
                                        <td>{{ number_format($order->exchange_rate, 2) }}</td>
                                        <td>{{ number_format($order->amount_in_naira, 2) }} NGN</td>
                                            <td>
                                                <img src="{{ asset('storage/' . $order->photo) }}" alt="Order Photo" style="width: 50px; height: 50px;">
                                            </td>
                                            
                                        <td>
                                            <div class="d-flex align-items-center"><span class="badge light" style="background-color: 
                                                @if($order->status == 'pending') orange
                                                @elseif($order->status == 'cancelled') red
                                                @elseif($order->status == 'completed') green
                                                @endif;">{{$order->status}}</span></div>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{route('invoice.crypto', ['order' => $order->id])}}" class="btn btn-primary shadow btn-xs sharp me-1">
                                                    <i class="fa fa-eye"></i></a>
                                            @if(auth()->check() && auth()->user()->role == 'admin')
                                                <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal"
                                                data-bs-target="#editStatus" onclick="viewOrderDetails({{ $order->id }})"><i
                                                        class="fa fa-pencil"></i></a>
                                                        <form action="{{route('order.delete', ['id'=>$order->id])}}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger shadow btn-xs sharp">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                    @endif
                                    @endforeach
                                  
                                </tbody>
                            </table>
                        </div>
                        <div class="modal fade" id="editStatus" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Change Order Status</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                        
                                <form method="POST" action=" {{ isset($order) ? route('order.update', ['id' => $order->id]) : '' }}" enctype="multipart/form-data" id="updateOrder">
                                    @csrf
                                    <input type="hidden" id="orderId" name="id" value="{{ $order->id ?? '' }}">
                                    <div class="modal-body">
                                        <div class="basic-form">
                                            <div class="row">
                                                <div class="mb-3">
                                                    <label class="form-label">Proof of Payment</label><br>
                                                    <img id="orderPhoto" src="#" alt="Proof of Payment" class="img-thumbnail" style="width: 650px; height:500;">
                                                </div>
                                                <label class="form-label">Change Order Status</label>
                                                <select class="form-control" name="status" id="status">
                                                    <option value="">Select</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="cancelled">Cancelled</option>
                                                    <option value="completed">Completed</option>
                                                </select>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Change</button>
                                    </div>
                                </form>
                                <script>
                                    function viewOrderDetails(orderId){
                                        $.ajax({
                                            url: '/orders/' +orderId+ '/details',
                                            type: 'GET',
                                            success: function(data) {
                                                $('#orderId').val(orderId);
                                                if(data.order.photo) {
                                                        $('#orderPhoto').attr('src', '/storage/' + data.order.photo).show();
                                                    } else {
                                                        $('#orderPhoto').hide();
                                                    }
                                                $('#status').val(data.order.status);
                                                $('#updateOrder').attr('action', '/orders/' +orderId+ '/update');
                                                $('#editStatus').modal('show');
                                            },
                                            error: function(error){
                                                console.error('Error fetching order:', error);
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endauth
@endsection