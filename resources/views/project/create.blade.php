@extends('layouts.app')
@section('title','Create Project')
@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{route('project.store')}}" method="POST" autocomplete="off" id="create-form"
            enctype="multipart/form-data">
            @csrf
            <div class="md-form">
                <label>Title</label>
                <input type="text" name="title" class="form-control">
            </div>

            <div class="md-form">
                <label>Description</label>
                <textarea class="form-control md-textarea" name="description" rows="5"></textarea>
            </div>

            <div class="form-group">
                <label for="images"> Image Only(PNG ,JPG,JPEG)</label>
                <input type="file" class="form-control p-1" name="images[]" id="image" multiple
                    accept=".png,.jpg,.jpeg" />

                <div class="preview_img my-2">

                </div>
            </div>
            <div class="form-group">
                <label for="files"> Files</label>
                <input type="file" class="form-control p-1" name="files[]" multiple accept="application/pdf">
            </div>

            <div class="md-form">
                <label>Start Date</label>
                <input type="text" name="start_date" class="form-control date_of_join">
            </div>

            <div class="md-form">
                <label>DeadLine</label>
                <input type="text" name="deadline" class="form-control date_of_join">
            </div>

            <div class="form-group">
                <label>Priority</label>
                <select class="form-control role_box" name="priority">
                    <option value="high">High</option>
                    <option value="middle">Middle</option>
                    <option value="low">Low</option>
                </select>
            </div>

            <div class="form-group">
                <label>Project Leaders</label>
                <select class="form-control role_box" name="leaders[]" multiple>
                    @foreach($users as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Project Members</label>
                <select class="form-control role_box" name="members[]" multiple>
                    @foreach($users as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <label>Status</label>
                <select class="form-control role_box" name="status">
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="complete">Complete</option>
                </select>
            </div>
            <button class="btn btn-theme btn-block btn-sm mt-3">Confirm</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\StoreProject', '#create-form'); !!}
<script>
    $(document).ready(function(){
            $('.date_of_join').daterangepicker({
                "format":"YYYY-MMM-DD",
                "singleDatePicker": true,
                "autoApply": true,
                "showDropdowns": true,
                locale: {
                format: 'YYYY-MM-DD'
                }

            });
            $('#image').on('change',function(){
                var file_length=document.getElementById('image').files.length;
                $('.preview_img').html('');
                for(var i=0; i < file_length ;i++){
                    $('.preview_img').append(`<img src="${URL.createObjectURL(event.target.files[i])}" />`);
                }
            });
        });
</script>


@endsection
