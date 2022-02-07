@extends('layouts.app')
@section('title','Edit Role')
@section('content')

    <div class="card" >
        <div class="card-body">
            <form action="{{route('role.update',$role->id)}}" method="POST" autocomplete="off" id="edit-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="md-form">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" old="{{'name'}}" value="{{$role->name}}">
                </div>
                <div class="row mb-4">
                    @foreach ($permissions as $permission )
                    <div class="col-md-3 col-6">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="permissions[]" class="custom-control-input" id="checkbox_{{$permission->name}}" value="{{$permission->name}}" @if(in_array($permission->id,$old_permission)) checked @endif>
                            <label class="custom-control-label" for="checkbox_{{$permission->name}}">{{$permission->name}}</label>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="btn btn-theme btn-block btn-sm">Update</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\UpdateRole', '#edit-form'); !!}
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
