@extends('layouts.partial')
@section('content')
<div class="content-body default-height ">
	<div class="container-fluid">
		<div class="card-body">
            <div class="basic-form">
                <li class="col-xl-12 pending notrated px-3">
                    <form action="{{route('card.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="category_id">Category</label>
                                <span class="input-group-text" style="background-color: white;"><i class="fas fa-list"></i>
                                    &nbsp;<select name="category" class="form-control" id="category_id">
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
                                        &nbsp; <input type="text" name="exchange_rate" class="form-control" id="exchange_rate" disabled>
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
                                                    option.text = giftCard.name;
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
        </div>
    </div>
</div>
@endsection

