@extends('layouts.app')
@section('title','Edit Department')
@section('content')

    <div class="card" >
        <div class="card-body">
            <form action="{{route('salary.update',$salary->id)}}" method="POST" autocomplete="off" id="edit-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>Employee</label>
                    <select class="form-control js-example-basic-single" name="user_id">
                        <option value=""> --Please Choose --</option>
                        @foreach ($employees as $employee )
                        <option value="{{$employee->id}}" @if(old('user_id')==$employee->user_id) selected @endif>{{$employee->employee_id}} ({{$employee->name}})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Month</label>
                    <select class="form-control select-month" name="month" >
                        <div class="form-group">
                            <option value="">--Please Choose--</option>
                            <option value="02" @if($salary->month=="02") selected @endif>Feb</option>
                            <option value="01" @if($salary->month=="01") selected @endif>Jan</option>
                            <option value="03" @if($salary->month=="03") selected @endif>Mar</option>
                            <option value="04" @if($salary->month=="04") selected @endif>Apr</option>
                            <option value="05" @if($salary->month=="05") selected @endif>May</option>
                            <option value="06" @if($salary->month=="06") selected @endif>Jun</option>
                            <option value="07" @if($salary->month=="07") selected @endif>Jul</option>
                            <option value="08" @if($salary->month=="08") selected @endif>Aug</option>
                            <option value="09" @if($salary->month=="09") selected @endif>Sep</option>
                            <option value="10" @if($salary->month=="10") selected @endif>Oct</option>
                            <option value="11" @if($salary->month=="11") selected @endif>Nov</option>
                            <option value="12" @if($salary->month=="12") selected @endif>Dec</option>
                        </div>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Year</label>

                    <select class="form-control select-year" name="year">
                        <div class="form-group">
                            <option value="">--Please Choose--</option>
                            @for($i=0;$i<15;$i++)
                                <option value="{{now()->addYears(5)->subYears($i)->format('Y')}}" @if($salary->year==now()->addYears(5)->subYears($i)->format('Y')) selected @endif>{{now()->addYears(5)->subYears($i)->format('Y')}}</option>
                            @endfor
                        </div>
                    </select>
                </div>
                <div class="md-form">
                    <label>Amount</label>
                    <input type="text" class="form-control" name="amount" value="{{$salary->amount}}">
                </div>

                <button class="btn btn-theme btn-block btn-sm">Update</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\UpdateSalary', '#edit-form'); !!}
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
