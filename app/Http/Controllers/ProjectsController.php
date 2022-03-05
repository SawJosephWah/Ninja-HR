<?php

namespace App\Http\Controllers;

use App\User;
use App\Project;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\StoreProject;
use App\Http\Requests\UpdateProject;
use App\ProjectLeader;
use App\ProjectMember;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('project.index');
    }


    public function allData(){
        $projects = Project::query();
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
            $edit_btn='';
            $delete_btn='';
            $details_btn='';

            // if(auth()->user()->can('edit_department')){
                $edit_btn= '<a href="projects/'.$department->id.'/edit" class="text-warning  datatable_action_btn"><i class="fas fa-edit "></i></a>';
            // }
            // if(auth()->user()->can('delete_department')){
                $delete_btn= '<a href="#" class="text-danger delete_btn datatable_action_btn" data-id="'.$department->id.'"><i class="fas fa-trash-alt "></i></a>';
            // }
            $details_btn= '<a href="projects/'.$department->id.'" class="text-primary p-2 datatable_action_btn"><i class="fas fa-info "></i></a>';


            return '<div class="d-flex justify-content-center">'.$details_btn.$edit_btn.$delete_btn.'</div>';
        })
        ->rawColumns(['action','priority','status','project_leaders','project_members'])
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
        return view('project.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProject $request)
    {

        // dd($request->all());
        $img_name = '';
        $file_name = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $img_name = Str::uuid().$image->getClientOriginalName();
            $destinationPath = public_path('/img/projects_imgs/');
            $image->move($destinationPath, $img_name);

        }

        if ($request->hasFile('files')) {
            $file = $request->file('files');
            $file_name = Str::uuid().$file->getClientOriginalName();
            $destinationPath = public_path('/img/projects_files/');
            $file->move($destinationPath, $file_name);

        }

        $project = new Project();
        $project->title = $request->title;
        $project->description = $request->description;
        $project->images = $img_name;
        $project->files = $file_name;
        $project->start_date = $request->start_date;
        $project->deadline = $request->deadline;
        $project->priority = $request->priority;
        $project->status = $request->status;

        $project->save();

        foreach (($request->leaders ?? []) as $leader_id) {
            $leader = new ProjectLeader();
            $leader->project_id = $project->id;
            $leader->user_id = $leader_id;
            $leader->save();
        }

        foreach (($request->members ?? []) as $member_id) {
            $member = new ProjectMember();
            $member->project_id = $project->id;
            $member->user_id = $member_id;
            $member->save();
        }

        return redirect()->route('projects.index')->with('success','Successfully Created Project');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::find($id);
         return view('project.details',compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::find($id);
        $users = User::all();
        $project_leaders = [];
        $project_members =[];
        // dd($project_members->toArray());

        foreach (ProjectLeader::where('project_id',$id)->get('user_id') as $leader) {
            array_push($project_leaders,$leader->user_id);
        }
        foreach (ProjectMember::where('project_id',$id)->get('user_id') as $member) {
            array_push($project_members,$member->user_id);
        }
        return view('project.edit',compact('users','project','project_leaders','project_members'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProject $request, $id)
    {

        $project = Project::find($id);
        $img_name = $project->images;
        $file_name = $project->files;
        if ($request->hasFile('image')) {
            //delete old image if olf image exists
            if($img_name){
                $path = public_path()."/img/projects_imgs/".$img_name;
                unlink($path);
            }

        //     //store new image
            $image = $request->file('image');
            $img_name = Str::uuid().$image->getClientOriginalName();
            $destinationPath = public_path('/img/projects_imgs/');
            $image->move($destinationPath, $img_name);

        }

        if ($request->hasFile('files')) {
            //delete old image if olf image exists
            if($file_name){
                $path = public_path()."/img/projects_files/".$file_name;
                unlink($path);
            }

            //store new file
            $file = $request->file('files');
            $file_name = Str::uuid().$file->getClientOriginalName();
            $destinationPath = public_path('/img/projects_files/');
            $file->move($destinationPath, $file_name);

        }


        $project->title = $request->title;
        $project->description = $request->description;
        $project->images = $img_name;
        $project->files = $file_name;
        $project->start_date = $request->start_date;
        $project->deadline = $request->deadline;
        $project->priority = $request->priority;
        $project->status = $request->status;
        $project->update();

        //delete the old leaders
        ProjectLeader::where('project_id',$id)->delete();



        // store new leaders
        foreach (($request->leaders ?? []) as $leader_id) {
            $leader = new ProjectLeader();
            $leader->project_id = $project->id;
            $leader->user_id = $leader_id;
            $leader->save();
        }

        //delete old members
        ProjectMember::where('project_id',$id)->delete();
        //store new members
        foreach (($request->members ?? []) as $member_id) {
            $member = new ProjectMember();
            $member->project_id = $project->id;
            $member->user_id = $member_id;
            $member->save();
        }

        return redirect()->route('projects.index')->with('success','Successfully Updated Project');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ProjectLeader::where('project_id',$id)->delete();
        ProjectMember::where('project_id',$id)->delete();
        Project::find($id)->delete();
        return true;
    }
}
