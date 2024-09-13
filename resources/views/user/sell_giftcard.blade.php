@extends('layouts.partial')
@section('content')
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
                                <li class="col-xl-12 trade rated px-3">
                                    <form action="{{route('card.store')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="category_id">Category</label>
                                                <span class="input-group-text" style="background-color: white;"><i class="fas fa-list"></i>
                                                    &nbsp;<select name="category" class="form-control" id="category_id">
                                                        <option value="" selected>Select Category</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}" data-logo="{{asset('storage/category_images/' . $category->logo)}}">
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <script>
                                                        $(document).ready(function(){
                                                            function formatState(state) {
                                                                if(!state.id) {
                                                                    return.text;
                                                                }

                                                                const logo = $(state.element).data('logo');
                                                                const $state = $(`<span><img src = "${logo}" class="img-flag" width ="30px" height="30px" style="margin-right: 10px;"/> ${state.text}</span>`);
                                                                return $state;
                                                            }
                                                            $('#category_id').form-control({
                                                                templateResult: formatState,
                                                                templateSelection: formatState,
                                                                width: '100%'
                                                            });
                                                        });
                                                    </script>
                                                </span>
                                                @error('category_id')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <input type="hidden" name="type" class="form-control" id="type" value="e-code">
                                                    <label for="gift_card_id">Gift Card</label>
                                                    <span class="input-group-text" style="background-color: white;"><i class="fas fa-gift"></i>
                                                        &nbsp; <select name="gift_card_id" class="form-control" id="gift_card_id" disabled>
                                                        </select>
                                                    </span>
                                                    @error('gift_card_id')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="exchange_rate">Exchange Rate</label>
                                                    <span class="input-group-text" style="background-color: white;"><i class="fas fa-naira-sign"></i>
                                                        &nbsp; <input type="text" readonly name="exchange_rate" class="form-control" id="exchange_rate" disabled>
                                                    </span>
                                                    @error('exchange_rate')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="amount">Amount</label>
                                                    <span class="input-group-text" style="background-color: white;"><i class="fas fa-dollar-sign"></i>
                                                        &nbsp;  <input type="text" name="amount" class="form-control" id="amount">
                                                    </span>
                                                    @error('amount')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="total_amount">Total Amount</label>
                                                    <span class="input-group-text" style="background-color: white;"><i class="fas fa-naira-sign"></i>
                                                        &nbsp;  <input type="text" name="total_amount" class="form-control" id="total_amount" disabled>
                                                    </span>
                                                    @error('total_amount')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="formFileMultiple" class="form-label">Giftcard Details</label>
                                                <span class="input-group-text" style="background-color: white;"><i class="fas fa-pencil"></i>
                                                    &nbsp;<textarea class="form-control" placeholder="Eg the Token or Pin" name="pin" cols="3" rows="3"></textarea></span>
                                                @error('pin')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <button type="reset" class="btn btn-danger">Cancel</button>
                                            <script type="text/javascript">
                                            document.addEventListener('DOMContentLoaded', function () {
                                                    var categorySelect = document.getElementById('category_id');
                                                    var giftCardSelect = document.getElementById('gift_card_id');
                                                    var exchangeRateInput = document.getElementById('exchange_rate');
                                                    var amountInput = document.getElementById('amount');
                                                    var totalAmountInput = document.getElementById('total_amount');
                                            
                                                    categorySelect.addEventListener('change', function () {
                                                        var categoryId = this.value;
                                                        if (categoryId) {
                                                            fetch('{{ url("giftcard/by-category") }}/' + categoryId)
                                                                .then(response => response.json())
                                                                .then(data => {
                                                                    giftCardSelect.innerHTML = '<option selected>Select Gift Card</option>';
                                                                    data.forEach(function (giftCard) {
                                                                        var option = document.createElement('option');
                                                                        option.value = giftCard.id;
                                                                        option.text = `${giftCard.name} ($${giftCard.min_amount} - $${giftCard.max_amount})`;
                                                                        giftCardSelect.add(option);
                                                                    });
                                                                    giftCardSelect.disabled = false;
                                                                });
                                                        } else {
                                                            giftCardSelect.innerHTML = '<option selected>Select Gift Card</option>';
                                                            giftCardSelect.disabled = true;
                                                        }
                                                    });
                                                    giftCardSelect.addEventListener('change', function () {
                                                        var giftCardId = this.value;
                                                        if (giftCardId) {
                                                            fetch('{{ url("get-exchange-rate") }}/' + giftCardId)
                                                                .then(response => response.json())
                                                                .then(data => {
                                                                    var exchangeRate = data.exchange_rate;
                                                                    var formattedAmount = exchangeRate.toLocaleString('en-US', {
                                                                        style: 'currency',
                                                                        currency: 'NGN'
                                                                    });
                                                                    exchangeRateInput.value = formattedAmount;
                                                                    exchangeRateInput.disabled = false;
                                                                });
                                                        } else {
                                                            exchangeRateInput.value = '';
                                                            exchangeRateInput.disabled = true;
                                                        }
                                                    });
                                            
                                                    amountInput.addEventListener('input', function () {
                                                        var amount = parseFloat(this.value);
                                                        var exchangeRate = parseFloat(exchangeRateInput.value);
                                                        if (!isNaN(amount) && !isNaN(exchangeRate)) {
                                                            var totalAmount = amount * exchangeRate;
                                                            var formattedAmount = totalAmount.toLocaleString('en-US', {
                                                                style: 'currency',
                                                                currency: 'NGN'
                                                            });
                                                            totalAmountInput.value = `You will get: ${formattedAmount}`;
                                                            totalAmountInput.disabled = false;
                                                        } else {
                                                            totalAmountInput.value = '';
                                                            totalAmountInput.disabled = true;
                                                        }
                                                    });
                                                });
                                            </script>
                                    </form>
                                </li>
                                <li class="col-xl-12 pending rated px-3">
                                    <form action="{{route('card.store')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="category_id">Category</label>
                                                <span class="input-group-text" style="background-color: white;"><i class="fas fa-list"></i>
                                                    &nbsp;<select name="category" class="form-control" id="catId">
                                                        <option selected>Select Category</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </span>
                                                @error('category_id')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="gift_card_id">Gift Card</label>
                                                    <span class="input-group-text" style="background-color: white;"><i class="fas fa-gift"></i>
                                                        &nbsp; <select name="gift_card_id" class="form-control" id="giftId" disabled>
                                                        </select>
                                                    </span>
                                                    @error('gift_card_id')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                    <input type="hidden" name="type" class="form-control" id="type" value="physical">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="exchange_rate">Exchange Rate</label>
                                                    <span class="input-group-text" style="background-color: white;"><i class="fas fa-naira-sign"></i>
                                                        &nbsp; <input type="text" readonly name="exchange_rate" class="form-control" id="exchange_rate_id" disabled>
                                                    </span>
                                                    @error('exchange_rate')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="amount">Amount</label>
                                                    <span class="input-group-text" style="background-color: white;"><i class="fas fa-dollar-sign"></i>
                                                        &nbsp;  <input type="text" name="amount" class="form-control" id="amt">
                                                    </span>
                                                    @error('amount')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="total_amount">Total Amount</label>
                                                    <span class="input-group-text" style="background-color: white;"><i class="fas fa-naira-sign"></i>
                                                        &nbsp;  <input type="text" name="total_amount" class="form-control" id="tot_amt" disabled>
                                                    </span>
                                                    @error('total_amount')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="formFileMultiple" class="form-label">Giftcard Picture</label>
                                                    <span class="input-group-text" style="background-color: white;"><i class="fas fa-image"></i>
                                                        &nbsp;<input class="form-control" name="photo" type="file" placeholder="Upload photo"></span>
                                                    @error('photo')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                        </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <button type="reset" class="btn btn-danger">Cancel</button>
                                            <script type="text/javascript">
                                                document.addEventListener('DOMContentLoaded', function () {
                                                    var categorySelect = document.getElementById('catId');
                                                    var giftCardSelect = document.getElementById('giftId');
                                                    var exchangeRateInput = document.getElementById('exchange_rate_id');
                                                    var amountInput = document.getElementById('amt');
                                                    var totalAmountInput = document.getElementById('tot_amt');
                                            
                                                    categorySelect.addEventListener('change', function () {
                                                        var categoryId = this.value;
                                                        if (categoryId) {
                                                            fetch('{{ url("giftcard/by-category") }}/' + categoryId)
                                                                .then(response => response.json())
                                                                .then(data => {
                                                                    giftCardSelect.innerHTML = '<option selected>Select Gift Card</option>';
                                                                    data.forEach(function (giftCard) {
                                                                        var option = document.createElement('option');
                                                                        option.value = giftCard.id;
                                                                        option.text = `${giftCard.name} ($${giftCard.min_amount} - $${giftCard.max_amount})`;
                                                                        giftCardSelect.add(option);
                                                                    });
                                                                    giftCardSelect.disabled = false;
                                                                });
                                                        } else {
                                                            giftCardSelect.innerHTML = '<option selected>Select Gift Card</option>';
                                                            giftCardSelect.disabled = true;
                                                        }
                                                    });
                                            
                                                    giftCardSelect.addEventListener('change', function () {
                                                        var giftCardId = this.value;
                                                        if (giftCardId) {
                                                            fetch('{{ url("get-exchange-rate") }}/' + giftCardId)
                                                                .then(response => response.json())
                                                                .then(data => {
                                                                    var exchangeRate = data.exchange_rate;
                                                                    var formattedAmount = exchangeRate.toLocaleString('en-US', {
                                                                        style: 'currency',
                                                                        currency: 'NGN'
                                                                    });
                                                                    exchangeRateInput.value = formattedAmount;
                                                                    exchangeRateInput.disabled = false;
                                                                });
                                                        } else {
                                                            exchangeRateInput.value = '';
                                                            exchangeRateInput.disabled = true;
                                                        }
                                                    });
                                            
                                                    amountInput.addEventListener('input', function () {
                                                        var amount = parseFloat(this.value);
                                                        var exchangeRate = parseFloat(exchangeRateInput.value);
                                                        if (!isNaN(amount) && !isNaN(exchangeRate)) {
                                                            var totalAmount = amount * exchangeRate;
                                                            var formattedAmount = totalAmount.toLocaleString('en-US', {
                                                                style: 'currency',
                                                                currency: 'NGN'
                                                            });
                                                            totalAmountInput.value = `You will get: ${formattedAmount}`;
                                                            totalAmountInput.disabled = false;
                                                        } else {
                                                            totalAmountInput.value = '';
                                                            totalAmountInput.disabled = true;
                                                        }
                                                    });
                                                });
                                            </script>
                                    </form>
                                </li>
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
                            

                            
                        </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>		
</div>    
@endsection