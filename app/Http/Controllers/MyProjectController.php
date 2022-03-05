<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class MyProjectController extends Controller
{
    public function index()
    {
        return view('myproject.index');
    }

    public function allData(){
        $projects = Project::with('leaders','members')->whereHas('leaders',function($query){
            $query->where('user_id',auth()->user()->id);
        })->orWhereHas('members',function($query){
            $query->where('user_id',auth()->user()->id);
        });
        return Datatables::of($projects)
        ->addColumn('plus-sign', function () {
            return null;
        })
        ->addColumn('project_leaders', function ($each) {
            $images = '';

            foreach(($each->leaders ?? []) as $leader){

                $images .="<img src='img/profiles/".$leader->image."' alt='' class='project_leaders_img_prototype'>";

            }
            return '<div style="width:140px;">'.$images.'</div>';
        })
        ->addColumn('project_members', function ($each) {
            $images = '';

            foreach(($each->members ?? []) as $member){

                $images .="<img src='img/profiles/".$member->image."' alt='' class='project_leaders_img_prototype'>";

            }
            return '<div style="width:140px;">'.$images.'</div>';
        })
        ->editColumn('description', function ($each) {
            return substr_replace($each->description,'',50);
        })
        ->editColumn('priority', function ($each) {
            $priority = '';
            if($each->priority == 'high'){
                $priority = '<span class="badge badge-pill badge-danger">HIGH</span>';
            }elseif($each->priority == 'middle'){
                $priority = '<span class="badge badge-pill badge-info">MIDDLE</span>';
            }else{
                $priority = '<span class="badge badge-pill badge-dark">LOW</span>';
            }
            return $priority;
        })
        ->editColumn('status', function ($each) {
            $status = '';
            if($each->status == 'pending'){
                $status = '<span class="badge badge-pill badge-danger">PENDING</span>';
            }elseif($each->status == 'in_progress'){
                $status = '<span class="badge badge-pill badge-info">IN_PROGRESS</span>';
            }else{
                $status = '<span class="badge badge-pill badge-dark">COMPLETED</span>';
            }
            return $status;
        })
        ->addColumn('action', function ($department) {

            $details_btn='';
            $details_btn= '<a href="my_project/'.$department->id.'" class="text-primary p-2 datatable_action_btn"><i class="fas fa-info "></i></a>';


            return '<div class="d-flex justify-content-center">'.$details_btn.'</div>';
        })
        ->rawColumns(['action','priority','status','project_leaders','project_members'])
        ->make(true);
    }

    public function details($id){
        $project = Project::with('leaders','members')->where('id',$id)
        ->where(function($query){
            $query->whereHas('leaders',function($q1){
                $q1->where('user_id',auth()->user()->id);
            })
            ->orWhereHas('members',function($q1){
                $q1->where('user_id',auth()->user()->id);
            });
        })
        ->firstOrFail();
        return view('myproject.details',compact('project'));
    }
}
