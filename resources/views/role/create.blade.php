@extends('layouts.app')
@section('title','Create Department')
@section('content')

    <div class="card" >
        <div class="card-body">
            <form action="{{route('role.store')}}" method="POST" autocomplete="off" id="d-form">
                @csrf
                <div class="md-form">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" old="{{'title'}}">
                </div>
                <div class="row mb-4">
                    @foreach ($permissions as $permission )
                    <div class="col-md-3 col-6">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="permissions[]" class="custom-control-input" id="checkbox_{{$permission->name}}" value="{{$permission->name}}">
                            <label class="custom-control-label" for="checkbox_{{$permission->name}}">{{$permission->name}}</label>
                        </div>
                    </div>
                    @endforeach

                </div>
                <button class="btn btn-theme btn-block btn-sm mt-3">Confirm</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\StoreRole', '#create-form'); !!}
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
