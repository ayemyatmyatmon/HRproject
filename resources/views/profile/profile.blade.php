@extends('layouts.app')
@section('title','Profile')
@section('content')
<div class="card mb-3">
    <div class="show_img text-center py-3">
        <img src="{{$employee->employee_img_path()}}" alt="">
    </div>

    <div class="card-body">
        <div class="row text-center">
            <div class="col-md-6 ">
                <div class="showtext mb-2">
                    <span class="mb-1"><i class="fab fa-gg"></i> Employee_Id :</span>
                    <span class="text-muted">{{$employee->employee_id}}</span>
                </div>

                <div class="showtext  mb-2">
                    <span class="mb-1"><i class="fab fa-gg"></i> Name :</span>
                    <span class="text-muted">{{$employee->name}}</span>
                </div>

                <div class="showtext  mb-2">
                    <span class="mb-1"><i class="fab fa-gg"></i> Phone :</span>
                    <span class="text-muted">{{$employee->phone}}</span>
                </div>

                <div class="showtext  mb-2">
                    <span class="mb-1"><i class="fab fa-gg"></i> Email :</span>
                    <span class="text-muted">{{$employee->email}}</span>
                </div>

                <div class="showtext  mb-2">
                    <span class="mb-1"><i class="fab fa-gg"></i> NRC Number :</span>
                    <span class="text-muted">{{$employee->nrc_number}}</span>
                </div>

                <div class="showtext mb-2">
                    <span class="mb-1"><i class="fab fa-gg"></i> Birthday :</span>
                    <span class="text-muted">{{$employee->birthday}}</span>
                </div>
            </div>

            <div class="col-md-6 text-border">
                <div class="showtext mb-2">
                    <span class="mb-1"><i class="fab fa-gg"></i> address :</span>
                    <span class="text-muted">{{$employee->address}}</span>
                </div>

                <div class="showtext mb-2">
                    <span class="mb-1"><i class="fab fa-gg"></i> Department :</span>
                    <span class="text-muted">
                        {{$employee->department ? $employee->department->title :'-'}}
                    </span>
                </div>

                <div class="showtext mb-2">
                    <span class="mb-1"><i class="fab fa-gg"></i> Date_of_join :</span>
                    <span class="text-muted">
                        {{$employee->date_of_join}}
                    </span>
                </div>

                <div class="showtext mb-2">
                    <span class="mb-1"><i class="fab fa-gg"></i> Gender :</span>
                    <span class="text-muted">
                        {{ucfirst($employee->gender)}}
                    </span>
                </div>

                <div class="showtext mb-2">
                    <span class="mb-1"><i class="fab fa-gg"></i> Is Present? :</span>
                    <span class="text-muted">
                        @if($employee->is_present==1)
                        <span class="badge badge-pill badge-theme">Present</span>
                        @else
                        <span class="badge badge-pill badge-danger">Present</span>
                        @endif
                    </span>
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

<div class="card mb-3 ">
    <div class="card-body">
        <form id="biometric-register-form">
            <button class="biometric-register-btn btn">
                <i class="fas fa-fingerprint"></i>
                <i class="fas fa-plus-circle"></i>
            </button>
        </form>
    </div>

</div>

<div class="card mb-3">
    <div class="card-body">
        <div class="btn btn-theme logout_btn btn-block"><i class="fas fa-sign-out-alt"></i> Logout</div>
    </div>
</div>

@endsection

@section('scripts')

    <script>
        $(document).ready(function(){
            const register = (event) => {
                    event.preventDefault()
                    new Larapass({
                        register: 'webauthn/register',
                        registerOptions: 'webauthn/register/options'
                    }).register()
                    .then(function(response){
                        Toast.fire({
                        icon: 'success',
                        title: "Successfully",
                        });
                    })
                    .catch(function(response){
                        console.log(response);
                    })
                };

                document.getElementById('biometric-register-form').addEventListener('submit', register);


            $('.logout_btn').on('click',function(e){
                e.preventDefault();
                Swal.fire({
                text: "Are You Sure,Do You want to Logout?",
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok',
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                    'url':'/logout',
                    'type':'POST',
                    success:function(res){
                        window.location.reload();
                    }
                    });
                    }
                });

            });

        });

    </script>
@endsection
