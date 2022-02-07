@extends('layouts.app')
@section('title','Detail Project')
@section('content')
<div class="row">
    <div class="col-md-9">
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{$project->title}}</h5>

                <p class="mb-1">Start Date : <span class="text-muted">{{$project->start_date}}</span> , Dead Line :
                    <span class="text-muted">{{$project->deadline}}</span>
                </p>
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
                <div id="image_views">
                    <h5>Leaders</h5>
                    @foreach ($project->leaders as $leader )
                    <img class="image_thumbnails" src="{{$leader->employee_img_path()}}">
                    @endforeach
                </div>
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
                <div id="images_view">
                    <h5>Images</h5>
                    @if( $project->images)
                    @foreach ($project->images as $image)
                    <img class="image_thumbnails" src="{{asset('storage/project/'.$image)}}">
                    @endforeach
                    @endif
                </div>

            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <h5>Files</h5>
                @if( $project->files)
                @foreach ($project->files as $file)
                <a class="file-thumbnail text-dark" href="{{asset('storage/project/'.$file)}}" target="_blank"><i
                        class="far fa-file-pdf"></i></a>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        new Viewer(document.getElementById('images_view'));

    })

</script>


@endsection
