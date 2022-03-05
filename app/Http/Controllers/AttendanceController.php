<?php

namespace App\Http\Controllers;

use App\User;
use Attribute;
use Carbon\Carbon;
use App\Attendance;
use App\CompanySetting;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreAttendance;
use App\Http\Requests\UpdateAttendance;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!auth()->user()->hasPermissionTo('view_attendance')){
            abort(403, 'Unauthorized action.');
        }
        // $user->hasPermissionTo('edit articles');
        return view('attendance.index');
    }

    public function allData()
    {
        $attendance = Attendance::with('user');
        return Datatables::of($attendance)
        ->filterColumn('user_id',function($query,$keyword){
            $query->whereHas('user',function ($sql1) use ($keyword){
                $sql1->where('name','like','%'.$keyword.'%');
            });
        })
        ->editColumn('user_id',function($each){
            return $each->user->name;
        })
        ->addColumn( 'action', function($each){
            $editBtn = '';
            $deleteBtn = '';
            if(auth()->user()->hasPermissionTo('edit_attendance')){
                $editBtn = '<a href="attendance/'.$each->id.'/edit" class="text-warning  datatable_action_btn"><i class="fas fa-edit "></i></a>';;
            }
            if(auth()->user()->hasPermissionTo('delete_attendance')){
                $deleteBtn= '<a href="#" class="text-danger delete_btn datatable_action_btn" data-id="'.$each->id.'"><i class="fas fa-trash-alt "></i></a>';
            }
            return $editBtn . ' '.$deleteBtn;
        } )
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('attendance.create' , compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttendance $request)
    {
        // dd($request->user_id);
        if(!auth()->user()->can('create_attendance')){
            abort(403,'Unautorized action');
        }

        if(Attendance::where('user_id',$request->user_id)->where('date',$request->date)->exists()){
            return redirect()->back()->with(['error'=>'Record is already exist']);
        }

        $attendance = new Attendance();
        $attendance->user_id = $request->user_id;
        $attendance->date = $request->date;
        $attendance->check_in_time = $request->check_in_time !== '00:00:00' ? $request->date .' '.$request->check_in_time : null;
        $attendance->check_out_time = $request->check_out_time !== '00:00:00' ? $request->date .' '.$request->check_out_time : null;
        $attendance->save();

        return redirect()->route('attendance.index')->with('success','Attendance Created Successfully.');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);
        $users = User::all();
        // dd($attendance->toArray());
        return view('attendance.edit',compact('attendance','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttendance $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        // dd($request->all());
        if(!auth()->user()->can('edit_attendance')){
            abort(403,'Unautorized action');
        }

        if(Attendance::where('user_id',$request->user_id)->where('date',$request->date)->where('id','!=',$attendance->id)->exists()){
            return redirect()->back()->with(['error'=>'Record is already exist']);
        }

        // $attendance = Attendance::findOrFail($id);
        $attendance->user_id = $request->user_id;
        $attendance->date = $request->date;
        $attendance->check_in_time = $request->check_in_time !== '00:00:00' ? $request->date .' '.$request->check_in_time : null;
        $attendance->check_out_time = $request->check_out_time !== '00:00:00' ? $request->date .' '.$request->check_out_time : null;
        $attendance->update();

        return redirect()->route('attendance.index')->with('success','Attendance Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Attendance::findOrFail($id)->delete();
        return 'success';
    }


    public function attendanceOverview(){

        return view('attendance.attendanceOverview');
    }


    public function attendanceOverviewTable(Request $request){
        $month = $request->month;
        $year = $request->year;
        $start_of_month = $year.'-'.$month.'-01';
        $end_of_month = Carbon::parse($start_of_month)->endOfMonth()->format('Y-m-d') ;

        $periods = new CarbonPeriod($start_of_month, $end_of_month);
        $users = User::where ( 'name', 'LIKE', '%' . $request->userName . '%' )->orderBy('employee_id')->get();
        $attendances = Attendance::whereMonth('date',$month)->whereYear('date',$year)->get();

        $companySetting = CompanySetting::find(1);


        // return $month.' '.$year.' '.$start_of_month.' '.  $end_of_month.' '.$periods;
        // return $attendances;
        return view('components.attendance_overview_table',compact('periods','users','attendances','companySetting'))->render();
    }
}
