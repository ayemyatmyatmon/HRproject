@extends('layouts.app')
@section('title','Edit Project')
@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{route('project.update',$project->id)}}" method="POST" autocomplete="off" id="edit-form"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="md-form">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="{{$project->title}}">
            </div>

            <div class="md-form">
                <label>Description</label>
                <textarea class="form-control md-textarea" name="description"
                    rows="5">{{$project->description}}</textarea>
            </div>

            <div class="form-group">
                <label for="images"> Image Only(PNG ,JPG,JPEG)</label>
                <input type="file" class="form-control p-1" name="images[]" id="image" multiple
                    accept=".png,.jpg,.jpeg" />

                <div class="preview_img my-2">
                    @if ($project->images)
                    @foreach ($project->images as $image)
                    <img src="{{asset('storage/project/'.$image)}}">
                    @endforeach
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="files"> Files</label>
                <input type="file" class="form-control p-1" name="files[]" multiple accept="application/pdf">
                <div class="my-2">
                    @if ($project->files)
                    @foreach ($project->files as $file)
                    <div class="file-thumbnail">
                        <a href="{{asset('storage/project/'.$file)}}" target="_blank" class="file-name"> <i
                                class="far fa-file-pdf"></i></a>

                    </div>
                    @endforeach
                    @endif
                </div>
            </div>

            <div class="md-form">
                <label>Start Date</label>
                <input type="text" name="start_date" class="form-control date_of_join" value="{{$project->start_date}}">
            </div>

            <div class="md-form">
                <label>DeadLine</label>
                <input type="text" name="deadline" class="form-control date_of_join" value="{{$project->deadline}}">
            </div>

            <div class="form-group">
                <label>Priority</label>
                <select class="form-control" name="priority">
                    <option value="high" @if($project->priority=="high") selected @endif>High</option>
                    <option value="middle" @if($project->priority=="middle") selected @endif>Middle</option>
                    <option value="low" @if($project->priority=="low") selected @endif>Low</option>
                </select>
            </div>

            <div class="form-group">
                <label>Project Leaders</label>
                <select class="form-control role_box" name="leaders[]" multiple>
                    @foreach($users as $user)
                    <option value="{{$user->id}}" @if(in_array($user->id,$old_leader_arrays))selected @endif
                        >{{$user->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Project Members</label>
                <select class="form-control role_box" name="members[]" multiple>
                    @foreach($users as $user)
                    <option value="{{$user->id}}" @if(in_array($user->id,$old_member_arrays))selected @endif
                        >{{$user->name}}</option>
                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <label>Status</label>
                <select class="form-control" name="status">
                    <option value="pending" @if ($project->status=="pending") selected @endif>Pending</option>
                    <option value="in_progress" @if ($project->status=="in_progress") selected @endif>In Progress
                    </option>
                    <option value="complete" @if ($project->status=="complete") selected @endif>Complete</option>
                </select>
            </div>

            <button class="btn btn-theme btn-block btn-sm">Update</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\UpdateProject', '#edit-form'); !!}
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
