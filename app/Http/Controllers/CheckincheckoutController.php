<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\CompanySetting;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CheckincheckoutController extends Controller
{
    public function index(){


        $hash_value = Hash::make(date("Y-m-d")) ;

        return view('checkInCheckOut.index',compact('hash_value'));
    }

    public function checkIn(Request $request){



        $user = User::where('pin_code',$request->pincode)->first();

        if($user){

            $attendance = Attendance::firstOrCreate([
                'user_id' => $user->id,
                'date' => now()->format('Y-m-d')
            ]);

            $message = '';
            $status = '';

            if(is_null($attendance->check_in_time) ){
                $attendance->check_in_time = now();
                $status = 'Success';
                $message = 'Check In Successfully';
            }elseif(is_null($attendance->check_out_time)){
                $attendance->check_out_time = now();
                $status = 'Success';
                $message = 'Check Out Successfully';
            }else{
                $status = 'Fail';
                $message = 'Already Attended On This Day';
            }

            $attendance->update();

            // $checkIn = new Attendance();
            // return $checkIn;
            // $checkIn->user_id = $user->id;
            // $checkIn->check_in_time = now();
            // $checkIn->save();

            return [
                'status' => $status,
                'message' => $message
            ];
        }


        return [
            'status' => 'Fail',
            'message' => 'Wrong Pincode'
        ];
    }
}
