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


class MyPayrollController extends Controller
{

    public function ssd(){

        return view('payroll');
    }

    public function payRollTable(Request $request){

        $month=$request->month;
        $year=$request->year;
        $startOfMonth=$year.'-'.$month.'-'.'01';
        $endOfMonth=Carbon::parse($startOfMonth)->endOfMonth()->format('Y-m-d');
        $daysInMonth=Carbon::parse($startOfMonth)->daysInMonth;

        $workingDays = Carbon::parse($startOfMonth)->subDays(1)->diffInDaysFiltered(function (Carbon $date) {

            return $date->isWeekday() ;

        },Carbon::parse($endOfMonth));
        $offDays=$daysInMonth-$workingDays;
        $periods = new CarbonPeriod($startOfMonth, $endOfMonth);
        $employees=User::orderBy('employee_id')->where('id',auth()->user()->id)->get();
        $attendances=CheckinCheckOut::whereMonth('date',$month)->whereYear('date',$year)->get();
        $company_setting=CompanySetting::findOrFail(1);
        return view('component.payroll_table',compact('periods','employees','attendances','company_setting','daysInMonth','workingDays','offDays','month','year'))->render();
    }

}
