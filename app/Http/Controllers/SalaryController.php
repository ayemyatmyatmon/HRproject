<?php

namespace App\Http\Controllers;
use App\User;
use App\Salary;
use Carbon\Carbon;
use App\Department;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\StoreSalary;
use App\Http\Requests\UpdateSalary;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartment;
use App\Http\Requests\UpdateDepartment;


class SalaryController extends Controller
{
    public function index(){
        if(!auth()->user()->can('view_salary')){
            abort(403, 'Unauthorized Action.');
        }

        return view('salary.index');
    }

    public function ssd(Request $request){
        if(!auth()->user()->can('view_salary')){
            abort(403, 'Unauthorized Action.');
        }
        $salaries=Salary::with('employee');
        return Datatables::of($salaries)
        ->filterColumn('employee_name',function($query,$keyword){
            $query->whereHas('employee',function($q1) use($keyword){
                $q1->where('name','like','%'.$keyword.'%');
            });
        })
        ->AddColumn('employee_name',function($each){
            return $each->employee ? $each->employee->name :'-';
        })
        ->addColumn('plus_icon',function($each){
            return null;
        })
        ->editColumn('title',function($each){
            return '<p>'.$each->title.'</p>';
        })
        ->editColumn('amount',function($each){
            $amount=number_format($each->amount);
            return $amount;
        })
        ->addColumn('action',function($each){
            $edit_icon='';
            $delete_icon='';

            if(auth()->user()->can('edit_salary')){
                $edit_icon='<a class="text-warning" href="'.route('salary.edit',$each->id).'"><i class="fas fa-edit"></i></a>';
            }

            if(auth()->user()->can('delete_salary')){
                $delete_icon='<a class="delete text-danger" href="#" data-id="'.$each->id.'"><i class="fas fa-trash"></i></a>';
            }

            return '<div class="icons" >'.$edit_icon.$delete_icon.'</div>';
        })
        ->editColumn('month',function($each){
            $month=Carbon::parse('2021-'.$each->month.'-01')->format('M');
            return $month;
        })
        ->editColumn('updated_at',function($each){
            return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s A');
        })

        ->rawColumns(['action','title'])
        ->make(true);
    }

    public function create(){
        if(!auth()->user()->can('create_salary')){
            abort(403, 'Unauthorized Action.');
        }
        $employees=User::orderBy('employee_id')->get();

        return view('salary.create',compact('employees'));
    }

    public function store(StoreSalary $request){
        if(!auth()->user()->can('create_salary')){
            abort(403, 'Unauthorized Action.');
    }
        $salary=new Salary;
        $salary->user_id=$request->user_id;
        $salary->month=$request->month;
        $salary->year=$request->year;
        $salary->amount=$request->amount;
        $salary->save();

        return redirect('salary')->with(['create'=>'Successfully Created']);


    }
    public function edit($id){
        if(!auth()->user()->can('edit_salary')){
            abort(403, 'Unauthorized Action.');
        }
        $employees=User::orderBy('employee_id')->get();
        $salary=Salary::findOrFail($id);
        return view('salary.edit',compact('salary','employees'));
    }

    public function update($id,UpdateSalary $request){
        if(!auth()->user()->can('edit_salary')){
            abort(403, 'Unauthorized Action.');
        }
        $salary=Salary::findOrFail($id);

        $salary->user_id=$request->user_id;
        $salary->month=$request->month;
        $salary->year=$request->year;
        $salary->amount=$request->amount;
        $salary->update();
        return redirect('salary')->with(['update'=>'Successfully Updated']);
    }

    public function destroy($id){
        if(!auth()->user()->can('delete_salary')){
            abort(403, 'Unauthorized Action.');
        }
        $salary=Salary::findOrFail($id);
        $salary->delete($id);
        return "success";

    }

}
