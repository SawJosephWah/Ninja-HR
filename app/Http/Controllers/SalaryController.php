<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalaryStore;
use App\Http\Requests\SalaryUpdate;
use App\User;
use App\Salary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Builder;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('salary.index');
    }

    public function allData(){
        $employee = Salary::with('user');
        return Datatables::of($employee)
        ->filterColumn('user_id',function($query,$keyword){
            $query->whereHas('user',function($ql) use ($keyword){
                $ql->where('name','like','%'.$keyword.'%');
            });
        })
        ->addColumn('plus-sign', function () {
            return null;
        })
        ->editColumn('user_id', function ($each) {
            return $each->user ? $each->user->name:'';
        })
        ->editColumn('month', function ($each) {
            return Carbon::parse($each->year.'-'.$each->month.'-01')->format('M');
        })
        ->addColumn('action', function ($salary) {
            $edit_btn='';


            if(auth()->user()->can('update_salary')){
                $edit_btn= '<a href="salary/'.$salary->id.'/edit" class="text-warning  datatable_action_btn"><i class="fas fa-edit "></i></a>';
            }


            return '<div class="d-flex justify-content-center">'.$edit_btn.'</div>';
        })
        ->rawColumns(['action'])
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
        return view('salary.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalaryStore $request)
    {
        // dd($request->all());
        $salary = new Salary();
        $salary->user_id = $request->user_id;
        $salary->month = $request->month;
        $salary->year = $request->year;
        $salary->amount = $request->amount;
        $salary->save();
        return redirect()->route('salary.index')->with('success','Salary Created Successfully');

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
        // dd($id);
        $salary = Salary::findOrFail($id);

        // dd($salary);
        $users = User::all();
        return view('salary.edit',compact('users','salary'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SalaryUpdate $request, $id)
    {
          // dd($request->all());
          $salary = Salary::find($id);
          $salary->user_id = $request->user_id;
          $salary->month = $request->month;
          $salary->year = $request->year;
          $salary->amount = $request->amount;
          $salary->update();
          return redirect()->route('salary.index')->with('success','Salary Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
