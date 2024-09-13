<script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    $(document).ready(function(){
        $('#category_id').on('change', function(){
            var categoryId = $(this).val();
            if (categoryId){
                $.ajax({
                    url: '{{ url("giftcard/by-category") }}/' + categoryId,
                    type: "GET",
                    dataType: "json",
                    success: function (data){
                        $('#gift_card_id').empty().append('<option selected> Select Gift Card </option>');
                        $.each(data, function (key, value){
                            $('#gift_card_id').append('<option value = "' + value.id + '">' + value.name + '</option>');
                        });
                        $('#gift_card_id').prop('disabled', false);
                    }
                });
            } else {
                $('#gift_card_id').empty().append('<option selected>Select Gift Card</option>').prop('disabled', true);
            }
        });
    
        $('#gift_card_id').on('change', function(){
            var giftCardId = $(this).val();
            if (giftCardId){
                $.ajax({
                    url: '{{ url("get-exchange-rate")}}/' + giftCardId,
                    type: "GET",
                    dataType: "json",
                    success: function (data){
                        $('#exchange_rate').val(data.exchange_rate).prop('disabled', false);
                    }
                });
            } else {
                $('#exchange_rate').val('').prop('disabled', true);
            }
        });
    
        $('#amount').on('input', function() {
            var amount = $(this).val();
            var exchangeRate = $('#exchange_rate').val();
            if(amount && exchangeRate){
                $('#total_amount').val(amount * exchangeRate);
            } else {
                $('#total_amount').val('');
            }
        });
    });
    
    </script>    