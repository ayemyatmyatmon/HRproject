<?php

namespace App\Http\Controllers;
use App\User;
use Carbon\Carbon;
use App\CompanySetting;
use App\CheckinCheckOut;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\StoreAttendance;
use App\Http\Requests\UpdateAttendance;


class AttendanceController extends Controller
{
    public function index(){
        if(!auth()->user()->can('view_department')){
            abort(403, 'Unauthorized Action.');
        }

        return view('attendance.index');
    }

    public function ssd(Request $request){
        if(!auth()->user()->can('view_department')){
            abort(403, 'Unauthorized Action.');
        }
        $attendances=CheckinCheckOut::with('employee');
        return Datatables::of($attendances)
        ->filterColumn('employee_name',function($query,$keyword){
            $query->whereHas('employee',function($q1) use($keyword){
                $q1->where('name','like','%'.$keyword.'%');
            });
        })
        ->addColumn('plus_icon',function($each){
            return null;
        })
        ->addColumn('employee_name',function($each){
            $employee_names=$each->employee ? $each->employee->name :'-';
            return $employee_names;
        })
        ->editColumn('date',function($each){
            return $each->date;
        })
        ->editColumn('checkin_time',function($each){
            return $each->checkin_time;
        })
        ->editColumn('checkout_time',function($each){
            return $each->checkout_time;
        })
        ->addColumn('action',function($each){
            $edit_icon='';
            $delete_icon='';

            if(auth()->user()->can('edit_attendance')){
                $edit_icon='<a class="text-warning" href="'.route('attendance.edit',$each->id).'"><i class="fas fa-edit"></i></a>';
            }

            if(auth()->user()->can('delete_attendance')){
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
        if(!auth()->user()->can('create_attendance')){
            abort(403, 'Unauthorized Action.');
        }
        $employee_names=User::all();
        return view('attendance.create',compact('employee_names'));
    }

    public function store(StoreAttendance $request){


        if(!auth()->user()->can('create_attendance')){
            abort(403, 'Unauthorized Action.');
        }
        if(CheckinCheckOut::where('user_id',$request->user_id)->where('date',$request->date)->exists()){
            return back()->withErrors(['fail'=>'Already Exist'])->withInput();
        }

        $attendance=new CheckinCheckOut;
        $attendance->user_id=$request->user_id;
        $attendance->date=$request->date;
        $attendance->checkin_time=$request->date .' '. $request->checkin_time;
        $attendance->checkout_time=$request->date .' '. $request->checkout_time;
        $attendance->save();

        return redirect('attendance')->with(['create'=>'Successfully Created']);


    }
    public function edit($id){
        if(!auth()->user()->can('edit_attendance')){
            abort(403, 'Unauthorized Action.');
        }

        $employee_names=User::all();

        $attendance=CheckinCheckOut::findOrFail($id);
        return view('attendance.edit',compact('attendance','employee_names'));
    }

    public function update($id,UpdateAttendance $request){
        if(!auth()->user()->can('edit_department')){
            abort(403, 'Unauthorized Action.');
        }
        $attendance=CheckinCheckOut::findOrFail($id);

        if(CheckinCheckOut::where('user_id',$request->user_id)->where('date',$request->date)->where('id','!=',$attendance->id)->exists()){
            return back()->withErrors(['fail'=>'Already Exist'])->withInput();
        }

        $attendance->user_id=$request->user_id;
        $attendance->date=$request->date;
        $attendance->checkin_time=$request->date .' '. $request->checkin_time;
        $attendance->checkout_time=$request->date .' '. $request->checkout_time;
        $attendance->update();
        return redirect('attendance')->with(['update'=>'Successfully Updated']);
    }

    public function destroy($id){
        if(!auth()->user()->can('delete_attendance')){
            abort(403, 'Unauthorized Action.');
        }
        $attendance=CheckinCheckOut::findOrFail($id);
        $attendance->delete($id);
        return "success";

    }
    public function attendanceOverview(){
        if(!auth()->user()->can('view_attendance_overview')){
            abort(403, 'Unauthorized Action.');
        }

        return view('attendance.attendance_overview');
    }

    public function attendanceOverviewTable(Request $request){
        if(!auth()->user()->can('view_attendance_overview')){
            abort(403, 'Unauthorized Action.');
        }
        $month=$request->month;
        $year=$request->year;
        $startOfMonth=$year.'-'.$month.'-'.'01';
        $endOfMonth=Carbon::parse($startOfMonth)->endOfMonth()->format('Y-m-d');
        $periods = new CarbonPeriod($startOfMonth, $endOfMonth);
        $employees=User::orderBy('employee_id')->where('name','like','%'.$request->employee_name.'%')->get();
        $attendances=CheckinCheckOut::whereMonth('date',$month)->whereYear('date',$year)->get();
        $company_setting=CompanySetting::findOrFail(1);
        return view('component.attendance_overview_table',compact('periods','employees','attendances','company_setting'))->render();
    }

}
