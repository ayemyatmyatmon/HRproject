<?php

namespace App\Http\Controllers;

use App\Project;
use App\Project_leaders;
use App\Project_members;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

class MyProjectController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('view_project')){
            abort(403, 'Unauthorized Action.');
        }

        return view('myproject.index');
    }

    public function ssd(Request $request)
    {
        if (!auth()->user()->can('view_project')) {
            abort(403, 'Unauthorized Action.');
        }
        $project = Project::with('leaders','members')
        ->whereHas('leaders',function($query){
            $query->where('user_id',auth()->user()->id);
        })->orWhereHas('members',function($query){
            $query->where('user_id',auth()->user()->id);
        });
        return Datatables::of($project)

            ->addColumn('plus_icon', function ($each) {
                return null;
            })
            ->editColumn('description', function ($each) {
                return Str::limit($each->description, 150);
            })
            ->editColumn('priority', function ($each) {
                $output = '';
                if ($each->priority == 'high') {
                    return $output .= '<span class="badge badge-primary">' . $each->priority . '</span>';
                } else if ($each->priority == 'middle') {
                    return $output .= '<span class="badge badge-pill badge-success">' . $each->priority . '</span>';

                } else if ($each->priority == 'low') {
                    return $output .= '<span class="badge badge-pill badge-danger">' . $each->priority . '</span>';

                }
            })

            ->editColumn('status', function ($each) {
                $output = '';
                if ($each->status == 'pending') {
                    return $output .= '<span class="badge badge-dark">' . $each->status . '</span>';
                } else if ($each->status == 'in_progress') {
                    return $output .= '<span class="badge badge-pill badge-warning">' . $each->status . '</span>';

                } else if ($each->status == 'complete') {
                    return $output .= '<span class="badge badge-pill badge-info">' . $each->status . '</span>';

                }
            })

            ->editColumn('title', function ($each) {
                return '<p>' . $each->title . '</p>';
            })

            ->addColumn('action', function ($each) {

                $info_icon='';
                if(auth()->user()->can('view_project')){
                    $info_icon='<a class="text-info" href="'.route('my-project.show',$each->id).'"><i class="fas fa-info-circle"></i></a>';
                }
                return '<div class="icons" >' .$info_icon. '</div>';
            })
            ->addColumn('leaders', function ($each) {
                $output = '';
                foreach ($each->leaders as $leader) {
                    $output .= '<img class="image_thumbnail" src="' . $leader->employee_img_path() . '">';
                }
                return '<div class="leaders">' . $output . ' </div>';
            })
            ->addColumn('members', function ($each) {
                $output = '';
                foreach ($each->members as $member) {
                    $output .= '<img class="image_thumbnail" src="' . $member->employee_img_path() . '">';
                }
                return $output;
            })
            ->editColumn('updated_at', function ($each) {
                return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s A');
            })

            ->rawColumns(['action', 'title', 'priority', 'status', 'leaders', 'members'])
            ->make(true);
    }

    public function show($id){

        $project=Project::with('leaders','members','tasks')
        ->where('id',$id)
        ->where(function($query){
            $query->whereHas('leaders',function($q1){
                $q1->where('user_id',auth()->user()->id);
            })->orWhereHas('members',function($q1){
                $q1->where('user_id',auth()->user()->id);
            });
        })
        ->firstOrfail();


        return view('myproject.show',compact('project'));
    }

}
