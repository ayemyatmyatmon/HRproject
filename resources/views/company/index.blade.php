@extends('layouts.app')
@section('title','Employee')
@section('content')
    <div>
        @can('create_employee')
        <a href="{{route('employee.create')}}" class="btn btn-theme btn-sm"><i class="fas fa-plus-circle"></i> Create Employee</a>
        @endcan
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered Datatable dt-responsive" style="width:100%;">
                <thead class="text-center">
                    <th class="no-sort no-serch"></th>
                    <th class="no-sort"></th>
                    <th>Emplyee ID</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Department Name</th>
                    <th>Role Name</th>
                    <th>Is Present?</th>
                    <th class="no-sort">Action</th>
                    <th class="hidden no-serch">Updated_at</th>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
           var table= $('.Datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/employee/datatable/ssd',
                columns: [
                    { data: 'plus_icon', name: 'plus_icon' ,class:'text-center'},
                    { data: 'profile_img', name: 'profile_img' ,class:'text-center'},
                    { data: 'employee_id', name: 'employee_id' ,class:'text-center'},
                    { data: 'phone', name: 'phone' ,class:'text-center'},
                    { data: 'email', name: 'email' ,class:'text-center'},
                    { data: 'department_name', name: 'department_name' ,class:'text-center'},
                    { data: 'role_name', name: 'role_name' ,class:'text-center'},
                    { data: 'is_present', name: 'is_present' ,class:'text-center'},
                    { data: 'action', name: 'action' ,class:'text-center'},
                    { data: 'updated_at', name: 'updated_at' ,class:'text-center'},

                ],
                order: [[ 9, "desc" ]],
                columnDefs: [


                    {
                        "targets": [ 0 ],
                        "class": "control"
                    },
                    {
                        "targets": 'hidden',
                        "visible": false

                    },
                    {
                        "targets": 'no-sort',
                        "orderable": false

                    },
                    {
                        "targets": 'no-search',
                        "searchable": false

                    }
                ],
                language:{

                    "paginate": {
                    "next":       "<i class='far fa-arrow-alt-circle-right'></i>",
                    "previous":   "<i class='far fa-arrow-alt-circle-left'></i>"
                    },
                    "processing":"<img src='/image/loadingone.gif' style='width:40px'/> <p>Loading...</p>  " ,

                }

            });

            $(document).on('click','.delete',function(e){
                e.preventDefault();
                var id=$(this).data('id');
                Swal.fire({
                text: "Are You Sure,Do You want to Delete?",
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm',
                }).then((result) => {
                if (result.isConfirmed) {
                   $.ajax({
                    url :'/employee/' + id,
                    type:'DELETE',
                    success:function(res){
                        table.ajax.reload();
                        }
                        });
                    }
                });
            });
        });
    </script>


@endsection
