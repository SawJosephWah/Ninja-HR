@extends('layouts.app')
@section('title','PROJECT DETAILS')
@section('custom_css')
    <style>
        .img_thumbnail{
            width: 120px;
            height: 80px;
            border-radius: 10px;
            margin-top: 5px;
            border: 1px solid #bebebe
        }
        .pdf_thumbnail{
            padding: 10px;
            border: 1px solid #bebebe;
            border-radius: 5px;
            font-size: 80px;
        }
        .pdf{
            font-size: 80px;
            margin: 5px;
        }
        .task_item{
            background-color: #e6e6e6;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #c5c5c5;
        }
        .add_task_btn{
            background-color: #e9e9e9 !important;
            border: 1px solid #c5c5c5;
            border-radius: 5px;
            color: #464646 !important;
        }
        .select2{
            display: block !important;
        }
        .task_edit_btn{
            background-color: rgb(248, 248, 248);
            padding: 5px;
            border-radius: 5px;
        }
        .sortable-ghost{
            background: #eee !important;
            border: 3px dashed #000;
        }
    </style>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="card mb-3">
                <div class="card-body">
                    <h4>{{$project->title}}</h4>
                    <p class="text-muted">
                        Start Date : {{$project->start_date}} ,
                        Deadline Date : {{$project->deadline}}
                    </p>
                    <p class="text-muted">
                        Priority :
                        @if($project->priority == 'high')
                        <span class="badge badge-pill badge-danger">HIGH</span>
                        @elseif($project->priority == 'middle')
                        <span class="badge badge-pill badge-info">MIDDLE</span>
                        @else
                        <span class="badge badge-pill badge-dark">LOW</span>
                        @endif
                        ,
                        Status :
                        @if($project->status == 'pending')
                        <span class="badge badge-pill badge-danger">PENDING</span>
                        @elseif($project->status == 'in_progress')
                        <span class="badge badge-pill badge-info">IN PROGRESS</span>
                        @else
                        <span class="badge badge-pill badge-dark">COMPLETED</span>
                        @endif
                    </p>
                    <p>
                        <h5>Description</h5>
                        <div class="text-justify"> {{$project->description}}</div>
                    </p>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Leaders</h5>
                            @foreach ($project->leaders as $leader)
                                <div class="text-muted">* {{$leader->name}}</div>
                            @endforeach
                        </div>
                        <div class="col-md-6">
                            <h5>Members</h5>
                            @foreach ($project->members as $member)
                                <div class="text-muted">* {{$member->name}}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Image</h5>
                    @if ($project->images)

                    <img  id="project_image" src="/img/projects_imgs/{{$project->images}}" class="img_thumbnail" alt="">

                    @endif
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h5>File</h5>
                    @if ($project->files)
                        <a href="/img/projects_files/{{$project->files}}" class="pdf_thumbnail" target="_blink">
                            <i class="fas fa-file-pdf"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <h5 class="mt-3">Tasks</h5>
    <div class="row">
        {{-- pending --}}
        <div class="col-md-4 mt-3">
            <div class="card">
                <div class="card-header bg-warning text-white"><i class="fas fa-tasks mr-3"></i>Pending</div>
                <div class="card-body alert-warning">
                    <div id="pendingTasks">
                        @foreach (collect($project->tasks)->where('status','pending')->sortBy(function ($task) {
                            return $task->serial_number;
                        }) as $task)
                        <div class="task_item" data-id="{{$task->id}}">
                            <div class="d-flex justify-content-between mb-2">
                                <h6>{{$task->title}}</h6>
                                <div>
                                    <a href="#" data-toggle="modal" data-target="#editPendingTaskModal_{{$task->id}}" class="task_edit_btn text-warning mr-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" data-toggle="modal" data-target="#deletePendingTask_{{$task->id}}" class="task_edit_btn text-danger" >
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>

                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="fas fa-clock"></i>
                                    {{ Carbon\Carbon::parse($task->start_date)->format('M d') }}

                                    <br>
                                    <br>

                                    @if($task->priority == 'high')
                                    <span class="badge badge-pill badge-danger">HIGH</span>
                                    @elseif($task->priority == 'middle')
                                    <span class="badge badge-pill badge-info">MIDDLE</span>
                                    @else
                                    <span class="badge badge-pill badge-success">LOW</span>
                                    @endif
                                </div>
                                <div>
                                    @foreach ($task->members as $member)
                                        <p class="mb-0">* {{$member->name}}</p>
                                    @endforeach
                                </div>

                            </div>
                            <!-- edit Pending Task Modal -->
                <div class="modal fade" id="editPendingTaskModal_{{$task->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Pending Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                        <form id="updateTaskForm_{{$task->id}}">
                            @csrf
                            @method('put')
                            {{-- project id and status --}}
                            <input type="hidden" name="project_id" value="{{$project->id}}">
                            <input type="hidden" name="status" value="pending">
                                {{-- title --}}
                            <div class="md-form">
                                <input id="title" type="text" class="form-control" name="title" value="{{$task->title}}">
                                <label for="title">Title</label>
                            </div>
                            {{-- description --}}
                            <div class="md-form">
                            <textarea id="form7" class="md-textarea form-control" name="description" rows="3">{{$task->description}}</textarea>
                            <label for="form7">Description</label>
                            </div>
                            {{-- start Date --}}
                            <div class="md-form">
                                    <input  type="text" class="datepicker form-control" name="start_date"
                                autocomplete="off"
                                value="{{$task->start_date}}">
                                    <label for="materialLoginFormEmail">Start Date</label>
                            </div>
                            {{-- deadline Date --}}
                            <div class="md-form">
                                    <input  type="text" class="datepicker form-control" name="deadline_date"
                                autocomplete="off"
                                value="{{$task->deadline_date}}">
                                    <label for="materialLoginFormEmail">Deadline Date</label>
                            </div>

                            {{-- members --}}

                                <label for="" class="mt-3">Members</label>

                                <select name="members[]" class="mt-4 d-block form-control select2" multiple >
                                    @php
                                        $member_ids = [];
                                        foreach ($task->members as $member) {
                                            array_push($member_ids,$member->id);
                                        }
                                    @endphp
                                    @foreach ($project->members as $member)
                                        <option value="{{$member->id}}" @if(in_array($member->id,$member_ids)) selected @endif>{{$member->name}}</option>
                                    @endforeach
                                </select>


                            {{-- priority --}}
                            <label for="" class="mt-3">Priority</label>
                            <select name="priority" class="my-3 form-control select2 @error('priority') is-invalid @enderror" aria-label="Default select example">
                                    <option value="" selected>-- Select Priority --</option>
                                    <option value="low" @if($task->priority == 'low') selected @endif>Low</option>
                                    <option value="middle" @if($task->priority == 'middle') selected @endif>Middle</option>
                                    <option value="high" @if($task->priority == 'high') selected @endif>High</option>
                            </select>
                        </form>
                        </div>
                        <div class="modal-footer">
                        <button type="button" id="update_task_btn" value="{{$task->id}}" class="btn btn-primary">UPDATE</button>
                        </div>
                    </div>
                    </div>
                </div>
                <!-- delete Pending task Modal -->
                <div class="modal fade" id="deletePendingTask_{{$task->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                           <h5> Delete Task ?</h5>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="deleteTaskBtn" value="{{$task->id}}">Delete</button>
                        </div>
                    </div>
                    </div>
                </div>

                        </div>
                        @endforeach
                    </div>

                    <div class="text-center">
                        <a href="" data-toggle="modal" data-target="#addPendingTaskModal"  class="d-block text-center bg-white add_task_btn
                        p-2"><i class="fas fa-plus-circle mr-3"></i>Add Task</a>
                    </div>
                </div>
            </div>
        </div>
        {{-- in progress --}}
        <div class="col-md-4 mt-3">
            <div class="card">
                <div class="card-header bg-info text-white"><i class="fas fa-tasks mr-3"></i>In Progress</div>
                <div class="card-body alert-info">
                    <div id="inProgressTasks">
                        @foreach (collect($project->tasks)->where('status','in_progress')->sortBy(function ($task) {
                            return $task->serial_number;
                        }) as $task)
                        <div class="task_item" data-id="{{$task->id}}">
                            <div class="d-flex justify-content-between mb-2">
                                <h6>{{$task->title}}</h6>
                                <div>
                                    <a href="#" data-toggle="modal" data-target="#editInProgressTaskModal_{{$task->id}}" class="task_edit_btn text-warning mr-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" data-toggle="modal" data-target="#deleteInProgressTask_{{$task->id}}" class="task_edit_btn text-danger">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="fas fa-clock"></i>
                                    {{ Carbon\Carbon::parse($task->start_date)->format('M d') }}

                                    <br>
                                    <br>

                                    @if($task->priority == 'high')
                                    <span class="badge badge-pill badge-danger">HIGH</span>
                                    @elseif($task->priority == 'middle')
                                    <span class="badge badge-pill badge-info">MIDDLE</span>
                                    @else
                                    <span class="badge badge-pill badge-success">LOW</span>
                                    @endif
                                </div>
                                <div>
                                    @foreach ($task->members as $member)
                                        <p class="mb-0">* {{$member->name}}</p>
                                    @endforeach
                                </div>

                            </div>
                              <!-- edit In Progress Task Modal -->
                <div class="modal fade" id="editInProgressTaskModal_{{$task->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Pending Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                        <form id="updateTaskForm_{{$task->id}}">
                            @csrf
                            @method('put')
                            {{-- project id and status --}}
                            <input type="hidden" name="project_id" value="{{$project->id}}">
                            <input type="hidden" name="status" value="in_progress">
                                {{-- title --}}
                            <div class="md-form">
                                <input id="title" type="text" class="form-control" name="title" value="{{$task->title}}">
                                <label for="title">Title</label>
                            </div>
                            {{-- description --}}
                            <div class="md-form">
                            <textarea id="form7" class="md-textarea form-control" name="description" rows="3">{{$task->description}}</textarea>
                            <label for="form7">Description</label>
                            </div>
                            {{-- start Date --}}
                            <div class="md-form">
                                    <input  type="text" class="datepicker form-control" name="start_date"
                                autocomplete="off"
                                value="{{$task->start_date}}">
                                    <label for="materialLoginFormEmail">Start Date</label>
                            </div>
                            {{-- deadline Date --}}
                            <div class="md-form">
                                    <input  type="text" class="datepicker form-control" name="deadline_date"
                                autocomplete="off"
                                value="{{$task->deadline_date}}">
                                    <label for="materialLoginFormEmail">Deadline Date</label>
                            </div>

                            {{-- members --}}

                                <label for="" class="mt-3">Members</label>

                                <select name="members[]" class="mt-4 d-block form-control select2" multiple >
                                    @php
                                        $member_ids = [];
                                        foreach ($task->members as $member) {
                                            array_push($member_ids,$member->id);
                                        }
                                    @endphp
                                    @foreach ($project->members as $member)
                                        <option value="{{$member->id}}" @if(in_array($member->id,$member_ids)) selected @endif>{{$member->name}}</option>
                                    @endforeach
                                </select>


                            {{-- priority --}}
                            <label for="" class="mt-3">Priority</label>
                            <select name="priority" class="my-3 form-control select2 @error('priority') is-invalid @enderror" aria-label="Default select example">
                                    <option value="" selected>-- Select Priority --</option>
                                    <option value="low" @if($task->priority == 'low') selected @endif>Low</option>
                                    <option value="middle" @if($task->priority == 'middle') selected @endif>Middle</option>
                                    <option value="high" @if($task->priority == 'high') selected @endif>High</option>
                            </select>
                        </form>
                        </div>
                        <div class="modal-footer">
                        <button type="button" id="update_task_btn" value="{{$task->id}}" class="btn btn-primary">UPDATE</button>
                        </div>
                    </div>
                    </div>
                </div>
                <!-- delete In Progress task Modal -->
                <div class="modal fade" id="deleteInProgressTask_{{$task->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                           <h5> Delete Task ?</h5>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="deleteTaskBtn" value="{{$task->id}}">Delete</button>
                        </div>
                    </div>
                    </div>
                </div>
                        </div>

                        @endforeach
                    </div>


                    <div class="text-center">
                        <a href="" class="d-block text-center bg-white add_task_btn
                        p-2" data-toggle="modal" data-target="#addInProgressTaskModal" data-id="my_id_value"><i class="fas fa-plus-circle mr-3" ></i>Add Task</a>
                    </div>
                </div>
            </div>
        </div>
        {{-- completed --}}
        <div class="col-md-4 mt-3">
            <div class="card">
                <div class="card-header bg-success text-white"><i class="fas fa-tasks mr-3"></i>Completed</div>
                <div class="card-body alert-success">
                    <div id="completedTasks">
                        @foreach (collect($project->tasks)->where('status','completed')->sortBy(function ($task) {
                            return $task->serial_number;
                        }) as $task)
                        <div class="task_item" data-id="{{$task->id}}">
                            <div class="d-flex justify-content-between mb-2">
                                <h6>{{$task->title}}</h6>
                                <div>
                                    <a href="#" data-toggle="modal" data-target="#editCompletedTaskModal_{{$task->id}}" class="task_edit_btn text-warning mr-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" data-toggle="modal" data-target="#deleteCompletedTask_{{$task->id}}"  class="task_edit_btn text-danger">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="fas fa-clock"></i>
                                    {{ Carbon\Carbon::parse($task->start_date)->format('M d') }}

                                    <br>
                                    <br>
                                    @if($task->priority == 'high')
                                    <span class="badge badge-pill badge-danger">HIGH</span>
                                    @elseif($task->priority == 'middle')
                                    <span class="badge badge-pill badge-info">MIDDLE</span>
                                    @else
                                    <span class="badge badge-pill badge-success">LOW</span>
                                    @endif

                                </div>
                                <div>
                                    @foreach ($task->members as $member)
                                        <p class="mb-0">* {{$member->name}}</p>
                                    @endforeach
                                </div>

                            </div>
                            <!-- edit Completed Task Modal -->
                <div class="modal fade" id="editCompletedTaskModal_{{$task->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Pending Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                        <form id="updateTaskForm_{{$task->id}}">
                            @csrf
                            @method('put')
                            {{-- project id and status --}}
                            <input type="hidden" name="project_id" value="{{$project->id}}">
                            <input type="hidden" name="status" value="completed">
                                {{-- title --}}
                            <div class="md-form">
                                <input id="title" type="text" class="form-control" name="title" value="{{$task->title}}">
                                <label for="title">Title</label>
                            </div>
                            {{-- description --}}
                            <div class="md-form">
                            <textarea id="form7" class="md-textarea form-control" name="description" rows="3">{{$task->description}}</textarea>
                            <label for="form7">Description</label>
                            </div>
                            {{-- start Date --}}
                            <div class="md-form">
                                    <input  type="text" class="datepicker form-control" name="start_date"
                                autocomplete="off"
                                value="{{$task->start_date}}">
                                    <label for="materialLoginFormEmail">Start Date</label>
                            </div>
                            {{-- deadline Date --}}
                            <div class="md-form">
                                    <input  type="text" class="datepicker form-control" name="deadline_date"
                                autocomplete="off"
                                value="{{$task->deadline_date}}">
                                    <label for="materialLoginFormEmail">Deadline Date</label>
                            </div>

                            {{-- members --}}

                                <label for="" class="mt-3">Members</label>

                                <select name="members[]" class="mt-4 d-block form-control select2" multiple >
                                    @php
                                        $member_ids = [];
                                        foreach ($task->members as $member) {
                                            array_push($member_ids,$member->id);
                                        }
                                    @endphp
                                    @foreach ($project->members as $member)
                                        <option value="{{$member->id}}" @if(in_array($member->id,$member_ids)) selected @endif>{{$member->name}}</option>
                                    @endforeach
                                </select>


                            {{-- priority --}}
                            <label for="" class="mt-3">Priority</label>
                            <select name="priority" class="my-3 form-control select2 @error('priority') is-invalid @enderror" aria-label="Default select example">
                                    <option value="" selected>-- Select Priority --</option>
                                    <option value="low" @if($task->priority == 'low') selected @endif>Low</option>
                                    <option value="middle" @if($task->priority == 'middle') selected @endif>Middle</option>
                                    <option value="high" @if($task->priority == 'high') selected @endif>High</option>
                            </select>
                        </form>
                        </div>
                        <div class="modal-footer">
                        <button type="button" id="update_task_btn" value="{{$task->id}}" class="btn btn-primary">UPDATE</button>
                        </div>
                    </div>
                    </div>
                </div>
                <!-- delete In Progress task Modal -->
                <div class="modal fade" id="deleteCompletedTask_{{$task->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                           <h5> Delete Task ?</h5>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="deleteTaskBtn" value="{{$task->id}}">Delete</button>
                        </div>
                    </div>
                    </div>
                </div>
                        </div>
                        @endforeach
                    </div>


                    <div class="text-center">
                        <a href="" data-toggle="modal" data-target="#addCompletedTaskModal" class="d-block text-center bg-white add_task_btn
                        p-2"><i class="fas fa-plus-circle mr-3"></i>Add Task</a>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>

