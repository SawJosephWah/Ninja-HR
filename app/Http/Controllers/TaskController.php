<?php

namespace App\Http\Controllers;

use App\Task;
use App\TaskMember;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task = new Task();
        $task->project_id = $request->project_id;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->start_date = $request->start_date;
        $task->deadline_date = $request->deadline_date;
        $task->priority = $request->priority;
        $task->status = $request->status;
        $task->save();

        $task->serial_number = $task->id;
        $task->update();

        $task->members()->sync($request->members);

        return 'success';
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $task->project_id = $request->project_id;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->start_date = $request->start_date;
        $task->deadline_date = $request->deadline_date;
        $task->priority = $request->priority;
        $task->status = $request->status;
        $task->update();

        $task->members()->sync($request->members);

        return 'success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id)->delete();
        TaskMember::where('task_id',$id)->delete();
        // $task->members()->detach();

        return 'success';
    }

    public function tasksDraggable(Request $request){
        if($request->pendingTasks){
            $tasksArray = explode("|", $request->pendingTasks);
            function custom_sort( $array )
            {
            sort($array);
            return $array;
            }
            $ascendingSortArray = custom_sort( $tasksArray );

            foreach ($tasksArray as $key => $value) {
                $task = Task::find($value);
                $task->status = 'pending';
                $task->serial_number = $ascendingSortArray[$key];
                $task->update();

            }
            // return $tasksArray;
        }

        if($request->inProgressTasks){
            $tasksArray = explode("|", $request->inProgressTasks);
            function custom_sort( $array )
            {
            sort($array);
            return $array;
            }
            $ascendingSortArray = custom_sort( $tasksArray );

            foreach ($tasksArray as $key => $value) {
                $task = Task::find($value);
                $task->status = 'in_progress';
                $task->serial_number = $ascendingSortArray[$key];
                $task->update();

            }
            // return $tasksArray;
        }


        if($request->completedTasks){
            $tasksArray = explode("|", $request->completedTasks);
            function custom_sort( $array )
            {
            sort($array);
            return $array;
            }
            $ascendingSortArray = custom_sort( $tasksArray );

            foreach ($tasksArray as $key => $value) {
                $task = Task::find($value);
                $task->status = 'completed';
                $task->serial_number = $ascendingSortArray[$key];
                $task->update();
                // return $tasksArray[$key];
            }
            // return $tasksArray;
        }



        return 'success';
    }
}
