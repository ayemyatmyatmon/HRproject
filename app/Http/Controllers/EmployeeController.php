<?php

namespace App\Http\Controllers;
use App\User;
use Carbon\Carbon;
use App\Department;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreEmployee;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateEmployee;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index(){
        if(!auth()->user()->can('view_employee')){
            abort(403, 'Unauthorized Action.');
        }
        return view('employee.index');
    }

    public function ssd(Request $request){
        if(!auth()->user()->can('view_employee')){
            abort(403, 'Unauthorized Action.');
        }
        $employees=User::with('department');
        return Datatables::of($employees)
        ->filterColumn('department_name',function($query,$keyword){
            $query->whereHas('department',function($q1) use($keyword){
                $q1->where('title','like','%'.$keyword.'%');
            });
        })
        ->addColumn('role_name',function($each){
            $output='';
            foreach($each->roles as $role){
                $output.='<span class="badge badge-pill badge-primary m-1">'.$role->name.'</span>';
            }
            return $output;

        })
        ->addColumn('department_name',function($each){
            $department_name=$each->department ? $each->department->title :'-';
            return $department_name;
        })
        ->editColumn('profile_img',function($each){
            return '<img src="'.$each->employee_img_path().'" class="profile_thumpnail"><p class="my-1">'.$each->name.'</p>';
        })
        ->addColumn('plus_icon',function($each){
            return null;
        })
        ->addColumn('action',function($each){
            $edit_icon='';
            $info_icon='';
            $delete_icon='';

            if(auth()->user()->can('edit_employee')){
                $edit_icon='<a class="text-warning" href="'.route('employee.edit',$each->id).'"><i class="fas fa-edit"></i></a>';
            }
            if(auth()->user()->can('view_employee')){
                $info_icon='<a class="text-primary" href="'.route('employee.show',$each->id).'"><i class="fas fa-info"></i></a>';

            }
            if(auth()->user()->can('delete_employee')){
                $delete_icon='<a class="delete text-danger" href="#" data-id="'.$each->id.'"><i class="fas fa-trash"></i></a>';
            }

            return '<div class="icons" >'.$edit_icon. $info_icon.$delete_icon.'</div>';
        })
        ->editColumn('updated_at',function($each){
            return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s A');
        })
        ->editColumn('is_present',function($each){
            if($each->is_present==1){
                return '<span class="badge badge-pill badge-success">Present</span>';

            }else{
                return '<span class="badge badge-pill badge-danger">Leave</span>';

            }
        })
        ->rawColumns(['is_present','action','profile_img','role_name'])
        ->make(true);
    }

    public function create(){
        if(!auth()->user()->can('create_employee')){
            abort(403, 'Unauthorized Action.');
        }

        $Departments=Department::orderBy('title')->get();
        $roles=Role::all();
        return view('employee.create',compact('Departments','roles'));
    }

    public function store(StoreEmployee $request){
        if(!auth()->user()->can('create_employee')){
            abort(403, 'Unauthorized Action.');
        }
        $profile_img_name=null;
        if($request->hasfile('profile_img')){
            $profile_img_file=$request->file('profile_img');
            $profile_img_name=uniqid().'.'.time().'.'.$profile_img_file->getClientOriginalExtension();
            Storage::disk('public')->put('employee/'.$profile_img_name, file_get_contents($profile_img_file));

        }
        $employees=new User;
        $employees->employee_id=$request->employee_id;
        $employees->name=$request->name;
        $employees->phone=$request->phone;
        $employees->email=$request->email;
        $employees->pin_code=$request->pin_code;
        $employees->password=Hash::make($request->password);
        $employees->nrc_number=$request->nrc_number;
        $employees->birthday=$request->birthday;
        $employees->gender=$request->gender;
        $employees->department_id=$request->department_id;
        $employees->date_of_join=$request->date_of_join;
        $employees->is_present=$request->is_present;
        $employees->address=$request->address;
        $employees->profile_img=$profile_img_name;
        $employees->save();
        $employees->syncRoles($request->roles);

        return redirect('employee')->with(['create'=>'Successfully Created']);


    }
    public function edit($id){
        if(!auth()->user()->can('edit_employee')){
            abort(403, 'Unauthorized Action.');
        }
        $employee=User::findOrFail($id);
        $Departments=Department::orderBy('title')->get();
        $roles=Role::all();
        $old_roles=$employee->roles->pluck('id')->toArray();
        return view('employee.edit',compact('employee','Departments','roles','old_roles'));
    }

    public function update($id,UpdateEmployee $request){
        if(!auth()->user()->can('edit_employee')){
            abort(403, 'Unauthorized Action.');
        }
        $employee=User::findOrFail($id);

        $profile_img_name=$employee->profile_img;
        if($request->hasfile('profile_img')){
            Storage::disk('public')->delete('employee/'.$employee->profile_img);

            $profile_img_file=$request->file('profile_img');
            $profile_img_name=uniqid().'.'.time().'.'.$profile_img_file->getClientOriginalExtension();
            Storage::disk('public')->put('employee/'.$profile_img_name, file_get_contents($profile_img_file));

        }
        $employee->employee_id=$request->employee_id;
        $employee->name=$request->name;
        $employee->phone=$request->phone;
        $employee->email=$request->email;
        $employee->pin_code=$request->pin_code;
        $employee->password=$request->password ? Hash::make($request->password) : $employee->password;
        $employee->nrc_number=$request->nrc_number;
        $employee->birthday=$request->birthday;
        $employee->gender=$request->gender;
        $employee->department_id=$request->department_id;
        $employee->date_of_join=$request->date_of_join;
        $employee->is_present=$request->is_present;
        $employee->address=$request->address;
        $employee->profile_img=$profile_img_name;
        $employee->update();
        $employee->syncRoles($request->roles);
        return redirect('employee')->with(['update'=>'Successfully Updated']);
    }

    public function show($id){
        if(!auth()->user()->can('view_employee')){
            abort(403, 'Unauthorized Action.');
        }
        $employee=User::findOrFail($id);
        return view('employee.show',compact('employee'));
    }
    public function destroy($id){
        if(!auth()->user()->can('delete_employee')){
            abort(403, 'Unauthorized Action.');
        }
        $employee=User::findOrFail($id);
        $employee->delete($id);
        Storage::disk('public')->delete('employee/'.$employee->profile_img);

        return "success";

    }

}
