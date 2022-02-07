@extends('layouts.app')
@section('title','Edit Attendance')
@section('content')

    <div class="card" >
        <div class="card-body">
        @include('layouts.error')

            <form action="{{route('attendance.update',$attendance->id)}}" method="POST" autocomplete="off" id="edit-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                 <div class="md-form">
                <select class="form-control js-example-basic-single" name="user_id">
                    <option value=""> --Please Choose --</option>
                    @foreach ($employee_names as $employee_name )
                    <option value="{{$employee_name->id}}" @if(old('user_id',$attendance->user_id)==$employee_name->id) selected @endif>{{$employee_name->employee_id}} ({{$employee_name->name}})</option>
                    @endforeach
                </select>

            </div>

            <div class="md-form">
                <label>Date</label>
                <input type="text" name="date" class="form-control date" value={{old('date',$attendance->date)}}>

                @error('date')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="md-form">
                <label>CheckIn Time</label>
                <input type="text" name="checkin_time" class="form-control checkin_time" value="{{old('checkin_time',Carbon\Carbon::parse($attendance->checkin_time)->format('H:i:s'))}}" >
            </div>

            <div class="md-form">
                <label>CheckOut Time</label>
                <input type="text" name="checkout_time" class="form-control checkin_time" value="{{old('checkout_time',Carbon\Carbon::parse($attendance->checkout_time)->format('H:i:s'))}}">
            </div>

                <button class="btn btn-theme btn-block btn-sm">Update</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\UpdateAttendance', '#edit-form'); !!}
    <script>
       $(document).ready(function(){
            $('.js-example-basic-single').select2({
                allowClear:true,
                placeholder:'--- Select Option ---',
            });

            $('.date').daterangepicker({
                "singleDatePicker": true,
                "autoApply": true,
                "showDropdowns": true,
                locale: {
                format: 'YYYY-MM-DD'
                }

            });
            $('.checkin_time').daterangepicker({
                "singleDatePicker": true,
                "autoApply": true,
                "timePicker": true,
                "timePicker24Hour": true,
                "timePickerSeconds": true,

                locale: {
                format: 'HH-mm-ss',
                }

                }).on('show.daterangepicker', function(ev, picker) {
                    picker.container.find('.calendar-table').hide();
                });


            // $('#profile_image').on('change',function(){
            //     var file_length=document.getElementById('profile_image').files.length;
            //     $('.preview_img').html('');
            //     for(var i=0; i < file_length ;i++){
            //         $('.preview_img').append(`<img src="${URL.createObjectURL(event.target.files[i])}" />`);
            //     }
            // })
        });
    </script>


@endsection
