@extends('layouts.app')
@section('title','Edit Company Setting')
@section('extr.css')
    <style>
        .calendar-time{
            margin-right:10px !important;
        }
    </style>
@endsection
@section('content')

    <div class="card" >
        <div class="card-body">
            <form action="{{route('company-setting.update',$setting->id)}}" method="POST" autocomplete="off" id="edit-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="md-form">
                    <label>Company_Name</label>
                    <input type="text" name="company_name" class="form-control"  value="{{$setting->company_name}}">
                </div>

                <div class="md-form">
                    <label>Company_Email</label>
                    <input type="text" name="company_email" class="form-control"  value="{{$setting->company_email}}">
                </div>

                <div class="md-form">
                    <label>Company_Phone</label>
                    <input type="text" name="company_phone" class="form-control"  value="{{$setting->company_phone}}">
                </div>

                <div class="md-form">
                    <label>Company_Address</label>
                    <textarea name="company_address" class="md-textarea pt-3 form-control">{{$setting->company_address}}</textarea>
                </div>

                <div class="md-form">
                    <label>Office_Start_Time</label>
                    <input type="text" name="office_start_time" class="form-control showtimepicker"  value="{{$setting->office_start_time}}">
                </div>

                <div class="md-form">
                    <label>Office_end_Time</label>
                    <input type="text" name="office_end_time" class="form-control showtimepicker"  value="{{$setting->office_end_time}}">
                </div>

                <div class="md-form">
                    <label>Break_Start_Time</label>
                    <input type="text" name="break_start_time" class="form-control showtimepicker"  value="{{$setting->break_start_time}}">
                </div>


                <div class="md-form">
                    <label > Break_End_Time</label>
                    <input type="text" name="break_end_time" class="form-control showtimepicker" value="{{$setting->break_end_time}}">
                </div>

                <button class="btn btn-theme btn-block btn-sm">Update</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\UpdateCompanySetting', '#edit-form'); !!}
    <script>
        $(document).ready(function(){
            $('.showtimepicker').daterangepicker({
                "singleDatePicker": true,
                "autoApply": true,
                "timePicker": true,
                "timePicker24Hour": true,
                "timePickerSeconds": true,

                locale: {
                format: 'HH:mm:ss',
                }

                }).on('show.daterangepicker', function(ev, picker) {
                    picker.container.find('.calendar-table').hide();

                });


        });
    </script>


@endsection
