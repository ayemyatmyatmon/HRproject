@extends('layouts.app')
@section('title','Detail Project')
@section('extr.css')
<style>
    .alert-warning {
        background: #fff3cd88 !important;
    }

    .task-item {
        background: #fff;
        border: 1px solid #fff;
        padding: 9px;
        border-radius: 7px;
    }
    .add_task_btn{
        border: 1px solid #ddd;
        display: block;
        padding: 10px;
        text-align: center;
        background: #fff;
        border-radius: 5px;
        cursor: pointer;

    }
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-md-9">
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{$project->title}}</h5>

                <p class="mb-1">Start Date : <span class="text-muted">{{$project->start_date}}</span> , Dead Line :
                    <span class="text-muted">{{$project->deadline}}</span></p>
                <p class="mb-3">
                    @if ($project->priority=='high')
                    <span>Priority : </span> <span class="badge badge-pill badge-primary"> {{$project->priority}}
                    </span>
                    @elseif($project->priority=="middle")
                    <span>Priority : </span> <span class="badge badge-pill  badge-success"> {{$project->priority}}
                    </span>
                    @elseif($project->priority=="low")
                    <span>Priority : </span> <span class="badge badge-pill badge-danger"> {{$project->priority}} </span>
                    @endif
                    ,
                    @if ($project->status=='pending')
                    <span>Status : </span> <span class="badge badge-pill badge-dark"> {{$project->status}} </span>
                    @elseif($project->status=="in_progress")
                    <span>Status : </span> <span class="badge badge-pill badge-warning"> {{$project->status}} </span>
                    @elseif($project->status=="complete")
                    <span>Status : </span> <span class="badge badge-pill badge-info"> {{$project->status}} </span>
                    @endif
                </p>

                <h5>Description</h5>
                <p>{{$project->description}}</p>
            </div>

        </div>
    </div>
    <div class="col-md-3">
        <div class="card mb-3">
            <div class="card-body ">
                <h5>Leaders</h5>
                @foreach ($project->leaders as $leader )
                <img class="image_thumbnails" src="{{$leader->employee_img_path()}}">
                @endforeach
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <h5>Members</h5>
                @foreach ($project->members as $member )
                <img class="image_thumbnails" src="{{$member->employee_img_path()}}">
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-9">
        <div class="card mb-3">
            <div class="card-body">
                <div id="images">
                    <h5>Images</h5>
                    @if( $project->images)
                    @foreach ($project->images as $image)
                    <img class="image_thumbnails" src="{{asset('storage/project/'.$image)}}">
                    @endforeach
                    @endif
                </div>
                <hr>
                <div id="images">
                    <h5>Files</h5>
                    @if( $project->files)
                    @foreach ($project->files as $file)
                    <a href="#" class="file-thumbnail text-dark" href="{{asset('storage/project/'.$file)}}"
                        target="_blank"><i class="far fa-file-pdf"></i></a>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