<!-- Add Pending Task Modal -->
<div class="modal fade" id="addPendingTaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Pending Task</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         <form id="pendingTaskForm">
             @csrf
             {{-- project id and status --}}
             <input type="hidden" name="project_id" value="{{$project->id}}">
             <input type="hidden" name="status" value="pending">
                {{-- title --}}
            <div class="md-form">
                <input id="title" type="text" class="form-control" name="title">
                <label for="title">Title</label>
            </div>
            {{-- description --}}
            <div class="md-form">
            <textarea id="form7" class="md-textarea form-control" name="description" rows="3"></textarea>
            <label for="form7">Description</label>
            </div>
            {{-- start Date --}}
            <div class="md-form">
                    <input  type="text" class="datepicker form-control" name="start_date"
                autocomplete="off">
                    <label for="materialLoginFormEmail">Start Date</label>
            </div>
            {{-- deadline Date --}}
            <div class="md-form">
                    <input  type="text" class="datepicker form-control" name="deadline_date"
                autocomplete="off">
                    <label for="materialLoginFormEmail">Deadline Date</label>
            </div>

            {{-- members --}}

                <label for="" class="mt-3">Members</label>

                <select name="members[]" class="mt-4 d-block form-control select2" multiple >

                    @foreach ($project->members as $member)
                        <option value="{{$member->id}}">{{$member->name}}</option>
                    @endforeach
                </select>


            {{-- priority --}}
            <label for="" class="mt-3">Priority</label>
            <select name="priority" class="my-3 form-control select2 @error('priority') is-invalid @enderror" aria-label="Default select example">
                    <option value="" selected>-- Select Priority --</option>
                    <option value="low">Low</option>
                    <option value="middle">Middle</option>
                    <option value="high">High</option>
            </select>
         </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="add_pending_task_btn" class="btn btn-primary">Confirm</button>
        </div>
      </div>
    </div>
  </div>

  {{-- Add In Progress Model --}}
  <div class="modal fade" id="addInProgressTaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add In Progress Task</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         <form id="inProgressTaskForm">
             @csrf
             {{-- project id and status --}}
             <input type="hidden" name="project_id" value="{{$project->id}}">
             <input type="hidden" name="status" value="in_progress">
                {{-- title --}}
            <div class="md-form">
                <input id="title" type="text" class="form-control" name="title">
                <label for="title">Title</label>
            </div>
            {{-- description --}}
            <div class="md-form">
            <textarea id="form7" class="md-textarea form-control" name="description" rows="3"></textarea>
            <label for="form7">Description</label>
            </div>
            {{-- start Date --}}
            <div class="md-form">
                    <input  type="text" class="datepicker form-control" name="start_date"
                autocomplete="off">
                    <label for="materialLoginFormEmail">Start Date</label>
            </div>
            {{-- deadline Date --}}
            <div class="md-form">
                    <input  type="text" class="datepicker form-control" name="deadline_date"
                autocomplete="off">
                    <label for="materialLoginFormEmail">Deadline Date</label>
            </div>

            {{-- members --}}

                <label for="" class="mt-3">Members</label>

                <select name="members[]" class="mt-4 d-block form-control select2" multiple >

                    @foreach ($project->members as $member)
                        <option value="{{$member->id}}">{{$member->name}}</option>
                    @endforeach
                </select>


            {{-- priority --}}
            <label for="" class="mt-3">Priority</label>
            <select name="priority" class="my-3 form-control select2 @error('priority') is-invalid @enderror" aria-label="Default select example">
                    <option value="" selected>-- Select Priority --</option>
                    <option value="low">Low</option>
                    <option value="middle">Middle</option>
                    <option value="high">High</option>
            </select>
         </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="add_in_progress_task_btn" class="btn btn-primary">Confirm</button>
        </div>
      </div>
    </div>
  </div>

  {{--Add Completed Task model  --}}
  <div class="modal fade" id="addCompletedTaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Completed Task</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         <form id="completedTaskForm">
             @csrf
             {{-- project id and status --}}
             <input type="hidden" name="project_id" value="{{$project->id}}">
             <input type="hidden" name="status" value="completed">
                {{-- title --}}
            <div class="md-form">
                <input id="title" type="text" class="form-control" name="title">
                <label for="title">Title</label>
            </div>
            {{-- description --}}
            <div class="md-form">
            <textarea id="form7" class="md-textarea form-control" name="description" rows="3"></textarea>
            <label for="form7">Description</label>
            </div>
            {{-- start Date --}}
            <div class="md-form">
                    <input  type="text" class="datepicker form-control" name="start_date"
                autocomplete="off">
                    <label for="materialLoginFormEmail">Start Date</label>
            </div>
            {{-- deadline Date --}}
            <div class="md-form">
                    <input  type="text" class="datepicker form-control" name="deadline_date"
                autocomplete="off">
                    <label for="materialLoginFormEmail">Deadline Date</label>
            </div>

            {{-- members --}}

                <label for="" class="mt-3">Members</label>

                <select name="members[]" class="mt-4 d-block form-control select2" multiple >

                    @foreach ($project->members as $member)
                        <option value="{{$member->id}}">{{$member->name}}</option>
                    @endforeach
                </select>


            {{-- priority --}}
            <label for="" class="mt-3">Priority</label>
            <select name="priority" class="my-3 form-control select2 @error('priority') is-invalid @enderror" aria-label="Default select example">
                    <option value="" selected>-- Select Priority --</option>
                    <option value="low">Low</option>
                    <option value="middle">Middle</option>
                    <option value="high">High</option>
            </select>
         </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="add_completed_task_btn" class="btn btn-primary">Confirm</button>
        </div>
      </div>
    </div>
  </div>
