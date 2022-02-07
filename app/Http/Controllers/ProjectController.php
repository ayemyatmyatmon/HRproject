<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProject;
use App\Http\Requests\UpdateProject;
use App\Project;
use App\Project_leaders;
use App\Project_members;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

class ProjectController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('view_project')) {
            abort(403, 'Unauthorized Action.');
        }

        return view('project.index');
    }

    public function ssd(Request $request)
    {
        if (!auth()->user()->can('view_project')) {
            abort(403, 'Unauthorized Action.');
        }
        $project = Project::query();
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
                $edit_icon = '';
                $delete_icon = '';
                $info_icon='';
                if(auth()->user()->can('view_project')){
                    $info_icon='<a class="text-info" href="'.route('project.show',$each->id).'"><i class="fas fa-info-circle"></i></a>';
                }
                if (auth()->user()->can('edit_project')) {
                    $edit_icon = '<a class="text-warning" href="' . route('project.edit', $each->id) . '"><i class="fas fa-edit"></i></a>';
                }

                if (auth()->user()->can('delete_project')) {
                    $delete_icon = '<a class="delete text-danger" href="#" data-id="' . $each->id . '"><i class="fas fa-trash"></i></a>';
                }

                return '<div class="icons" >' .$info_icon. $edit_icon . $delete_icon . '</div>';
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

    public function create()
    {
        if (!auth()->user()->can('create_project')) {
            abort(403, 'Unauthorized Action.');
        }
        $users = User::all();
        return view('project.create', compact('users'));
    }

    public function store(StoreProject $request)
    {

        if (!auth()->user()->can('create_project')) {
            abort(403, 'Unauthorized Action.');
        }

        $images_name = [];
        if ($request->hasfile('images')) {
            $images_file = $request->file('images');
            foreach ($images_file as $image_file) {

                $image_name = uniqid() . '-' . time() . '.' . $image_file->getClientOriginalExtension();
                Storage::disk('public')->put('project/' . $image_name, file_get_contents($image_file));
                $images_name[] = $image_name;
            }
        }

        $files_name = [];
        if ($request->hasfile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {

                $file_name = uniqid() . '-' . time() . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->put('project/' . $file_name, file_get_contents($file));
                $files_name[] = $file_name;
            }

        }

        $project = new Project;
        $project->title = $request->title;
        $project->description = $request->description;
        $project->images = $images_name;
        $project->files = $files_name;
        $project->start_date = $request->start_date;
        $project->deadline = $request->deadline;
        $project->priority = $request->priority;
        $project->status = $request->status;
        $project->save();

        foreach ($request->leaders ?? [] as $leader) {
            $project_leader[] = Project_leaders::firstOrCreate([
                'project_id' => $project->id,
                'user_id' => $leader,
            ]);

        }

        foreach ($request->members ?? [] as $member) {
            $project_member[] = Project_members::firstOrCreate([
                'project_id' => $project->id,
                'user_id' => $member,
            ]);
        }
        return redirect('project')->with(['create' => 'Successfully Created']);

    }
    public function edit($id)
    {
        if (!auth()->user()->can('edit_project')) {
            abort(403, 'Unauthorized Action.');
        }
        $project = Project::findOrFail($id);
        $users = User::all();
        $old_leader_arrays = ($project->leaders)->pluck('id')->toArray();
        $old_member_arrays = ($project->members)->pluck('id')->toArray();

        return view('project.edit', compact('project', 'users', 'old_leader_arrays', 'old_member_arrays'));
    }

    public function update($id, UpdateProject $request)
    {
        if (!auth()->user()->can('edit_project')) {
            abort(403, 'Unauthorized Action.');
        }
        $project = Project::findOrFail($id);

        $images_name = $project->images;
        if ($request->hasfile('images')) {
            $images_file = $request->file('images');
            foreach ($images_file as $image_file) {
                // Storage::disk('public')->delete('project/' . $image_file);
                $image_name = uniqid() . '-' . time() . '.' . $image_file->getClientOriginalExtension();
                Storage::disk('public')->put('project/' . $image_name, file_get_contents($image_file));
                $images_name[] = $image_name;
            }
        }
        $files_name = $project->files;
        if ($request->hasfile('files')) {

            $files = $request->file('files');
            foreach ($files as $file) {
                // Storage::disk('public')->delete('project/' . $file);
                $file_name = uniqid() . '-' . time() . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->put('project/' . $file_name, file_get_contents($file));
                $files_name[] = $file_name;
            }

        }

        $project->title = $request->title;
        $project->description = $request->description;
        $project->images = $images_name;
        $project->files = $files_name;
        $project->start_date = $request->start_date;
        $project->deadline = $request->deadline;
        $project->priority = $request->priority;
        $project->status = $request->status;
        $project->update();

        $project->leaders()->sync($request->leaders);
        $project->members()->sync($request->members);

        return redirect('project')->with(['update' => 'Successfully Updated']);
    }
    public function show($id){
        $project=Project::findOrFail($id);
        return view('project.show',compact('project'));
    }
    public function destroy($id)
    {
        if (!auth()->user()->can('delete_project')) {
            abort(403, 'Unauthorized Action.');
        }
        $project = Project::findOrFail($id);
        $project_leaders=Project_leaders::where('project_id',$project->id)->get();
        foreach($project_leaders as $project_leader){
            $project_leader->delete();
        }
        $project_members=Project_members::where('project_id',$project->id)->get();

        foreach($project_members as $project_member){
            $project_member->delete();
        }
        $project->delete($id);
        return "success";

    }

}
