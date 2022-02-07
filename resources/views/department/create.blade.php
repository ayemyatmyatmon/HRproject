@extends('layouts.app')
@section('title','Create Department')
@section('content')

    <div class="card" >
        <div class="card-body">
            <form action="{{route('department.store')}}" method="POST" autocomplete="off" id="d-form">
                @csrf
                <div class="md-form">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" >
                </div>
                <button class="btn btn-theme btn-block btn-sm mt-3">Confirm</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\StoreDepartment', '#create-form'); !!}
    <script>
        $(document).ready(function(){
           
        });
    </script>


@endsection
