<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Department;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\StoreDepartment;
use App\Http\Requests\UpdateDepartment;


class DepartmentController extends Controller
{
    public function index(){
        if(!auth()->user()->can('view_department')){
            abort(403, 'Unauthorized Action.');
        }

        return view('department.index');
    }

    public function ssd(Request $request){
        if(!auth()->user()->can('view_department')){
            abort(403, 'Unauthorized Action.');
        }
        $department=Department::query();
        return Datatables::of($department)

        ->addColumn('plus_icon',function($each){
            return null;
        })
        ->editColumn('title',function($each){
            return '<p>'.$each->title.'</p>';
        })

        ->addColumn('action',function($each){
            $edit_icon='';
            $delete_icon='';

            if(auth()->user()->can('edit_department')){
                $edit_icon='<a class="text-warning" href="'.route('department.edit',$each->id).'"><i class="fas fa-edit"></i></a>';
            }

            if(auth()->user()->can('delete_department')){
                $delete_icon='<a class="delete text-danger" href="#" data-id="'.$each->id.'"><i class="fas fa-trash"></i></a>';
            }

            return '<div class="icons" >'.$edit_icon.$delete_icon.'</div>';
        })
        ->editColumn('updated_at',function($each){
            return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s A');
        })

        ->rawColumns(['action','title'])
        ->make(true);
    }

    public function create(){
        if(!auth()->user()->can('create_department')){
            abort(403, 'Unauthorized Action.');
        }
        return view('department.create');
    }

    public function store(StoreDepartment $request){
        if(!auth()->user()->can('create_department')){
            abort(403, 'Unauthorized Action.');
        }
        $department=new Department;
        $department->title=$request->title;
        $department->save();

        return redirect('department')->with(['create'=>'Successfully Created']);


    }
    public function edit($id){
        if(!auth()->user()->can('edit_department')){
            abort(403, 'Unauthorized Action.');
        }
        $department=Department::findOrFail($id);
        return view('department.edit',compact('department'));
    }

    public function update($id,UpdateDepartment $request){
        if(!auth()->user()->can('edit_department')){
            abort(403, 'Unauthorized Action.');
        }
        $department=Department::findOrFail($id);

        $department->title=$request->title;
        $department->update();
        return redirect('department')->with(['update'=>'Successfully Updated']);
    }

    public function destroy($id){
        if(!auth()->user()->can('delete_department')){
            abort(403, 'Unauthorized Action.');
        }
        $department=Department::findOrFail($id);
        $department->delete($id);
        return "success";

    }

}
