<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRole;
use Yajra\Datatables\Datatables;
use App\Http\Requests\UpdateRole;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class RoleController extends Controller
{
    public function index(){
        // if(!auth()->user()->can('view_role')){
        //     abort(403, 'Unauthorized Action.');
        // }
        return view('role.index');
    }

    public function ssd(Request $request){
        // if(!auth()->user()->can('view_role')){
        //     abort(403, 'Unauthorized Action.');
        // }
        $role=Role::query();
        return Datatables::of($role)
        ->addColumn('permissions',function($each){
            $output='';
            foreach($each->permissions as $permission){
                $output.='<span class="badge badge-pill badge-primary m-1">'.$permission->name.'</span>';
            }
            return $output;
        })
        ->addColumn('plus_icon',function($each){
            return null;
        })
        ->editColumn('name',function($each){
            return '<p>'.$each->name.'</p>';
        })

        ->addColumn('action',function($each){
            $edit_icon='';
            $delete_icon='';
            // if(auth()->user()->can('edit_role')){
                $edit_icon='<a class="text-warning" href="'.route('role.edit',$each->id).'"><i class="fas fa-edit"></i></a>';
            // }
            // if(auth()->user()->can('delete_role')){
                $delete_icon='<a class="delete text-danger" href="#" data-id="'.$each->id.'"><i class="fas fa-trash"></i></a>';
            // }

            return '<div class="icons" >'.$edit_icon.$delete_icon.'</div>';
        })
        ->editColumn('updated_at',function($each){
            return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s A');
        })

        ->rawColumns(['action','name','permissions'])
        ->make(true);
    }

    public function create(){
        // if(!auth()->user()->can('create_role')){
        //     abort(403, 'Unauthorized Action.');
        // }
        $permissions=Permission::all();
        return view('role.create',compact('permissions'));
    }

    public function store(StoreRole $request){
        // if(!auth()->user()->can('create_role')){
        //     abort(403, 'Unauthorized Action.');
        // }
        $role=new Role;
        $role->name=$request->name;
        $role->save();
        $role->givePermissionTo($request->permissions);

        return redirect('role')->with(['create'=>'Successfully Created']);


    }
    public function edit($id){
        // if(!auth()->user()->can('edit_role')){
        //     abort(403, 'Unauthorized Action.');
        // }
        $role=Role::findOrFail($id);
        $permissions=Permission::all();
        $old_permission=$role->permissions->pluck('id')->toArray();
        return view('role.edit',compact('role','permissions','old_permission'));
    }

    public function update($id,UpdateRole $request){
        // if(!auth()->user()->can('edit_role')){
        //     abort(403, 'Unauthorized Action.');
        // }
        $role=Role::findOrFail($id);
        $role->name=$request->name;
        $role->update();
        $old_permission=$role->permissions->pluck('name')->toArray();
        $role->revokePermissionTo($old_permission);
        $role->givePermissionTo($request->permissions);


        return redirect('role')->with(['update'=>'Successfully Updated']);
    }

    public function destroy($id){
        // if(!auth()->user()->can('delete_role')){
        //     abort(403, 'Unauthorized Action.');
        // }
        $role=Role::findOrFail($id);
        $role->delete($id);
        return "success";

    }

}
