@extends('layouts.app')
@section('title','Create Employee')
@section('content')

    <div class="card" >

        <div class="card-body">
            <form action="{{route('employee.store')}}" method="POST" autocomplete="off" id="create-form" enctype="multipart/form-data">
                @csrf
                <div class="md-form">
                    <label>Employee_id</label>
                    <input type="text" name="employee_id" class="form-control" old="{{'employee_id'}}">
                </div>

                <div class="md-form">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="md-form">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" >
                </div>
                <div class="md-form">
                    <label>email</label>
                    <input type="email" name="email" class="form-control" >
                </div>


                <div class="md-form">
                    <label>NRC_number</label>
                    <input type="text" name="nrc_number" class="form-control">
                </div>
                <div class="md-form">
                    <label>Birthday</label>
                    <input type="text" name="birthday" class="form-control birthday" >
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <select class="form-control" name="gender" old="{{'gender'}}">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="md-form">
                    <label>password</label>
                    <input type="password" name="password" class="form-control" >
                </div>
                <div class="form-group">
                    <label>Department_Name</label>
                    <select class="form-control" name="department_id" >
                        @foreach ($Departments as $Department )
                        <option value="{{$Department->id}}">{{$Department->title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Role Name</label>
                    <select class="form-control role_box" name="roles[]" multiple >
                        @foreach ($roles as $role )
                        <option value="{{$role->name}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md-form">
                    <label>Date_of_join</label>
                    <input type="text" name="date_of_join" class="form-control date_of_join" >
                </div>
                <div class="form-group">
                    <label>Is_present?</label>
                    <select class="form-control" name="is_present" >
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="md-form">
                    <label for="form7"> Address</label>
                    <textarea id="form7" name="address" class="md-textarea form-control" rows="2"  ></textarea>
                </div>

                <div class="form-group">
                    <label for="profile_image"> Image</label>
                    <input type="file" class="form-control p-1" name="profile_img" id="profile_image" multiple/>

                    <div class="preview_img my-2">

                    </div>
                </div>



                <button class="btn btn-theme btn-block btn-sm mt-3">Confirm</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\StoreEmployee', '#create-form'); !!}
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
