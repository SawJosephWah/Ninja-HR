<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AttendanceScanController extends Controller
{
    public function index(){
        return view('attendanceScan.index');
    }

    public function scanAttendance(Request $request){
        // return [
        //     "status" => $request->hash_value,
        //     "message" => date('Y-m-d'),
        //     ];
        if(!Hash::check(date('Y-m-d'),  $request->hash_value)){
            return [
                "status" => 'fail',
                "message" => 'Invalid QR',
                ];
        }

        $attendance = Attendance::firstOrCreate([
            'user_id' => auth()->user()->id,
            'date' => now()->format('Y-m-d')
        ]);

        $message = '';
        $status = '';

        if(is_null($attendance->check_in_time) ){
            $attendance->check_in_time = now();
            $status = 'success';
            $message = 'Check In Successfully';
        }elseif(is_null($attendance->check_out_time)){
            $attendance->check_out_time = now();
            $status = 'success';
            $message = 'Check Out Successfully';
        }else{
            $status = 'fail';
            $message = 'Already Attended On This Day';
        }

        $attendance->update();

        return [
            'status' => $status,
            'message' => $message
        ];
    }
}
