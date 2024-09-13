@extends('layouts.partial')  

@section('content')

<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body default-height ">
        <div class="container-fluid">
            <!-- Row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card Infra">
                        <div class="card-header border-0">
                            <div class="site-filters clearfix center m-b40">
                                <ul class="filters" data-bs-toggle="buttons">
                                    <li data-filter=".trade" class="btn active">
                                        <a href="javascript:void(0);" class="site-button">Virtual</a>
                                    </li>
                                    
                                    <li data-filter=".pending" class="btn">
                                        <a href="javascript:void(0);" class="site-button">Physical</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="row">
                        
                        <div class="col-xl-12">
                            <ul id="masonry" class="row">
                                @if(count($giftcards)>0)
                                @foreach ($giftcards as $giftcard)
                                @if ($giftcard->type == 'virtual')
                                    <li class="col-xl-4 col-md-5 trade rated px-3">
                                        <div class="card pull-up ">
                                            <div class="card-body align-items-center flex-wrap">
                                                <div class="d-flex align-items-center mb-4">
                                                    <a href="javascript:void(0)" class="ico-icon">
                                                        <i class="fa-solid fa-gift"></i>
                                                    </a>
                                                    <div class="ms-4">
                                                        <h4 class="heading mb-0">{{$giftcard->name}}</h4>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center mb-4">
                                                    <span style="color: black;">Verification Pin: {{$giftcard->verification_code}}</span>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <p class="mb-0 fs-14 text-black">{{$giftcard->brand}}</P>
                                                        <span class="fs-12">{{$giftcard->status}}</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-0 fs-14 text-success">Amount: {{$giftcard->amount}}&nbsp;{{$giftcard->currency}}</P>
                                                        <span class="fs-12" style="color: red;">Pin: {{$giftcard->pin}}</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <p class="mb-0 fs-14 text-black">{{$giftcard->expiration_date}}</P>
                                                        <span class="fs-12" style="color: black;">Exchange Rate: {{$giftcard->exchange_rate}}&nbsp;you will pay: {{ number_format($giftcard->amount_in_naira, 2, '.', ',') }} Naira</span>
                                                    </div>
                                                    <div>
                                                        <!-- Button trigger modal -->
                                                        <a href="{{ url('/giftcard/'.$giftcard->id.'/invoice') }}"><button type="button" class="btn btn-outline-secondary btn-xs" style="width:90px;">
                                                        <span class="btn-icon-start text-secondary"><i class="fa fa-shopping-cart"></i></span>Buy</button></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endif
                                    @if ($giftcard->type == 'physical')
                                    <li class="col-xl-4 col-md-5 pending notrated px-3">
                                        <div class="card pull-up ">
                                            <div class="card-body align-items-center flex-wrap">
                                                <div class="d-flex align-items-center mb-4">
                                                    <a href="javascript:void(0)" class="ico-icon">
                                                        <i class="fa-solid fa-gift"></i>
                                                    </a>
                                                    <div class="ms-4">
                                                        <h4 class="heading mb-0">{{$giftcard->name}}</h4>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center mb-4">
                                                    <span style="color: black;">
                                                        @if ($giftcard->image)
                                                            <img src="{{ asset('storage/' . $giftcard->photo) }}" alt="Gift Card Image">
                                                        @else
                                                            <p>Image not available</p>
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <p class="mb-0 fs-14 text-black">{{$giftcard->brand}}</P>
                                                        <span class="fs-12">{{$giftcard->status}}</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-0 fs-14 text-success">Amount: {{$giftcard->amount}}&nbsp;{{$giftcard->currency}}</P>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <span class="fs-12" style="color: black;">Exchange Rate: {{$giftcard->exchange_rate}}&nbsp;you will pay: {{ number_format($giftcard->amount_in_naira, 2, '.', ',') }} Naira</span>
                                                    </div>
                                                    <div>
                                                        <!-- Button trigger modal -->
                                                        <a href="{{ url('/giftcard/'.$giftcard->id.'/invoice') }}"><button type="button" class="btn btn-outline-secondary btn-xs" style="width:90px;">
                                                            <span class="btn-icon-start text-secondary"><i class="fa fa-shopping-cart"></i></span>Buy</button></a>
                                                    </div>
                                                    {{-- <div>
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-outline-secondary btn-xs" data-bs-toggle="modal"
                                                                data-bs-target="#buyGiftCard" id="buyGiftCardButton" data-giftcard-id="{{ $giftcard->id }}"
                                                                data-giftcard-name="{{ $giftcard->name }}" data-giftcard-amount="{{ $giftcard->amount }}">
                                                        <span class="btn-icon-start text-secondary"><i class="fa fa-shopping-cart"></i></span>Buy</button>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                                @endforeach
                                @else
                                <li class="col-xl-4 col-md-5 rated px-3">
                                    <div class="card pull-up ">
                                        <div class="card-body align-items-center flex-wrap">
                                            <div class="d-flex align-items-center mb-4">
                                                <a href="javascript:void(0)" class="ico-icon">
                                                    <i class="fas fa-ban" aria-hidden="true"></i>
                                                </a>
                                                <div class="ms-4">
                                                    <h4 class="heading mb-0">No Gifcard Available</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endif

                                
                            </ul>
                    <!-- Modal -->
                    <div class="modal fade" id="buyGiftCard" tabindex="-1" role="dialog" aria-labelledby="giftCardModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Buy Giftcard</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="color: black">
                                        <h5 class="modal-title" id="exampleModalLabel">Giftcard Details</h5>
                                        <p class="mb-0 fs-14 text-black" id="giftcard-name"></p>
                                        <p class="mb-0 fs-14 text-black" id="giftcard-amount"></p>
                                        <br>
                                        <hr>
                                        <h5 class="modal-title" id="exampleModalLabel">Bank Details</h5>
                                        <p class="mb-0 fs-14 text-black" id="seller-account-number"></p>
                                        <p class="mb-0 fs-14 text-black" id="seller-account-name"></p>
                                        <p class="mb-0 fs-14 text-black" id="seller-bank"></p>
                                    </div>
                                    <script>
                                        $(document).ready(function() {
                                          $('#buyGiftCardButton').click(function() {
                                            let giftcardId = $(this).data('giftcard-id');
                                            let giftcardName = $(this).data('giftcard-name');
                                            let giftcardAmount = $(this).data('giftcard-amount');
                                        
                                            // Make an AJAX request to fetch seller's bank details
                                            $.ajax({
                                              url: '/get-seller-bank-details',
                                              data: { giftcardId: giftcardId },
                                              success: function(response) {
                                                // Populate modal fields
                                                $('#giftcard-name').text(giftcardName);
                                                $('#giftcard-amount').text(giftcardAmount + ' ' + response.currency);  // Assuming currency is available in response
                                                $('#seller-account-number').text(response.account_number);
                                                $('#seller-account-name').text(response.account_name);
                                                $('#seller-bank').text(response.bank_name);
                                              }
                                            });
                                        
                                            $('#buyGiftCard').modal('show');
                                          });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit the giftcard, change status -->
                    <div class="modal fade" id="editGiftCard">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Buy Giftcard</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                        
                                <form method="POST" action="{{route('crypto.add')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <label class="form-label d-block mt-3">Name</label>
                                        <input type="text" name="name" class="form-control w-100" placeholder="Eg Bitcoin, Etherum">
                                        @error('firstname')
                                            <div>{{ $message }}</div>
                                        @enderror
                        
                                        <label class="form-label d-block mt-3">Symbol</label>
                                        <input type="text" name="symbol" class="form-control w-100" placeholder="Eg BTC, ETH">
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
                        <div class="col-xl-12">
                            <div class="table-pagenation mb-3">
                                <p class="ms-0">Showing <span>1-5</span>from <span>100</span>data</p>
                                <nav>
                                    <ul class="pagination pagination-gutter pagination-primary no-bg">
                                        <li class="page-item page-indicator">
                                            <a class="page-link" href="javascript:void(0)">
                                                <i class="fa-solid fa-angle-left"></i></a>
                                        </li>
                                        <li class="page-item "><a class="page-link" href="javascript:void(0)">1</a>
                                        </li>
                                        <li class="page-item active"><a class="page-link" href="javascript:void(0)">2</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:void(0)">3</a></li>
                                        <li class="page-item page-indicator me-0">
                                            <a class="page-link" href="javascript:void(0)">
                                                <i class="fa-solid fa-angle-right"></i></a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>		
</div>    
                <!--**********************************
                    Content body end
                ***********************************-->
   
@endsection

                