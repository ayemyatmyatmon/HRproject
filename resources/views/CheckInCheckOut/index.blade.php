@extends('layouts.app_plain')
@section('title','Ninja Hr')
@section('content')
<div class="row d-flex justify-content-center align-items-center " style="height: 100vh;">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="text-center mb-4">

                    <h5>QR</h5>
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(250)->generate($hash_data)) !!} ">
                    <p class="text-mute">QR scanner for Check in or Check Out.</p>
                </div>

                <hr>

                <div>
                    <h5 class="text-center">Pin Code</h5>
                    <input type="text" name="pin_code" id="pincode-input1">
                </div>

            </div>
        </div>
        {{-- <div class="card">
            <div class="card-body">
                <table class="table table-bordered Datatable dt-responsive" style="width:100%;">
                    <thead class="text-center">
                        <th class="no-sort no-serch"></th>
                        <th>Employee Name</th>
                        <th>Date</th>
                        <th>Check In Time</th>
                        <th>Check Out Time</th>
                        <th class="no-sort">Action</th>
                        <th class="hidden no-serch">Updated_at</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div> --}}
    </div>
</div>


@endsection
@section('scripts')


<script>
    $('#pincode-input1').pincodeInput({inputs:6,complete:function(value, e, errorElement){

            $.ajax({
                url:'/checkin-checkout-data',
                type:'POST',
                data:{"pin_code":value},

                success:function(res){

                    if(res.message=='success'){
                        const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                        });

                        Toast.fire({
                        icon: 'success',
                        title: res.data,

                        });
                         }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: res.data,
                            footer: '<a href="">Why do I have this issue?</a>'
                            })
                        }
                        $('.pincode-input-container .pincode-input-text').val("");
                        $('.pincode-input-text').first().select().focus();
                }
            })

        //   $(errorElement).html("I'm sorry, but the code not correct");
        }});
</script>

@endsection
