@extends('layouts.app')
@section('title','Salary')
@section('content')
    <div>
        @can('create_salary')
        <a href="{{route('salary.create')}}" class="btn btn-theme btn-sm"><i class="fas fa-plus-circle"></i> Create Salary</a>
        @endcan
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered Datatable dt-responsive" style="width:100%;">
                <thead class="text-center">
                    <th class="no-sort no-serch"></th>
                    <th>Employee Name</th>
                    <th class="no-sort">Month</th>
                    <th class="no-sort">Year</th>
                    <th class="no-sort">Amount (MMK)</th>
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
                ajax: '/salary/datatable/ssd',
                columns: [
                    { data: 'plus_icon', name: 'plus_icon' ,class:'text-center'},
                    { data: 'employee_name', name: 'employee_name' ,class:'text-center'},
                    { data: 'month', name: 'month' ,class:'text-center'},
                    { data: 'year', name: 'year' ,class:'text-center'},
                    { data: 'amount', name: 'amount' ,class:'text-center'},
                    { data: 'action', name: 'action' ,class:'text-center'},
                    { data: 'updated_at', name: 'updated_at' ,class:'text-center'},

                ],
                order: [[ 6, "desc" ]],
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
                    url :'/salary/' + id,
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
