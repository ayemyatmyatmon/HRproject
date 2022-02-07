<?php

namespace App\Http\Controllers;

use App\User;
use App\CheckinCheckOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CheckInCheckOutController extends Controller
{
    public function CheckInCheckOut(){
        $hash_data=Hash::make(date('Y-m-d'));
        return view('CheckInCheckOut.index',compact('hash_data'));
    }
    public function CheckInCheckOutStore(Request $request){

        if(now()->format('D')=='Sat' || now()->format('D')=='Sun'){
            return response()->json([
                'message'=>'fail',
                'data'=>'Today is Off day.'
            ]);
        }
        $user=User::where('pin_code',$request->pin_code)->first();

        if(!$user){
            return response()->json([
                'message'=>'fail',
                'data'=>'PinCode is wrong. '
            ]);
        }

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
