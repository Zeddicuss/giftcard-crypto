@extends('layouts.partial');
 
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
                                   <li data-filter=".ecode" class="btn">
                                       <a href="javascript:void(0);" class="site-button" >E-Code</a>
                                   </li>
                                   <li data-filter=".physical" class="btn">
                                       <a href="javascript:void(0);" class="site-button">Physical</a>
                                   </li>
                               </ul>
                           </div>
                       </div>
                   </div>
               </div>
               <div class="col-xl-12">
                   <div class="row">
                       <div class="col-xl-10">
                           <ul id="masonry" class="row">
                              
                               <li class=" ecode rated px-3">
                                   <form method="POST" action="{{route('giftcard.add')}}" enctype="multipart/form-data">
                                       @csrf
                                       <div class="mb-3">
                                           <label class="form-label">Select Category:</label>
                                           <select class="default-select  form-control wide">
                                               <option>Bitcoin</option>
                                               <option>Bitcoin</option>
                                               <option>Bitcoin</option>
                                               <option>Bitcoin</option>
                                           </select>
                                       </div>
                                       <div class="mb-3">
                                           <label class="form-label">Select GifSubcategory:</label>
                                           <select class="default-select  form-control wide">
                                               <option>1</option>
                                               <option>2</option>
                                               <option>3</option>
                                               <option>4</option>
                                           </select>
                                       </div>
                                       <div class="mb-3">
                                           <label class="form-label">Gift Card Amount:</label>
                                           <input type="text" name="name" class="form-control w-100" placeholder="Giftcard Name">
                                       </div>
                           
                                           <label class="form-label d-block mt-3">Minimum Amount</label>
                                           <input type="number" name="min_amount" class="form-control w-100" placeholder="Minimum Amount Range">
                                           @error('lastname')
                                               <div>{{ $message }}</div>
                                           @enderror
               
                                           <label class="form-label d-block mt-3">Maximum Amount</label>
                                           <input type="number" name="max_amount" class="form-control w-100" placeholder="Maximum Amount Range">
                                           @error('lastname')
                                               <div>{{ $message }}</div>
                                           @enderror
               
                                           <label class="form-label d-block mt-3">Currency</label>
                                           <input type="text" name="currency" class="form-control w-100" placeholder="Eg USD, AUD">
                                           @error('lastname')
                                               <div>{{ $message }}</div>
                                           @enderror
                                       </div>
                                       <div class="modal-footer">
                                           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                           <button type="submit" class="btn btn-primary">Submit</button>
                                       </div>
                                   </form>
                               </li>
                               <li class="rated physical">
                                   <form method="POST" action="{{route('giftcard.add')}}" enctype="multipart/form-data">
                                       @csrf
                                       <div class="modal-body">
                                           <label class="form-label d-block mt-3">Giftcard Brand</label>
                                           <input type="text" name="brand" class="form-control w-100" placeholder="Eg Netflix, Google Pay">
                                           @error('firstname')
                                               <div>{{ $message }}</div>
                                           @enderror
               
                                           <label class="form-label d-block mt-3">Giftcard Name</label>
                                           <input type="text" name="name" class="form-control w-100" placeholder="Giftcard Name">
                                           @error('firstname')
                                               <div>{{ $message }}</div>
                                           @enderror
                           
                                           <label class="form-label d-block mt-3">Minimum Amount</label>
                                           <input type="number" name="min_amount" class="form-control w-100" placeholder="Minimum Amount Range">
                                           @error('lastname')
                                               <div>{{ $message }}</div>
                                           @enderror
               
                                           <label class="form-label d-block mt-3">Maximum Amount</label>
                                           <input type="number" name="max_amount" class="form-control w-100" placeholder="Maximum Amount Range">
                                           @error('lastname')
                                               <div>{{ $message }}</div>
                                           @enderror
               
                                           <label class="form-label d-block mt-3">Currency</label>
                                           <input type="text" name="currency" class="form-control w-100" placeholder="Eg USD, AUD">
                                           @error('lastname')
                                               <div>{{ $message }}</div>
                                           @enderror
                                       </div>
                                       <div class="modal-footer">
                                           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                           <button type="submit" class="btn btn-primary">Submit</button>
                                       </div>
                                   </form>
                               </li>
                           </ul>
       
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