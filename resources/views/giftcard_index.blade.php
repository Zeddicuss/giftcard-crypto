@extends('layouts.partial')
@section('content')
<div class="content-body default-height ">
    <div class="container-fluid">
        <div class="row">
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Giftcards</h4>
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
                            <th><strong>CATEGORY</strong></th>
                            <th><strong>GIFT CARD NAME</strong></th>
                            <th><strong>AMOUNT</strong></th>
                            <th><strong>EXCHANGE RATE</strong></th>
                            <th><strong>PIN</strong></th>
                            <th><strong>SELLER</strong></th>
                            <th><strong>SELLER ACCOUNT</strong></th>
                            <th><strong>SELLER BANK</strong></th>
                            <th><strong>IMAGE</strong></th>
                            <th><strong>STATUS</strong></th>
                            <th><strong>VERIFICATION STATUS</strong></th>
                            <th><strong>TYPE</strong></th>
                            <th><strong>Action</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $count =1; @endphp
                        @foreach($giftcards as $giftcard)
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
                                    <span class="w-space-no"> {{ $giftcard->category ? $giftcard->category->name : 'No Category' }}</span>
                                </div>
                            </td>
                            <td>{{$giftcard->name}}</td>
                            <td>{{$giftcard->amount}}</td>
                            <td>{{$giftcard->exchange_rate}}</td>
                            <td>{{$giftcard->pin}}</td>
                            <td>{{ $giftcard->seller ? $giftcard->seller->firstname .' '.$giftcard->seller->lastname : 'No Seller' }}</td>
                            <td>{{ $giftcard->seller ? $giftcard->seller->account_number : 'No Account' }}</td>
                            <td>{{ $giftcard->seller ? $giftcard->seller->bank_name : 'No bank' }}</td>
                            <td>
                                @if($giftcard->photo)
                                    <a href="#" class="giftcard-image" data-image="{{ asset('storage/' . $giftcard->photo) }}" data-id="{{ $giftcard->id }}">
                                        <img src="{{ asset('storage/' . $giftcard->photo) }}" alt="Gift Card Image" style="width: 100px; height: auto;">
                                    </a>
                                @else
                                    No image
                                @endif
                            </td>
                            <td>{{ ucfirst($giftcard->status) }}</td>
                            <td>
                                <div class="d-flex align-items-center"><span class="badge light" style="background-color: 
                                    @if($giftcard->v_status == 'pending') orange
                                    @elseif($giftcard->v_status == 'rejected') red
                                    @elseif($giftcard->v_status == 'approved') green
                                    @endif;">{{$giftcard->v_status}}</span></div>
                            </td>
                            <td>{{ ucfirst($giftcard->type) }}</td>
                            <td>
                                <div class="">
                                    <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal"
                                    data-bs-target=".status-change" onclick="viewCardDetails({{ $giftcard->id }})">
                                    <i class="fa fa-pencil"></i></a>
                                    <a href="#" class="btn btn-success shadow btn-xs sharp me-1" data-bs-toggle="modal"
                                    data-bs-target=".buy-gift">
                                    <i class="fa fa-shopping-cart"></i></a>
                                    &nbsp;
                                    <form action="{{route('delete.giftcard', ['id'=>$giftcard->id])}}" method="POST" style="display: inline;">
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
            <!-- Modal -->
           <!-- Modal -->
<!-- Modal -->
            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="imageModalLabel">Gift Card Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img id="modalImage" src="" alt="Gift Card Image" style="width: 100%; height: auto;">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const giftcardImages = document.querySelectorAll('.giftcard-image');
                    
                    giftcardImages.forEach(image => {
                        image.addEventListener('click', function (event) {
                            event.preventDefault();
                            
                            // Get the image URL from the data attribute
                            const imageUrl = this.getAttribute('data-image');
                            
                            // Set the src of the modal image to the clicked image's URL
                            const modalImage = document.getElementById('modalImage');
                            modalImage.src = imageUrl;
                            
                            // Show the modal
                            const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
                            imageModal.show();
                        });
                    });
                });
            </script>
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
                                <form action="{{ isset($giftcard) ? route('update.giftcard', ['id' => $giftcard->id]) : route('card.store') }}"
                                     method="POST" enctype="multipart/form-data" id="editGiftcardForm">
                                        @csrf
                                        @if(isset($giftcard))
                                            @method('PUT')
                                        @endif
                                        <div class="row">
                                            <div class="mb-3">
                                                <label class="form-label">Proof of Payment</label><br>
                                                <img id="giftcardPhoto" src="#" alt="Proof of Payment" class="img-thumbnail" style="max-width: 750px; height:500;">
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label d-block mt-3">Status</label>
                                                <select class="form-control" name="status" id="status">
                                                    <option value="" disabled>Select Status</option>
                                                    <option value="sold">Sold</option>
                                                    <option value="available">Available</option>
                                                </select>
                                                @error('status')
                                                <div>{{ $message }}</div>
                                                @enderror
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
            <div class="modal fade buy-gift" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Buy Gift Card</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="basic-form">
                                <form action="{{ isset($giftcard) ? route('make.order', ['id' => $giftcard->id]) : route('crypto.store') }}"
                                     method="POST" enctype="multipart/form-data" id="editGiftcardForm">
                                        @csrf
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="formFileMultiple" class="form-label">Proof of Payment</label>
                                                <span class="input-group-text" style="background-color: white;"><i class="fas fa-image"></i>
                                                    &nbsp;<input class="form-control" name="proof_of_payment" type="file" placeholder="Upload photo"></span>
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
    function viewCardDetails(id){
    $.ajax({
        url: '/giftcard/giftcard/' + id + '/show',
        type: 'GET',
        success: function(data) {
            console.log("Setting Values:", data.status, data.v_status);
            $('#editGiftcardForm').attr('action', '/giftcard/giftcard/' +id+ '/update');
            $('.status-change').modal('show');

            if(data.photo) {
                $('#giftcardPhoto').attr('src', '/storage/' + data.photo).show();
                } else {
                $('#giftcardPhoto').hide();
                }
            $('#status').val(data.status);
            $('#v_status').val(data.v_status);
        },
        error: function(){
            alert('Failed to fetch gift card details.');
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