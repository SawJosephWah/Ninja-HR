<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\Attendance;
use App\CompanySetting;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class MyAttendanceController extends Controller
{
    public function AllData(Request $request){
        $attendance = Attendance::with('user')->where('user_id',auth()->user()->id);
        if($request->month){
            $attendance = $attendance->whereMonth('date',$request->month);
        }
        if($request->year){
            $attendance = $attendance->whereYear('date',$request->year);
        }
        return Datatables::of($attendance)
        ->filterColumn('user_id',function($query,$keyword){
            $query->whereHas('user',function ($sql1) use ($keyword){
                $sql1->where('name','like','%'.$keyword.'%');
            });
        })
        ->editColumn('user_id',function($each){
            return $each->user->name;
        })
        ->make(true);
    }

    public function MyAttendanceOverviewTable(Request $request){
        $month = $request->month;
        $year = $request->year;
        $start_of_month = $year.'-'.$month.'-01';
        $end_of_month = Carbon::parse($start_of_month.' 00:00:00')->endOfMonth()->format('Y-m-d') ;

        $periods = new CarbonPeriod($start_of_month, $end_of_month);
        $users = User::where('id',auth()->user()->id)->get();
        $attendances = Attendance::where('user_id',auth()->user()->id)->whereMonth('date',$month)->whereYear('date',$year)->get();
        $companySetting = CompanySetting::find(1);

        // return $month.' '.$year;
        // return $attendances;
        return view('components.attendance_overview_table',compact('periods','users','attendances','companySetting'))->render();
    }
}
