<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Requests\StoreDepartment;
use App\Http\Requests\UpdateDepartment;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!auth()->user()->can('view_department')){
            abort(403,'Unautorized action');
        }
        return view('department.index');

    }

    public function allData(){
        $employee = Department::query();
        return Datatables::of($employee)
        ->addColumn('plus-sign', function () {
            return null;
        })
        ->addColumn('action', function ($department) {
            $edit_btn='';
            $delete_btn='';

            if(auth()->user()->can('edit_department')){
                $edit_btn= '<a href="department/'.$department->id.'/edit" class="text-warning  datatable_action_btn"><i class="fas fa-edit "></i></a>';
            }
            if(auth()->user()->can('delete_department')){
                $delete_btn= '<a href="#" class="text-danger delete_btn datatable_action_btn" data-id="'.$department->id.'"><i class="fas fa-trash-alt "></i></a>';
            }


            return '<div class="d-flex justify-content-center">'.$edit_btn.$delete_btn.'</div>';
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
        if(!auth()->user()->can('create_department')){
            abort(403,'Unautorized action');
        }
        return view('department.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartment $request)
    {
        if(!auth()->user()->can('create_department')){
            abort(403,'Unautorized action');
        }
        $department = new Department();
        $department->title = $request->title;
        $department->save();

        return redirect()->route('department.index')->with('success','Successfully Created Department');
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        if(!auth()->user()->can('edit_department')){
            abort(403,'Unautorized action');
        }
        $department = Department::findOrFail($id);
        // dd($department->toArray());
        return view('department.edit',compact('department'));
    }


    public function update(UpdateDepartment $request, $id)
    {
        if(!auth()->user()->can('edit_department')){
            abort(403,'Unautorized action');
        }
        $department = Department::findOrFail($id);
        $department->title = $request->title;
        $department->update();

        return redirect()->route('department.index')->with('success','Successfully Updated Department');
    }


    public function destroy($id)
    {
        if(!auth()->user()->can('delete_department')){
            abort(403,'Unautorized action');
        }

        Department::findOrFail($id)->delete();

    }
}
