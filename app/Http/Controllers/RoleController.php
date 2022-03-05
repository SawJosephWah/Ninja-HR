<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRole;
use Yajra\Datatables\Datatables;
use App\Http\Requests\UpdateRole;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    public function index()
    {
        if(!auth()->user()->can('view_role')){
            abort(403,'Unautorized action');
        }
        return view('role.index');

    }

    public function allData(){
        $role = Role::query();
        return Datatables::of($role)
        ->addColumn('plus-sign', function () {
            return null;
        })
        ->editColumn('permissions', function($role) {
           $permissions =  $role->permissions->pluck('name');
           $data = '';
            foreach ($permissions as $p) {
                $data .= '<span class="badge badge-pill badge-primary m-1">'.$p.'</span>';
                }
            return $data;
        })
        ->addColumn('action', function ($role) {
            $edit_btn='';
            $delete_btn='';
            if(auth()->user()->can('delete_role')){
                $delete_btn= '<a href="#" class="text-danger delete_btn datatable_action_btn" data-id="'.$role->id.'"><i class="fas fa-trash-alt "></i></a>';
            }
            if(auth()->user()->can('update_role')){
                $edit_btn= '<a href="role/'.$role->id.'/edit" class="text-warning  datatable_action_btn"><i class="fas fa-edit "></i></a>';
            }


            return '<div class="d-flex justify-content-center">'.$edit_btn.$delete_btn.'</div>';
        })
        ->rawColumns(['action','permissions'])
        ->make(true);
    }


    public function create()
    {
        if(!auth()->user()->can('create_role')){
            abort(403,'Unautorized action');
        }
        $permissions = Permission::all();
        return view('role.create',compact('permissions'));
    }


    public function store(StoreRole $request)
    {
        if(!auth()->user()->can('create_role')){
            abort(403,'Unautorized action');
        }
        $role = new Role();
        $role->name = $request->name;
        $role->save();

        $role->givePermissionTo($request->permissions);

        return redirect()->route('role.index')->with('success','Successfully Created Role');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        if(!auth()->user()->can('update_role')){
            abort(403,'Unautorized action');
        }
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $old_permissions = $role->permissions->pluck('id')->toArray();
        return view('role.edit',compact('role','permissions','old_permissions'));
    }


    public function update(UpdateRole $request, $id)
    {
        if(!auth()->user()->can('update_role')){
            abort(403,'Unautorized action');
        }
        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->update();

        //revoke old permissions
        $old_permissions = $role->permissions->pluck('name')->toArray();
        $role->revokePermissionTo($old_permissions);

        //update new permission
        $role->givePermissionTo($request->permissions);

        return redirect()->route('role.index')->with('success','Successfully Updated Role');
    }

    public function destroy($id)
    {
        if(!auth()->user()->can('delete_role')){
            abort(403,'Unautorized action');
        }
        Role::findOrFail($id)->delete();
    }
}
