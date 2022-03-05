@extends('layouts.app_plain')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center align-items-center" style="height:100vh">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-center">Qr Code</h4>
                    <div class="text-center">
                        <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(240)->generate($hash_value)) !!} ">
                    </div>
                    <p class="text-muted text-center">Please scan QR to check-in or check-out</p>

                    <hr class="my-5">
                    <h4 class="text-center">Pin Code</h4>
                    <p class="pin_code_alert success text-center text-success"></p>
                    <p class="pin_code_alert danger text-center text-danger"></p>
                    <input type="text" name="mycode" id="pincode-input1">
                    <p class="text-muted text-center mt-3">Please enter pin to check-in or check-out</p>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('custom_script')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#pincode-input1').pincodeInput({inputs:6,complete:function(value, e, errorElement){

        $.ajax({
            type: "POST",
            url: '/checkin',
            data: { pincode :value },
            success: function(response) {

                $(".pin_code_alert").each(function() {
                                $(this).empty();
                        });



                if(response.status == 'Success'){
                    $( ".pin_code_alert.success" ).text( `${
                        response.message
                    }` );
                }else{
                    $( ".pin_code_alert.danger" ).text( `${
                        response.message
                    }` );
                }

                $(".pincode-input-text").each(function() {
                                $(this).val('');
                        });
                $(".pincode-input-text").first().select().focus();
           },

        });

        }});
</script>
@endsection
