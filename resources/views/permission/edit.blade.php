@extends('layouts.app')
@section('title','Edit Permission')
@section('content')

    <div class="card" >
        <div class="card-body">
            <form action="{{route('permission.update',$permission->id)}}" method="POST" autocomplete="off" id="edit-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="md-form">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control"  value="{{$permission->name}}">
                </div>

                <button class="btn btn-theme btn-block btn-sm">Update</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\UpdatePermission', '#edit-form'); !!}
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
        });
    </script>


@endsection
