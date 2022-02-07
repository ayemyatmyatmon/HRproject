@extends('layouts.app')
@section('title','Edit Employee')
@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{route('employee.update',$employee->id)}}" method="POST" autocomplete="off" id="edit-form"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="md-form">
                <label>Employee_id</label>
                <input type="text" name="employee_id" class="form-control"
                    value="{{$employee->employee_id}}">
            </div>

            <div class="md-form">
                <label>Name</label>
                <input type="text" name="name" class="form-control"  value="{{$employee->name}}">
            </div>
            <div class="md-form">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control"  value="{{$employee->phone}}">
            </div>
            <div class="md-form">
                <label>email</label>
                <input type="email" name="email" class="form-control"  value="{{$employee->email}}">
            </div>

            <div class="md-form">
                <label>Pin Code</label>
                <input type="number" name="pin_code" class="form-control" >
            </div>

            <div class="md-form">
                <label>password</label>
                <input type="password" name="password" class="form-control" >
            </div>

            <div class="md-form">
                <label>NRC_number</label>
                <input type="text" name="nrc_number" class="form-control"
                    value="{{$employee->nrc_number}}">
            </div>
            <div class="md-form">
                <label>Birthday</label>
                <input type="text" name="birthday" class="form-control birthday"
                    value="{{$employee->birthday}}">
            </div>
            <div class="form-group">
                <label>Gender</label>
                <select class="form-control" name="gender" >
                    <option value="male" @if($employee->gender=='male') selected @endif>Male</option>
                    <option value="female" @if($employee->gender=='female') selected @endif>Female</option>
                </select>
            </div>

            <div class="form-group">
                <label>Department_Name</label>
                <select class="form-control" name="department_id" >
                    @foreach ($Departments as $Department )
                    <option value="{{$Department->id}}" @if($Department->id==$employee->id) selected
                        @endif>{{$Department->title}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Role Name</label>
                <select class="form-control role_box" name="roles[]" multiple>
                    @foreach ($roles as $role )
                    <option value="{{$role->name}}" @if(in_array($role->id,$old_roles)) selected @endif>{{$role->name}}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="md-form">
                <label>Date_of_join</label>
                <input type="text" name="date_of_join" class="form-control date_of_join"
                    value="{{$employee->date_of_join}}">
            </div>

            <div class="form-group">
                <label>Is_present?</label>
                <select class="form-control" name="is_present" >
                    <option value="1" @if($employee->is_present==1) selected @endif>Yes</option>
                    <option value="0" @if($employee->is_present==0) selected @endif>No</option>
                </select>
            </div>

            <div class="md-form">
                <label for="form7"> Address</label>
                <textarea id="form7" name="address" class="md-textarea form-control" rows="3"
                    old="{{'address'}}">{{$employee->address}}</textarea>
            </div>

            <div class="form-group">
                <label for="profile_image"> Image</label>
                <input type="file" class="form-control p-1" name="profile_img" id="profile_image" multiple />

                <div class="preview_img my-2">
                    @if($employee->profile_img)
                    <img src="{{$employee->employee_img_path()}}" alt="" />
                    @endif
                </div>
            </div>

            <button class="btn btn-theme btn-block btn-sm">Update</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\UpdateEmployee', '#edit-form'); !!}
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