<div id="task"></div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        var project_id="{{$project->id}}";
        taskData();
        function taskData(){
            $.ajax({
            url:`/tasks-datas?project_id=${project_id}`,
            type:'GET',
            success:function(res){
                $('#task').html(res);
            }
        });
        }
        new Viewer(document.getElementById('images'));
        $(document).on('click','.pending_task_btn',function(e){
            e.preventDefault();
            var leaders=@json($project->leaders);
            var members=@json($project->members);
            var data_task=$(this).data('task');
            var task_members=$(this).data('task-member');
            var task_members_options="";


                leaders.forEach(function(leader){
                    task_members_options+=`<option value="${leader.id}">${leader.name}</option>`;

                });
                members.forEach(function(member){
                    task_members_options+=`<option value="${member.id}">${member.name}</option>`;

                });
                Swal.fire({
                title: 'Are you Sure Add Task? ',
                showCancelButton: true,
                html:`<form class="task_form">
                    <input type="hidden" name="project_id" value="${project_id}">
                    <input type="hidden" name="status" value="pending">

                    <div class="md-form">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>

                    <div class="md-form">
                        <label>Description</label>
                        <textarea  name="description" rows="5" class="form-control md-textarea"></textarea>
                    </div>

                    <div class="md-form">
                        <label>Start Date</label>
                        <input type="text" name="start_date" class="form-control date_time" >
                    </div>

                    <div class="md-form">
                        <label>Dead Line</label>
                        <input type="text" name="deadline" class="form-control date_time" >
                    </div>

                    <div class="form-group">
                        <div class="text-left">
                        <label >Priority</label>
                        </div>
                        <select class="form-control role_box" name="priority">
                            <option value="high">High</option>
                            <option value="middle">Middle</option>
                            <option value="low">Low</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="text-left">
                        <label >Members</label>
                        </div>
                        <select class="form-control role_box" name="members[]" multiple>
                            <option value="">--Select Option--</option>
                            ${task_members_options}
                        </select>
                    </div>
                </form>`,

                confirmButtonText: 'Confirm',
                }).then((result) =>{
                    if (result.isConfirmed){
                        var task_data=$('.task_form').serialize();
                        $.ajax({
                            url :'/task',
                            type:'POST',
                            data:task_data,
                            success:function(res){
                                taskData();
                            }
                        })
                    }

                });

                $('.date_time').daterangepicker({
                        "format":"YYYY-MMM-DD",
                        "singleDatePicker": true,
                        "autoApply": true,
                        "showDropdowns": true,
                        locale: {
                        format: 'YYYY-MM-DD'
                        }
                });
                $('.role_box').select2({
                    theme: 'bootstrap4',
                    placeholder:'--Select Option---',
                });
        });

        $(document).on('click','.in_progress_task_btn',function(e){
            e.preventDefault();
            var leaders=@json($project->leaders);
            var members=@json($project->members);
            var data_task=$(this).data('task');
            var task_members=$(this).data('task-member');
            var task_members_options="";


                leaders.forEach(function(leader){
                    task_members_options+=`<option value="${leader.id}">${leader.name}</option>`;

                });
                members.forEach(function(member){
                    task_members_options+=`<option value="${member.id}">${member.name}</option>`;

                });
                Swal.fire({
                title: 'Are you Sure Add Task? ',
                showCancelButton: true,
                html:`<form class="task_form">
                    <input type="hidden" name="project_id" value="${project_id}">
                    <input type="hidden" name="status" value="in_progress">

                    <div class="md-form">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>

                    <div class="md-form">
                        <label>Description</label>
                        <textarea  name="description" rows="5" class="form-control md-textarea"></textarea>
                    </div>

                    <div class="md-form">
                        <label>Start Date</label>
                        <input type="text" name="start_date" class="form-control date_time" >
                    </div>

                    <div class="md-form">
                        <label>Dead Line</label>
                        <input type="text" name="deadline" class="form-control date_time" >
                    </div>

                    <div class="form-group">
                        <div class="text-left">
                        <label >Priority</label>
                        </div>
                        <select class="form-control role_box" name="priority">
                            <option value="high">High</option>
                            <option value="middle">Middle</option>
                            <option value="low">Low</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="text-left">
                        <label >Members</label>
                        </div>
                        <select class="form-control role_box" name="members[]" multiple>
                            <option value="">--Select Option--</option>
                            ${task_members_options}
                        </select>
                    </div>
                </form>`,

                confirmButtonText: 'Confirm',
                }).then((result) =>{
                    if (result.isConfirmed){
                        var task_data=$('.task_form').serialize();
                        $.ajax({
                            url :'/task',
                            type:'POST',
                            data:task_data,
                            success:function(res){
                                taskData();
                            }
                        })
                    }

                });

                $('.date_time').daterangepicker({
                        "format":"YYYY-MMM-DD",
                        "singleDatePicker": true,
                        "autoApply": true,
                        "showDropdowns": true,
                        locale: {
                        format: 'YYYY-MM-DD'
                        }
                });
                $('.role_box').select2({
                    theme: 'bootstrap4',
                    placeholder:'--Select Option---',
                });
        });
        $(document).on('click','.complete_task_btn',function(e){

            e.preventDefault();
            var leaders=@json($project->leaders);
            var members=@json($project->members);
            var data_task=$(this).data('task');
            var task_members=$(this).data('task-member');
            var task_members_options="";
                leaders.forEach(function(leader){
                    task_members_options+=`<option value="${leader.id}">${leader.name}</option>`;

                });
                members.forEach(function(member){
                    task_members_options+=`<option value="${member.id}">${member.name}</option>`;

                });
                Swal.fire({
                title: 'Are you Sure Add Task? ',
                showCancelButton: true,
                html:`<form class="task_form">
                    <input type="hidden" name="project_id" value="${project_id}">
                    <input type="hidden" name="status" value="complete">

                    <div class="md-form">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>

                    <div class="md-form">
                        <label>Description</label>
                        <textarea  name="description" rows="5" class="form-control md-textarea"></textarea>
                    </div>

                    <div class="md-form">
                        <label>Start Date</label>
                        <input type="text" name="start_date" class="form-control date_time" >
                    </div>

                    <div class="md-form">
                        <label>Dead Line</label>
                        <input type="text" name="deadline" class="form-control date_time" >
                    </div>

                    <div class="form-group">
                        <div class="text-left">
                        <label >Priority</label>
                        </div>
                        <select class="form-control role_box" name="priority">
                            <option value="high">High</option>
                            <option value="middle">Middle</option>
                            <option value="low">Low</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="text-left">
                        <label >Members</label>
                        </div>
                        <select class="form-control role_box" name="members[]" multiple>
                            <option value="">--Select Option--</option>
                            ${task_members_options}
                        </select>
                    </div>
                </form>`,

                confirmButtonText: 'Confirm',
                }).then((result) =>{
                    if (result.isConfirmed){
                        var task_data=$('.task_form').serialize();
                        $.ajax({
                            url :'/task',
                            type:'POST',
                            data:task_data,
                            success:function(res){
                                taskData();
                            }
                        })
                    }

                });

                $('.date_time').daterangepicker({
                        "format":"YYYY-MMM-DD",
                        "singleDatePicker": true,
                        "autoApply": true,
                        "showDropdowns": true,
                        locale: {
                        format: 'YYYY-MM-DD'
                        }
                });
                $('.role_box').select2({
                    theme: 'bootstrap4',
                    placeholder:'--Select Option---',
                });
        });

        $(document).on('click','.task_edit_btn',function(e){
            e.preventDefault();

            var data_task=$(this).data('task');
            var task=(JSON.parse(atob(data_task)));
            var task_members=$(this).data('task-member');
            var task_members_options="";
            var leaders=@json($project->leaders);
            var members=@json($project->members);

                leaders.forEach(function(leader){
                    task_members_options+=`<option value="${leader.id}" ${task_members.includes(leader.id) ? 'selected' :'-'}>${leader.name}</option>`;

                });
                members.forEach(function(member){
                    task_members_options+=`<option value="${member.id}" ${task_members.includes(member.id) ? 'selected' :'-'}>${member.name}</option>`;

                });
                Swal.fire({
                title: 'Are you Sure Edit Task? ',
                showCancelButton: true,
                html:`<form class="edit_task_form">
                    <input type="hidden" name="project_id" value="${project_id}">

                    <div class="md-form">
                        <label class="active">Title</label>
                        <input type="text" name="title" class="form-control" value="${task.title}">
                    </div>

                    <div class="md-form">
                        <label class="active">Description</label>
                        <textarea  name="description" rows="5" class="form-control md-textarea">${task.description}</textarea>
                    </div>

                    <div class="md-form">
                        <label class="active"> Start Date</label>
                        <input type="text" name="start_date" class="form-control date_time" value="${task.start_date}">
                    </div>

                    <div class="md-form">
                        <label class="active">Dead Line</label>
                        <input type="text" name="deadline" class="form-control date_time" value="${task.deadline}" >
                    </div>

                    <div class="form-group">
                        <div class="text-left">
                        <label>Priority</label>
                        </div>
                        <select class="form-control role_box" name="priority">
                            <option value="high" ${(task.priority) =="high" ? "selected" : '-'}>High</option>
                            <option value="middle" ${(task.priority) =="middle" ? "selected" : '-'}>Middle</option>
                            <option value="low" ${(task.priority) =="low" ? "selected" : '-'}>Low</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="text-left">
                        <label  >Members</label>
                        </div>
                        <select class="form-control role_box" name="members[]" multiple>
                            <option value="">--Select Option--</option>
                            ${task_members_options}
                        </select>
                    </div>
                </form>`,

                confirmButtonText: 'Confirm',
                }).then((result) =>{
                    if (result.isConfirmed){
                        var task_data=$('.edit_task_form').serialize();
                        $.ajax({
                            url :`/task/${task.id}`,
                            type:'PUT',
                            data:task_data,
                            success:function(res){
                                taskData();
                            }
                        })
                    }

                });

                $('.date_time').daterangepicker({
                        "format":"YYYY-MMM-DD",
                        "singleDatePicker": true,
                        "autoApply": true,
                        "showDropdowns": true,
                        locale: {
                        format: 'YYYY-MM-DD'
                        }
                });
                $('.role_box').select2({
                    theme: 'bootstrap4',
                    placeholder:'--Select Option---',
                });
        });
        $(document).on('click','.task_delete_btn',function(e){
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
                    url :'/task/' + id,
                    type:'DELETE',
                    success:function(res){
                        taskData();
                        }
                        });
                    }
                });
            });
    })

</script>


@endsection
