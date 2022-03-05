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
    </style>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="card">
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
                </div>
            </div>
            <div class="card mt-3">
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
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Leaders</h5>
                    @foreach ($project->leaders as $leader)
                        <div class="text-muted">* {{$leader->name}}</div>
                    @endforeach
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h5>Members</h5>
                    @foreach ($project->members as $member)
                        <div class="text-muted">* {{$member->name}}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>
@endsection



@section('custom-script')
{{-- {!! JsValidator::formRequest('App\Http\Requests\StoreEmployee','#StoreEmployee') !!} --}}
    <script>

        $(document).ready(function() {
            const viewer = new Viewer(document.getElementById('project_image'));
                        });
    </script>
@endsection

