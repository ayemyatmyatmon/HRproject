@extends('layouts.app')
@section('title','Project')
@section('content')

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered Datatable dt-responsive" style="width:100%;">
                <thead class="text-center">
                    <th class="no-sort no-serch"></th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Start Date</th>
                    <th>Deadline</th>
                    <th>Leaders</th>
                    <th>Members</th>
                    <th>Priority</th>
                    <th>Status</th>
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
                ajax: '/my-project/datatable/ssd',
                columns: [
                    { data: 'plus_icon', name: 'plus_icon' ,class:'text-center'},
                    { data: 'title', name: 'title' ,class:'text-center'},
                    { data: 'description', name: 'description' ,class:'text-center'},
                    { data: 'start_date', name: 'start_date' ,class:'text-center'},
                    { data: 'deadline', name: 'deadline' ,class:'text-center'},
                    { data: 'leaders', name: 'leaders' ,class:'text-center'},
                    { data: 'members', name: 'members' ,class:'text-center'},
                    { data: 'priority', name: 'priority' ,class:'text-center'},
                    { data: 'status', name: 'status' ,class:'text-center'},
                    { data: 'action', name: 'action' ,class:'text-center'},
                    { data: 'updated_at', name: 'updated_at' ,class:'text-center'},

                ],
                order: [[ 10, "desc" ]],
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


        });
    </script>


@endsection
