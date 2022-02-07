<?php

namespace App\Http\Controllers;

use App\CheckinCheckOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AttendanceScanController extends Controller
{
    public function scan(){
        return view('attendance.scan');
    }
    public function scanStore(Request $request){
        if(now()->format('D')=='Sat' || now()->format('D')=='Sun'){
            return response()->json([
                'message'=>'fail',
                'data'=>'Today is Off day.'
            ]);
        }
        
        if(!Hash::check(date('Y-m-d'),$request->hash_value)){
            return response()->json([
                'message'=>'fail',
                'data'=>'PinCode is wrong. '
            ]);
        }
        $user=auth()->user();

        $checkin_checkout_data=CheckinCheckOut::firstOrCreate(
            [
                "user_id"=>$user->id,
                "date"=>now()->format('Y-m-d'),
            ]
        );

        if(!is_null($checkin_checkout_data->checkin_time) && !is_null($checkin_checkout_data->checkout_time)){
            return response()->json([
                'message'=>'fail',
                'data'=>'Already exist checkin and checkout today.'
            ]);
        }
        if(is_null($checkin_checkout_data->checkin_time)){
            $checkin_checkout_data->checkin_time=now();
            $data='Successfully CheckIn at'. now();
        }else{
            if(is_null($checkin_checkout_data->checkout_time)){
                $checkin_checkout_data->checkout_time=now();
                $data='Successfully CheckOut'. now();
            }
        }
        $checkin_checkout_data->update();

        return [
            'message'=>'success',
            'data'=>$data,
        ];
    }
}
