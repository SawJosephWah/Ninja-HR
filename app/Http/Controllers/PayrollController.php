<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\Attendance;
use App\CompanySetting;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index(){
        return view('payroll.index');
    }

    public function payrollTable(Request $request){
        $month = $request->month;
        $year = $request->year;
        $start_of_month = $year.'-'.$month.'-01';
        $end_of_month = Carbon::parse($start_of_month)->endOfMonth()->format('Y-m-d') ;

        $periods = new CarbonPeriod($start_of_month, $end_of_month);
        $daysInMonth = Carbon::parse($start_of_month )->daysInMonth;
        //working days and off days
        $start = Carbon::now()->setDate($year, $month, 1);
        $end = Carbon::now()->setDate($year, $month, $daysInMonth);

        $workingDays = $start->diffInDaysFiltered(function (Carbon $date)  {
            return $date->isWeekday();
        }, $end);
        $offDays = $start->diffInDaysFiltered(function (Carbon $date)  {
            return $date->isWeekend();
        }, $end);

        $users = User::where ( 'name', 'LIKE', '%' . $request->userName . '%' )->orderBy('employee_id')->get();
        $attendances = Attendance::whereMonth('date',$month)->whereYear('date',$year)->get();

        $companySetting = CompanySetting::find(1);


        // return $month.' '.$year.' '.$start_of_month.' '.  $end_of_month.' '.$periods;
        // return $attendances;
        return view('payroll.payrollTable',compact('periods','users','attendances','companySetting','daysInMonth','workingDays','offDays','month','year'))->render();
    }

    public function myPayroll(Request $request){
        $month = $request->month;
        $year = $request->year;
        $start_of_month = $year.'-'.$month.'-01';
        $end_of_month = Carbon::parse($start_of_month)->endOfMonth()->format('Y-m-d') ;

        $periods = new CarbonPeriod($start_of_month, $end_of_month);
        $daysInMonth = Carbon::parse($start_of_month )->daysInMonth;
        //working days and off days
        $start = Carbon::now()->setDate($year, $month, 1);
        $end = Carbon::now()->setDate($year, $month, $daysInMonth);

        $workingDays = $start->diffInDaysFiltered(function (Carbon $date)  {
            return $date->isWeekday();
        }, $end);
        $offDays = $start->diffInDaysFiltered(function (Carbon $date)  {
            return $date->isWeekend();
        }, $end);

        $users = User::where('id',auth()->user()->id)->get();
        $attendances = Attendance::whereMonth('date',$month)->whereYear('date',$year)->get();

        $companySetting = CompanySetting::find(1);
        return view('payroll.payrollTable',compact('periods','users','attendances','companySetting','daysInMonth','workingDays','offDays','month','year'))->render();
    }
}
