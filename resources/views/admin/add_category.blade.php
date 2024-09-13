@extends('layouts.partial')
@section('content')
<div class="content-body default-height ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Giftcard Categories</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div><button type="button" class="btn btn-outline-secondary btn-xs" data-bs-toggle="modal"
                                data-bs-target="#addCat"><span class="btn-icon-start text-secondary"><i
                                    class="fa fa-plus"></i>
                                    </span>Add Category</button>
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
                                        <th><strong>LOGO</strong></th>
                                        <th><strong>Status</strong></th>
                                        <th><strong>Action</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count =1; @endphp
                                    @foreach($categories as $category)
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
                                                <span class="w-space-no">{{$category->name}}</span>
                                            </div>
                                        </td>
                                        <td>  <img src="{{ asset('storage/' . $category->logo) }}" alt="{{ $category->name }}" width="30px" height="30px"></td>
                                        <td>
                                            <div class="d-flex align-items-center"><span class="badge light badge-success">active</span></div>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal"
                                                data-bs-target="#editCrypto" onclick="getCatDetails({{ $category->id }})"><i
                                                        class="fa fa-pencil"></i></a>
                                                <form action="{{route('category.delete', ['id'=>$category->id])}}" method="POST" style="display: inline;">
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
                        <div class="modal fade" id="addCat" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                        
                                <form method="POST" action="{{route('category.store')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <label class="form-label d-block mt-3">Name</label>
                                        <input type="text" name="name" class="form-control w-100" placeholder="Eg Netflix, Apple">
                                        @error('name')
                                            <div>{{ $message }}</div>
                                        @enderror
                        
                                        <label for="formFileMultiple" class="form-label">Giftcard Picture</label>
                                        <input class="form-control" name="cat_photo" type="file" id="formFileMultiple" multiple="">
                                        @error('symbol')
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
                        <div class="modal fade" id="editCat" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                        
                                <form method="POST" action="{{ isset($category) ? route('category.update', ['id' => $category->id]) : route('category.store') }}" enctype="multipart/form-data" id="updateCategoryForm">
                                    @csrf
                                    <div class="modal-body">
                                        <label class="form-label d-block mt-3">Name</label>
                                        <input type="text" name="name" id = "name" class="form-control w-100" placeholder="Eg Netflix, Apple">
                                        @error('name')
                                            <div>{{ $message }}</div>
                                        @enderror
                        
                                        <label class="form-label d-block mt-3">Giftcard Picture</label>
                                        <div class="mb-3">
                                            <img id="catPhoto" src="#" alt="Category Picture" class="img-thumbnail" style="max-width: 150px;">
                                        </div>
                                        <input type="file" name="cat_photo" id="cat_photo" class="form-control w-100" placeholder="Eg jpg, png">
                                        @error('lastname')
                                            <div>{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                                <script>
                                    function getCatDetails(categoryId) {
                                        $.ajax({
                                            url: '/admin/categories/' +categoryId+ '/edit',
                                            type: 'GET',
                                            success: function(data) {
                                                $('#name').val(data.category.name);
                                                if(data.category.logo) {
                                                        $('#catPhoto').attr('src', '/storage/' + data.category.logo).show();
                                                    } else {
                                                        $('#catPhoto').hide();
                                                    }
                                                $('#updateCategoryForm').attr('action', '/admin/categories/' +categoryId+ '/update');
                                                $('#editCat').modal('show');
                                            },
                                            error: function(error){
                                                console.error('Error fetching user details:', error);
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