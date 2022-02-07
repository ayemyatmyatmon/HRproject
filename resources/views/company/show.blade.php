@extends('layouts.app')
@section('title','Company Setting')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row ">
                <div class="col-md-6">
                    <div>
                        <p class="mb-1">Compay Name</p>
                        <p class="text-muted">{{$setting->company_name}}</p>
                    </div>
                    <div>
                        <p class="mb-1">Compay Email</p>
                        <p class="text-muted">{{$setting->company_email}}</p>
                    </div>
                    <div>
                        <p class="mb-1">Compay Phone</p>
                        <p class="text-muted">{{$setting->company_phone}}</p>
                    </div>
                    <div>
                        <p class="mb-1">Compay Address</p>
                        <p class="text-muted">{{$setting->company_address}}</p>
                    </div>

                </div>
                <div class="col-md-6">
                    <div>
                        <p class="mb-1">Office Start Time</p>
                        <p class="text-muted">{{$setting->office_start_time}}</p>
                    </div>
                    <div>
                        <p class="mb-1">Office End Time</p>
                        <p class="text-muted">{{$setting->office_end_time}}</p>
                    </div>
                    <div>
                        <p class="mb-1">Break Start Time</p>
                        <p class="text-muted">{{$setting->break_start_time}}</p>
                    </div>
                    <div>
                        <p class="mb-1">Break End Time</p>
                        <p class="text-muted">{{$setting->break_end_time}}</p>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <a href="{{route('company-setting.edit',1)}}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit Company Setting
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