@endsection



@section('custom-script')

    <script>

        $(document).ready(function() {
            const viewer = new Viewer(document.getElementById('project_image'));
            //ajax csrf setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //date range picker
            $('.datepicker').daterangepicker({
                    "singleDatePicker": true,
                    "showDropdowns": true,
                    "autoApply": true,
                    // autoUpdateInput: false,
                    "locale": {
                        "format": "YYYY-MM-DD"
                    }
                })

            //add pending task ajax
            $(document).on("click","#add_pending_task_btn",function(e) {
                e.preventDefault();
                var datastring = $("#pendingTaskForm").serialize();
                // console.log(datastring);
                $.ajax({
                    type: "POST",
                    url: "/tasks",
                    data: datastring,
                    success: function(data) {
                      if(data == 'success'){
                        location.reload();
                      }
                    },
                });
            });


            //add in progress task ajax
            $(document).on("click","#add_in_progress_task_btn",function(e) {
                e.preventDefault();
                var datastring = $("#inProgressTaskForm").serialize();
                // console.log(datastring);
                $.ajax({
                    type: "POST",
                    url: "/tasks",
                    data: datastring,
                    success: function(data) {
                      if(data == 'success'){
                        location.reload();
                      }
                    },
                });
            });

            //add completed task ajax
            $(document).on("click","#add_completed_task_btn",function(e) {
                e.preventDefault();
                var datastring = $("#completedTaskForm").serialize();
                // console.log(datastring);
                $.ajax({
                    type: "POST",
                    url: "/tasks",
                    data: datastring,
                    success: function(data) {
                      if(data == 'success'){
                        location.reload();
                      }
                    },
                });
            });

            //Update pending task ajax
            $(document).on("click","#update_task_btn",function(e) {
                e.preventDefault();

                let task_id = e.target.value;


                var datastring = $(`#updateTaskForm_${task_id}`).serialize();

                $.ajax({
                    type: "PUT",
                    url: `/tasks/${task_id}`,
                    data: datastring,
                    success: function(data) {
                      if(data == 'success'){
                        location.reload();
                      }
                    },
                });
            });

            //Update In_progress task ajax
            // $(document).on("click","#update_in_progress_task_btn",function(e) {
            //     e.preventDefault();

            //     let task_id = e.target.value;


            //     var datastring = $(`#editInProgressTaskForm_${task_id}`).serialize();

            //     $.ajax({
            //         type: "PUT",
            //         url: `/tasks/${task_id}`,
            //         data: datastring,
            //         success: function(data) {
            //           if(data == 'success'){
            //             location.reload();
            //           }
            //         },
            //     });
            // });

            //Update Completed task ajax
            // $(document).on("click","#update_completed_task_btn",function(e) {
            //     e.preventDefault();

            //     let task_id = e.target.value;


            //     var datastring = $(`#editCompletedTaskForm_${task_id}`).serialize();

            //     $.ajax({
            //         type: "PUT",
            //         url: `/tasks/${task_id}`,
            //         data: datastring,
            //         success: function(data) {
            //           if(data == 'success'){
            //             location.reload();
            //           }
            //         },
            //     });
            // });

             //Delet task ajax
             $(document).on("click","#deleteTaskBtn",function(e) {
                e.preventDefault();

                let task_id = e.target.value;

                $.ajax({
                    type: "DELETE",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                    url: `/tasks/${task_id}`,
                    success: function(data) {
                        // console.log(data);
                      if(data == 'success'){
                        location.reload();
                      }
                    },
                });
            });

            //sortable js
            var el = document.getElementById('pendingTasks');
            Sortable.create(el,{
                group: "task",
                ghostClass: "sortable-ghost",
                animation: 150,
                store :{
                    set:function(sortable){
                        var order = sortable.toArray();
                        localStorage.setItem('pendingTasks', order.join('|'));
                    }
                },
                onSort: function (/**Event*/evt) {
                    setTimeout(() => {
                        let newPendingTasks = localStorage.getItem('pendingTasks');
                        $.ajax({
                            type: "GET",
                            url: `/tasks_draggable?pendingTasks=${newPendingTasks}`,
                            success: function(data) {
                            if(data == 'success'){
                                // location.reload();
                            }
                            // console.log(data);
                            },
                        });
                    }, 1500);

                },
            });
            var el = document.getElementById('inProgressTasks');
            Sortable.create(el,{
                group: "task",
                ghostClass: "sortable-ghost",
                animation: 150,
                store :{
                    set:function(sortable){
                        var order = sortable.toArray();
                        localStorage.setItem('inProgressTasks', order.join('|'));
                    }
                },
                onSort: function (/**Event*/evt) {
                    setTimeout(() => {
                        let newInProgressTasks = localStorage.getItem('inProgressTasks');
                        $.ajax({
                            type: "GET",
                            url: `/tasks_draggable?inProgressTasks=${newInProgressTasks}`,
                            success: function(data) {
                            if(data == 'success'){
                                // location.reload();
                            }
                            // console.log(data);
                            },
                        });
                    }, 1500);

                },
            });
            //graggable completed
            var el = document.getElementById('completedTasks');
            Sortable.create(el,{
                group: "task",
                ghostClass: "sortable-ghost",
                animation: 150,
                store :{
                    set:function(sortable){
                        var order = sortable.toArray();
                        localStorage.setItem('completedTasks', order.join('|'));
                    }
                },
                onSort: function (/**Event*/evt) {
                    setTimeout(() => {
                        let newCompletedTasks = localStorage.getItem('completedTasks');
                        $.ajax({
                            type: "GET",
                            url: `/tasks_draggable?completedTasks=${newCompletedTasks}`,
                            success: function(data) {
                            if(data == 'success'){
                                // location.reload();
                            }
                            // console.log(data);
                            },
                        });
                    }, 1500);

                },
            });

                        });
    </script>
@endsection

