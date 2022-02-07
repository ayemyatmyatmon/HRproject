@extends('layouts.app')
@section('title','Ninja Hr')
@section('content')
    <div class="card">

        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-12 ">
                    <div class="show_img px-3" >
                        <img src="{{$employee->employee_img_path()}}" alt="">
                    </div>
                    <div class="py-2">

                        <div class="showtext  mb-2">
                            <h6 style="font-weight: 500;">{{$employee->name}}</h6>
                        </div>

                        <div class="showtext mb-2 ">
                            <span class="text-muted"><span >{{$employee->employee_id}}</span>| <span class="text_theme">{{$employee->phone}}</span></span>
                        </div>

                        <div class="showtext  mb-2">
                            <span class="badge badge-pill badge-light">{{$employee->department ? $employee->department->title :'No Department'}}</span>
                        </div>
                        <div>
                            @foreach ($employee->roles as $role )
                            <span class="badge badge-pill badge-primary">{{$role->name}}</span>
                            @endforeach
                        </div>
                    </div>



                </div>


            </div>
        </div>
    </div>

@endsection
