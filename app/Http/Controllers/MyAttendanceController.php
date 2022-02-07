<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\CheckinCheckOut;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;

class MyAttendanceController extends Controller
{
    public function ssd(Request $request){
        if(!auth()->user()->can('view_department')){
            abort(403, 'Unauthorized Action.');
        }
        $attendances=CheckinCheckOut::with('employee')->where('user_id',auth()->user()->id);
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

        ->editColumn('updated_at',function($each){
            return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s A');
        })

        ->rawColumns([])
        ->make(true);
    }
}
