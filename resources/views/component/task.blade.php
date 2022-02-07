<h5 >Tasks</h5>
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-warning text-white" ><i class="fas fa-tasks"></i> Pending</div>
            <div class="card-body alert-warning">
               @foreach (collect($project->tasks)->where('status','pending') as $task )
                <div class="task-item mb-1">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6>{{$task->title}}</h6>
                        </div>
                        <div class="task_action">
                            <a href="#" class="task_edit_btn" data-task="{{base64_encode(Json_encode($task))}}" data-task-member="{{Json_encode(collect($task->members)->pluck('id')->toArray())}} ">
                                <i class="fas fa-edit text-warning"></i>
                            </a>
                            <a href="#" class="task_delete_btn " data-id={{$task->id}}>
                                <i class="fas fa-trash-alt text-danger"></i>
                            </a>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="mb-0"><i class="fas fa-clock"></i> {{Carbon\Carbon::parse($task->start_date)->format('M d')}}</p>
                            @if ($task->priority=='high')
                            <span class="badge badge-pill badge-danger">High</span>
                            @elseif($task->priority=='middle')
                            <span class="badge badge-pill badge-info">Middle</span>
                            @elseif($task->priority=='low')
                            <span class="badge badge-pill badge-dark">Low</span>
                            @endif
                        </div>

                        <div>
                            @foreach ($task->members as $member )
                                <img class="image_thumbnail1" src="{{$member->employee_img_path()}}">
                            @endforeach
                        </div>
                    </div>


                </div>
               @endforeach
                <div class="add_task_btn mt-3">
                    <a href="#" class="text-dark pending_task_btn "><i class="fas fa-plus-circle"></i> Add Task</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info text-white"><i class="fas fa-tasks"></i> In Progress</div>
            <div class="card-body alert-info mb-1">
                @foreach (collect($project->tasks)->where('status','in_progress') as $task )
                    <div class="task-item mb-1">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6>{{$task->title}}</h6>
                            </div>
                            <div class="task_action">
                                <a href="#" class="task_edit_btn" data-task="{{base64_encode(Json_encode($task))}}" data-task-member="{{Json_encode(collect($task->members)->pluck('id')->toArray())}} ">
                                    <i class="fas fa-edit text-warning"></i>
                                </a>
                                <a href="#" class="task_delete_btn " data-id={{$task->id}}>
                                    <i class="fas fa-trash-alt text-danger"></i>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="mb-0"><i class="fas fa-clock"></i> {{Carbon\Carbon::parse($task->start_date)->format('M d')}}</p>
                                @if ($task->priority=='high')
                                <span class="badge badge-pill badge-danger">High</span>
                                @elseif($task->priority=='middle')
                                <span class="badge badge-pill badge-info">Middle</span>
                                @elseif($task->priority=='low')
                                <span class="badge badge-pill badge-dark">Low</span>
                                @endif
                            </div>

                            <div>
                                @foreach ($task->members as $member )
                                    <img class="image_thumbnail1" src="{{$member->employee_img_path()}}">
                                @endforeach
                            </div>
                        </div>


                    </div>
                @endforeach
                <div class="add_task_btn mt-3">
                    <a href="#" class="text-dark in_progress_task_btn "><i class="fas fa-plus-circle"></i> Add Task</a>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-success text-white"><i class="fas fa-tasks"></i> Complete</div>
            <div class="card-body alert-success mb-1">
                @foreach (collect($project->tasks)->where('status','complete') as $task )
                <div class="task-item mb-1">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6>{{$task->title}}</h6>
                        </div>
                        <div class="task_action">
                            <a href="#" class="task_edit_btn" data-task="{{base64_encode(Json_encode($task))}}" data-task-member="{{Json_encode(collect($task->members)->pluck('id')->toArray())}} ">
                                <i class="fas fa-edit text-warning"></i>
                            </a>
                            <a href="#" class="task_delete_btn " data-id={{$task->id}}>
                                <i class="fas fa-trash-alt text-danger"></i>
                            </a>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="mb-0"><i class="fas fa-clock"></i> {{Carbon\Carbon::parse($task->start_date)->format('M d')}}</p>
                            @if ($task->priority=='high')
                            <span class="badge badge-pill badge-danger">High</span>
                            @elseif($task->priority=='middle')
                            <span class="badge badge-pill badge-info">Middle</span>
                            @elseif($task->priority=='low')
                            <span class="badge badge-pill badge-dark">Low</span>
                            @endif
                        </div>

                        <div>
                            @foreach ($task->members as $member )
                                <img class="image_thumbnail1" src="{{$member->employee_img_path()}}">
                            @endforeach
                        </div>
                    </div>


                </div>
            @endforeach
            <div class="add_task_btn mt-3">
                <a href="#" class="text-dark complete_task_btn "><i class="fas fa-plus-circle"></i> Add Task</a>
            </div>
            </div>
        </div>
    </div>
</div>
