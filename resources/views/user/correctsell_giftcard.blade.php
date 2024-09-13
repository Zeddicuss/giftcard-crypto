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
                                    <form method="POST" action="" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Select Category:</label>
                                            <select class="default-select  form-control wide" name="gift_category">
                                                <option>Bitcoin</option>
                                                <option>Bitcoin</option>
                                                <option>Bitcoin</option>
                                                <option>Bitcoin</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Select Gift Card Subcategory:</label>
                                            <select class="default-select  form-control wide" name="sub_category">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Gift Card Amount:</label>
                                            <input type="text" name="amount" class="form-control w-100" placeholder="Giftcard Name">
                                        </div>
                            
                                        <div class="mb-3">
                                            <textarea class="form-control h-50" name="pin" id="validationCustom04" rows="3" placeholder="Giftcard Details" required></textarea>
                                                @error('lastname')
                                                    <div>{{ $message }}</div>
                                                @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="formFileMultiple" class="form-label">Giftcard Picture</label>
                                            <input class="form-control" name="gift_photo" type="file" id="formFileMultiple" multiple="">
                                        </div>
                
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </li>
                                <li class="rated physical">
                                    <form method="POST" action="" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Select Category:</label>
                                            <select class="default-select  form-control wide" name="gift_category">
                                                <option>Bitcoin</option>
                                                <option>Bitcoin</option>
                                                <option>Bitcoin</option>
                                                <option>Bitcoin</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Select Gift Card Subcategory:</label>
                                            <select class="default-select  form-control wide" name="sub_category">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Gift Card Amount:</label>
                                            <input type="text" name="amount" class="form-control w-100" placeholder="Giftcard Name">
                                        </div>
                            
                                        <div class="mb-3">
                                            <textarea class="form-control h-50" name="pin" id="validationCustom04" rows="3" placeholder="Giftcard Details" required></textarea>
                                                @error('lastname')
                                                    <div>{{ $message }}</div>
                                                @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="formFileMultiple" class="form-label">Giftcard Picture</label>
                                            <input class="form-control" name="gift_photo" type="file" id="formFileMultiple" multiple="">
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