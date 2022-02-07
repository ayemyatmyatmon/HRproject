@extends('layouts.app')
@section('title','Create Salary')
@section('content')

    <div class="card" >
        <div class="card-body">
            <form action="{{route('salary.store')}}" method="POST" autocomplete="off" id="create-form">
                @csrf
                <div class="mb-3">
                    <label>Employee</label>
                    <select class="form-control js-example-basic-single" name="user_id">
                        <option value=""> --Please Choose Employee--</option>
                        @foreach ($employees as $employee )
                        <option value="{{$employee->id}}" >{{$employee->employee_id}} ({{$employee->name}})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Month</label>
                    <select class="form-control select-month" name="month">
                        <div class="form-group">
                            <option value="">--Please Choose--</option>
                            <option value="01">Jan</option>
                            <option value="02">Feb</option>
                            <option value="03">Mar</option>
                            <option value="04">Apr</option>
                            <option value="05">May</option>
                            <option value="06">Jun</option>
                            <option value="07">Jul</option>
                            <option value="08">Aug</option>
                            <option value="09">Sep</option>
                            <option value="10">Oct</option>
                            <option value="11">Nov</option>
                            <option value="12">Dec</option>
                        </div>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Year</label>

                    <select class="form-control select-year" name="year">
                        <div class="form-group">
                            <option value="">--Please Choose--</option>
                            @for($i=0;$i<15;$i++)
                                <option value="{{now()->addYears(5)->subYears($i)->format('Y')}}" >{{now()->addYears(5)->subYears($i)->format('Y')}}</option>
                            @endfor
                        </div>
                    </select>
                </div>
                <div class="md-form">
                    <label>Amount</label>
                    <input type="text" class="form-control" name="amount" >
                </div>
                <button class="btn btn-theme btn-block btn-sm mt-3">Confirm</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\StoreSalary', '#create-form'); !!}
    <script>
        $(document).ready(function(){
            $('.js-example-basic-single').select2({
                allowClear:true,
                placeholder:'--- Please Choose Employee ---',
            });

            $(".select-month").select2({
            placeholder: "--Please Choose (Month)--",
            allowClear: true,
            });

            $(".select-year").select2({
                placeholder: "--Please Choose (Year)--",
                allowClear: true,

            });
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
