@extends('layouts.app')
@section('title','Create Permission')
@section('content')

    <div class="card" >
        <div class="card-body">
            <form action="{{route('permission.store')}}" method="POST" autocomplete="off" id="d-form">
                @csrf
                <div class="md-form">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" >
                </div>
                <button class="btn btn-theme btn-block btn-sm mt-3">Confirm</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\StorePermission', '#create-form'); !!}
    <script>
        $(document).ready(function(){
            $('.birthday').daterangepicker({
                "singleDatePicker": true,
                "autoApply": true,
                "showDropdowns": true,
                "maxDate":moment(),
                locale: {
                format: 'YYYY-MM-DD'
                }

            });

            $('.date_of_join').daterangepicker({
                "format":"YYYY-MMM-DD",
                "singleDatePicker": true,
                "autoApply": true,
                "showDropdowns": true,
                locale: {
                format: 'YYYY-MM-DD'
                }

            });
            $('#profile_image').on('change',function(){
                var file_length=document.getElementById('profile_image').files.length;
                $('.preview_img').html('');
                for(var i=0; i < file_length ;i++){
                    $('.preview_img').append(`<img src="${URL.createObjectURL(event.target.files[i])}" />`);
                }
            })
        });
    </script>


@endsection
