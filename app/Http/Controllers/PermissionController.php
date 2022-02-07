<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\StorePermission;
use App\Http\Requests\UpdatePermission;
use Spatie\Permission\Models\Permission;



class PermissionController extends Controller
{
    public function index(){
        if(!auth()->user()->can('view_permission')){
            abort(403, 'Unauthorized Action.');
        }
        return view('permission.index');
    }

    public function ssd(Request $request){
        if(!auth()->user()->can('view_permission')){
            abort(403, 'Unauthorized Action.');
        }
        $permission=Permission::query();
        return Datatables::of($permission)

        ->addColumn('plus_icon',function($each){
            return null;
        })
        ->editColumn('name',function($each){
            return '<p>'.$each->name.'</p>';
        })

        ->addColumn('action',function($each){
            $edit_icon='';
            $delete_icon='';
            if(auth()->user()->can('edit_permission')){
                $edit_icon='<a class="text-warning" href="'.route('permission.edit',$each->id).'"><i class="fas fa-edit"></i></a>';
            }
            if(auth()->user()->can('delete_permission')){
                $delete_icon='<a class="delete text-danger" href="#" data-id="'.$each->id.'"><i class="fas fa-trash"></i></a>';
            }


            return '<div class="icons" >'.$edit_icon.$delete_icon.'</div>';
        })
        ->editColumn('updated_at',function($each){
            return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s A');
        })

        ->rawColumns(['action','name'])
        ->make(true);
    }

    public function create(){
        if(!auth()->user()->can('create_permission')){
            abort(403, 'Unauthorized Action.');
        }
        return view('permission.create');
    }

    public function store(StorePermission $request){
        if(!auth()->user()->can('create_permission')){
            abort(403, 'Unauthorized Action.');
        }
        $permission=new Permission;
        $permission->name=$request->name;
        $permission->save();

        return redirect('permission')->with(['create'=>'Successfully Created']);


    }
    public function edit($id){
        if(!auth()->user()->can('edit_permission')){
            abort(403, 'Unauthorized Action.');
        }
        $permission=Permission::findOrFail($id);
        return view('permission.edit',compact('permission'));
    }

    public function update($id,UpdatePermission $request){
        if(!auth()->user()->can('edit_permission')){
            abort(403, 'Unauthorized Action.');
        }
        $permission=Permission::findOrFail($id);

        $permission->name=$request->name;
        $permission->update();
        return redirect('permission')->with(['update'=>'Successfully Updated']);
    }

    public function destroy($id){
        if(!auth()->user()->can('delete_permission')){
            abort(403, 'Unauthorized Action.');
        }
        $permission=Permission::findOrFail($id);
        $permission->delete($id);
        return "success";

    }

}
