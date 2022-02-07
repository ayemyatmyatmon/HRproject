@extends('layouts.app')
@section('title','Edit Department')
@section('content')

    <div class="card" >
        <div class="card-body">
            <form action="{{route('department.update',$department->id)}}" method="POST" autocomplete="off" id="edit-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="md-form">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" value="{{$department->title}}">
                </div>

                <button class="btn btn-theme btn-block btn-sm">Update</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\UpdateDepartment', '#edit-form'); !!}
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
