@extends('layouts.partial')
@section('content')
<div class="content-body default-height ">
    <div class="container-fluid">
        <div class="row">
    <div class="col-lg-12">
         <div class="card">
        <div class="card-header">
            <h4 class="card-title">Active Giftcards</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div><button type="button" class="btn btn-outline-secondary btn-xs" data-bs-toggle="modal"
                    data-bs-target="#addGiftcard"><span class="btn-icon-start text-secondary"><i
                        class="fa fa-plus"></i>
                        </span>Add Giftcard</button>
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
                            <th><strong>CATEGORY</strong></th>
                            <th><strong>NAME</strong></th>
                            <th><strong>AMOUNT RANGE</strong></th>
                            <th><strong>EXCHANGE RATE</strong></th>
                            <th><strong>CURRENCY</strong></th>
                            <th><strong>TYPE</strong></th>
                            <th><strong>LOGO</strong></th>
                            <th><strong>Status</strong></th>
                            <th><strong>Action</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $count =1; @endphp
                        @foreach($categories as $category)
                        @if($category->addgiftcards->isNotEmpty())
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
                                    <span class="w-space-no">{{ $category->name }}</span>
                                </div>
                            </td>
                            @foreach($category->addgiftcards as $addgiftcard)
                            @if($addgiftcard->category)
                            <td>{{$addgiftcard->name}}</td>
                            <td>${{$addgiftcard->min_amount}} to ${{$addgiftcard->max_amount}}</td>
                            <td>NGN&nbsp;{{$addgiftcard->exchange_rate}}</td>
                            <td>{{$addgiftcard->currency}}</td>
                            <td>{{$addgiftcard->type}}</td>
                            <td><img src="{{ asset('storage/' . $addgiftcard->category->logo) }}" alt="{{ $addgiftcard->name }}" width="30px" height="30px"></td>
                            <td>
                                <div class="d-flex align-items-center"><span class="badge light badge-success"> {{$addgiftcard->status}}</span></div>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal"
                                    data-bs-target="#editGiftcard" onclick="viewGiftcardDetails({{ $addgiftcard->id }})">
                                    <i class="fa fa-eye"></i></a>
                                    <form action="{{route('admin.giftcard.delete', ['id'=>$addgiftcard->id])}}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger shadow btn-xs sharp">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @endif
                            @endforeach
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal fade" id="addGiftcard" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Giftcard</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                         <div class =modal-body>
                            <form method="POST" action="{{route('giftcard.add')}}" enctype="multipart/form-data">
                                @csrf
                                <label class="form-label">Select GiftCard Type:</label>
                                <select class="default-select  form-control wide" name="gift_type">
                                    <option selected>Giftcard Type</option>
                                    <option>E-Code</option>
                                    <option>Physical</option>
                                </select>
                                    @error('gift_type')
                                        <div>{{ $message }}</div>
                                    @enderror
                                    <br>
                                    <label class="form-label">Select Category:</label>
                                    <select class="default-select  form-control wide" name="gift_cat">
                                        <option selected>Select Category</option>
                                        @php
                                            $categories = \App\Models\Category::all();
                                        @endphp
                                        @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('gift_cat')
                                        <div>{{ $message }}</div>
                                    @enderror
                                    <label class="form-label d-block mt-3">Giftcard Name</label>
                                    <input type="text" name="name" class="form-control w-100" placeholder="Giftcard Name">
                                    @error('name')
                                        <div>{{ $message }}</div>
                                    @enderror
                                    <label class="form-label d-block mt-3">Minimum Amount</label>
                                    <input type="number" name="min_amount" class="form-control w-100" placeholder="Minimum Amount Range">
                                    @error('min_amount')
                                        <div>{{ $message }}</div>
                                    @enderror
        
                                    <label class="form-label d-block mt-3">Maximum Amount</label>
                                    <input type="number" name="max_amount" class="form-control w-100" placeholder="Maximum Amount Range">
                                    @error('max_amount')
                                        <div>{{ $message }}</div>
                                    @enderror

                                    <label class="form-label d-block mt-3">Exchange_Rate</label>
                                    <input type="number" name="exchange_rate" class="form-control w-100" placeholder="Exchange Rate">
                                    @error('exchange_rate')
                                        <div>{{ $message }}</div>
                                    @enderror
        
                                    <label class="form-label d-block mt-3">Currency</label>
                                    <input type="text" name="currency" class="form-control w-100" placeholder="Eg USD, AUD">
                                    @error('currency')
                                        <div>{{ $message }}</div>
                                    @enderror

                                    <label for="formFileMultiple" class="form-label">Giftcard Picture</label>
                                    <input class="form-control" name="gift_photo" type="file" id="formFileMultiple" multiple="">
                                    @error('gift_photo')
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
            <div class="modal fade" id="editGiftcard" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Gift Card</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div> 
                        <div class =modal-body>
                            <form method="POST" action="{{ isset($addgiftcard) ? route('admin.giftcard.update', ['id' => $addgiftcard->id]) : route('giftcard.add') }}" enctype="multipart/form-data" id="updateGiftcardForm">
                                @csrf
                                @if(isset($addgiftcard))
                                    @method('PUT')
                                @endif
                                <label class="form-label">Select GiftCard Type:</label>
                                <select class="form-control" name="gift_type" id="gift_type">
                                    <option value="">Giftcard Type</option>
                                    <option value="e-code">E-Code</option>
                                    <option value="physical">Physical</option>
                                </select>
                                    @error('gift_type')
                                        <div>{{ $message }}</div>
                                    @enderror
                                    <br>
                                    <label class="form-label">Select Category:</label>
                                    <select class="form-control" name="gift_cat" id="gift_cat">
                                        <option value="">Select Category</option>
                                        @php
                                            $categories = \App\Models\Category::all();
                                        @endphp
                                        @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('gift_cat')
                                        <div>{{ $message }}</div>
                                    @enderror
                                    <label class="form-label d-block mt-3">Giftcard Name</label>
                                    <input type="text" name="name" id="name" class="form-control w-100" placeholder="Giftcard Name">
                                    @error('name')
                                        <div>{{ $message }}</div>
                                    @enderror
                                    <label class="form-label d-block mt-3">Minimum Amount</label>
                                    <input type="number" name="min_amount" id="min_amount" class="form-control w-100" placeholder="Minimum Amount Range">
                                    @error('min_amount')
                                        <div>{{ $message }}</div>
                                    @enderror
        
                                    <label class="form-label d-block mt-3">Maximum Amount</label>
                                    <input type="number" name="max_amount" id="max_amount" class="form-control w-100" placeholder="Maximum Amount Range">
                                    @error('max_amount')
                                        <div>{{ $message }}</div>
                                    @enderror

                                    <label class="form-label d-block mt-3">Exchange_Rate</label>
                                    <input type="number" name="exchange_rate" id="exchange_rate" class="form-control w-100" placeholder="Exchange Rate">
                                    @error('exchange_rate')
                                        <div>{{ $message }}</div>
                                    @enderror
        
                                    <label class="form-label d-block mt-3">Currency</label>
                                    <input type="text" name="currency" id="currency" class="form-control w-100" placeholder="Eg USD, AUD">
                                    @error('currency')
                                        <div>{{ $message }}</div>
                                    @enderror

                                    <label for="formFileMultiple" class="form-label">Giftcard Picture</label>
                                    <div class="mb-3">
                                        <img id="giftPhoto" src="#" alt="Category Picture" class="img-thumbnail" style="max-width:100px; height:100px;">
                                    </div>
                                    <input class="form-control" name="gift_photo" id="gift_photo" type="file" id="formFileMultiple" multiple="">
                                    @error('gift_photo')
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
</div>
<script>
    function viewGiftcardDetails(addgiftcardId) {
        $.ajax({
            url: '/admin/giftcard/' +addgiftcardId+ '/edit',
            type: 'GET',
            success: function(data) {
                $('#gift_type').val(data.addgiftcard.type);
                $('#gift_cat').val(data.addgiftcard.category);
                $('#name').val(data.addgiftcard.name);
                $('#min_amount').val(data.addgiftcard.min_amount);
                $('#max_amount').val(data.addgiftcard.max_amount);
                $('#currency').val(data.addgiftcard.currency);
                $('#exchange_rate').val(data.addgiftcard.exchange_rate);
                if(data && data.addgiftcard && data.addgiftcard.category && data.addgiftcard.category.logo) {
                    $('#giftPhoto').attr('src', '/storage/' + data.addgiftcard.category.logo).show();
                } else {
                    console.log('No logo found');
                    $('#giftPhoto').hide();
                }
                $('#updateGiftcardForm').attr('action', '/admin/giftcard/' +addgiftcardId+ '/update');
                $('#editGiftcard').modal('show');
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