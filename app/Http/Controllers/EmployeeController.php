<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreEmployee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateEmployee;

class EmployeeController extends Controller
{

    public function index()
    {
        if(!auth()->user()->can('view_employee')){
            abort(403, 'Unauthorized action.');
        }
        return view('employee.index');
    }

    public function allData(){
        $employee = User::with('department');
        return Datatables::of($employee)
        ->filterColumn('department_name',function($query,$keyword){
            $query->whereHas('department',function($ql) use ($keyword){
                $ql->where('title','like','%'.$keyword.'%');
            });
        })
        ->editColumn('image', function($employee) {
            $image = "<img src='".asset('/img/profiles/'.$employee->image)."' alt='' class='profile-img-datatable'><p class='mt-3'>".$employee->name."</p>";
            return  $image;
        })
        ->addColumn('department_name', function ($employee) {
            return $employee->department->title ? $employee->department->title : 'no Department';
        })
        ->addColumn('is_present', function ($employee) {
            if($employee->is_present == 1){
                return '<span class="badge badge-pill badge-theme">Present</span>';
            }else{
                return '<span class="badge badge-pill badge-danger">Not Present</span>';
            }
        })
        ->addColumn('roles', function ($employee) {
            $roles = $employee->getRoleNames();
            $data = '';
            foreach($roles as $role){
                $data.='<span class="badge badge-pill badge-primary m-1">'.$role.'</span>';
            }
            return $data;
        })
        ->editColumn('updated_at', function($employee) {
            return Carbon::parse($employee->updated_at)->format('Y/m/d H:i:s');
        })
        ->addColumn('plus-sign', function () {
            return null;
        })
        ->addColumn('action', function ($employee) {
            $edit_btn='';
            $info_btn='';
            $delete_btn='';

            if(auth()->user()->can('update_employee')){
                $edit_btn= '<a href="employee/'.$employee->id.'/edit" class="text-warning datatable_action_btn"><i class="fas fa-edit "></i></a>';
            }
            if(auth()->user()->can('delete_employee')){
                $delete_btn= '<a href="#" class="text-danger delete_btn datatable_action_btn" data-id="'.$employee->id.'"><i class="fas fa-trash-alt "></i></a>';
            }
            if(auth()->user()->can('view_employee')){
                $info_btn= '<a href="employee/'.$employee->id.'" class="text-primary datatable_action_btn"><i class="fas fa-info-circle "></i></a>';
            }

            return '<div class="d-flex">'.$edit_btn.$info_btn.$delete_btn.'</div>';
        })
        ->rawColumns(['is_present','action','image','roles'])
        ->make(true);
    }


    public function create()
    {
        if(!auth()->user()->can('create_employee')){
            abort(403, 'Unauthorized action.');
        }
         $departments = Department::all();
         $roles = Role::all();
        return view('employee.create',compact('departments','roles'));
    }


    public function store(StoreEmployee $request)
    {
        if(!auth()->user()->can('create_employee')){
            abort(403, 'Unauthorized action.');
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = Str::uuid().$image->getClientOriginalName();
            $destinationPath = public_path('/img/profiles/');
            $image->move($destinationPath, $name);

            $employee = new User();
            $employee->employee_id = $request->employee_id;
            $employee->name = $request->name;
            $employee->phone = $request->phone;
            $employee->email = $request->email;
            $employee->pin_code = $request->pin_code;
            $employee->password = Hash::make($request->password);
            $employee->nrc_number = $request->nrc_number;
            $employee->birthday = $request->birthday;
            $employee->image = $name;
            $employee->gender = $request->gender;
            $employee->address = $request->address;
            $employee->department_id = $request->department_id;
            $employee->join_of_date = $request->date_of_join;
            $employee->is_present = $request->is_present;
            $employee->syncRoles($request->roles);
            $employee->save();
        }




        return redirect()->route('employee.index')->with('success','Successfully Created Employee');
    }


    public function show($id)
    {

        if(!auth()->user()->can('view_employee')){
            abort(403, 'Unauthorized action.');
        }
        $employee = User::findOrFail($id);
        return view('employee.show',compact('employee'));
    }


    public function edit($id)
    {
        if(!auth()->user()->can('update_employee')){
            abort(403, 'Unauthorized action.');
        }
        $roles = Role::all();
        $employee = User::findOrFail($id);
        $old_roles = $employee->getRoleNames()->toArray();
        $departments = Department::all();
        return view('employee.edit',compact('employee','departments','roles','old_roles'));
    }


    public function update (UpdateEmployee $request, $id)
    {
        if(!auth()->user()->can('update_employee')){
            abort(403, 'Unauthorized action.');
        }
        $employee = User::findOrFail($id);

        $img_name = null;
        if ($request->hasFile('image')) {
            //old photo delete
            if($employee->image){
                $path = public_path()."/img/profiles/".$employee->image;
                unlink($path);
            }

            //new photo
            $image = $request->file('image');
            $img_name = Str::uuid().$image->getClientOriginalName();
            $destinationPath = public_path('/img/profiles/');
            $image->move($destinationPath, $img_name);
        }


        // $image = $request->file('image');
        // dd($image);

        $employee->employee_id = $request->employee_id;
        $employee->name = $request->name;
        $employee->phone = $request->phone;
        $employee->email = $request->email;
        $employee->pin_code = $request->pin_code;
        $employee->password =$request->password ? Hash::make($request->password):$employee->password ;
        $employee->nrc_number = $request->nrc_number;
        $employee->birthday = $request->birthday;
        $employee->image = $img_name ? $img_name : $employee->image;
        $employee->gender = $request->gender;
        $employee->address = $request->address;
        $employee->department_id = $request->department_id;
        $employee->join_of_date = $request->date_of_join;
        $employee->is_present = $request->is_present;
        $employee->syncRoles($request->roles);
        $employee->update();


        return redirect()->route('employee.index')->with('success','Successfully Updated Employee');

    }


    public function destroy($id)
    {
        if(!auth()->user()->can('delete_employee')){
            abort(403, 'Unauthorized action.');
        }
        User::findOrFail($id)->delete();
    }
}
