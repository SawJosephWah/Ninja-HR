<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermission;
use App\Http\Requests\UpdatePermission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\Datatables\Datatables;

class PermissionController extends Controller
{

    public function index()
    {
        if(!auth()->user()->can('view_permission')){
            abort(403,'Unautorized action');
        }
        return view('permission.index');
    }

    public function allData(){
        $permission = Permission::query();
        return Datatables::of($permission)
        ->editColumn('created_at',function($each){
            return $each->created_at->format('Y-m-d');
        })
        ->editColumn('updated_at',function($each){
            return $each->created_at->format('Y-m-d');
        })
        ->addColumn('plus-sign', function () {
            return null;
        })
        ->addColumn('action', function ($permission) {
            $edit_btn='';
            $delete_btn='';

            if(auth()->user()->can('update_permission')){
                $edit_btn= '<a href="permission/'.$permission->id.'/edit" class="text-warning  datatable_action_btn"><i class="fas fa-edit "></i></a>';
            }
            if(auth()->user()->can('delete_permission')){
                $delete_btn= '<a href="#" class="text-danger delete_btn datatable_action_btn" data-id="'.$permission->id.'"><i class="fas fa-trash-alt "></i></a>';
            }



            return '<div class="d-flex justify-content-center">'.$edit_btn.$delete_btn.'</div>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function create()
    {
        if(!auth()->user()->can('create_permission')){
            abort(403,'Unautorized action');
        }
        return view('permission.create');
    }

    public function store(StorePermission $request)
    {
        if(!auth()->user()->can('create_permission')){
            abort(403,'Unautorized action');
        }
        $permission = new Permission();
        $permission->name = $request->name;
        $permission->save();

        return redirect()->route('permission.index')->with('success','Successfully Created Permission');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        if(!auth()->user()->can('update_permission')){
            abort(403,'Unautorized action');
        }
        $permission = Permission::findOrFail($id);
        return view('permission.edit',compact('permission'));
    }


    public function update(UpdatePermission $request, $id)
    {
        if(!auth()->user()->can('update_permission')){
            abort(403,'Unautorized action');
        }
        $permission = Permission::findOrFail($id);
        $permission->name = $request->name;
        $permission->update();

        return redirect()->route('permission.index')->with('success', 'Successfully Updated Permission!');;
    }


    public function destroy($id)
    {
        if(!auth()->user()->can('delete_permission')){
            abort(403,'Unautorized action');
        }
        Permission::findOrFail($id)->delete();
    }
}
