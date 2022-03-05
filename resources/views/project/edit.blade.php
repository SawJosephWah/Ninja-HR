@extends('layouts.app')
@section('title','UPDATE PROJECT')
@section('content')
@section('custom_css')
    <style>
        .img_demo{
            width: 120px;
            height: 80px;
            border-radius: 10px;
            margin-top: 5px;
        }
        .pdf_demo{
            width: 80px;
            height: 100px;
            border-radius: 10px;
            margin-top: 5px;
            border:1px solid rgb(90, 90, 90);
            text-align: center;
            line-height: 100px;
            padding: 10px
        }
        .pdf{
            font-size: 80px;
            margin: 5px;
        }
    </style>
@endsection
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('projects.update',$project->id)}}" id="StoreEmployee" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                           <!-- Title -->
                            <div class="md-form">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                value="{{ old('title',$project->title) }}">
                                <label for="title">Title</label>

                                @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            {{-- Desription --}}
                            <div class="md-form">
                                <textarea id="form7" class="md-textarea form-control @error('description') is-invalid @enderror" name="description" rows="3">{{$project->description}}</textarea>
                                <label for="form7">Description</label>
                                @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                            {{-- image --}}
                            <label for="materialLoginFormEmail">Project Image (Only PNG, JPG , JPEG)</label>
                                            <input id="image"  type="file" class="form-control p-1" name="image"
                                            value="{{ old('image') }}" accept="image/png, image/jpg, image/jpeg">

                                                   <div id="uploadPreview">
                                                       @if($project->images)
                                                    <img src="/img/projects_imgs/{{$project->images}}" class="img_demo">
                                                    @endif
                                                   </div>


                            {{-- files --}}
                            <br>
                            <label for="materialLoginFormEmail">Project Files (Only PDF)</label>
                                            <input id="image"  type="file" class="form-control p-1" name="files"
                                            value="{{ old('files') }}" accept="application/pdf">

                                            <div id="PDFuploadPreview">
                                                @if($project->files)

                                                 <i class="fas fa-file-pdf pdf"></i>
                                                 <br>


                                             @endif
                                            </div>


                           {{-- //start date --}}
                           <div class="md-form">
                            <input  type="text" class="date form-control @error('start_date') is-invalid @enderror" name="start_date"
                            value="{{ old('start_date',$project->start_date) }}"  autocomplete="off">
                            <label for="materialLoginFormEmail">Start Date</label>

                            @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        {{-- end date --}}
                        <div class="md-form">
                            <input type="text" class="date form-control @error('deadline') is-invalid @enderror" name="deadline"
                            value="{{ old('deadline',$project->deadline) }}"  autocomplete="off">
                            <label for="materialLoginFormEmail">Deadline Date</label>

                            @error('deadline')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>


                        {{-- leader --}}
                        <label for="">Leaders</label>
                        <select name="leaders[]" class="mb-3 form-control select2" multiple aria-label="Default select example">

                            @foreach ($users as $user)
                            <option value="{{$user->id}}" @if(in_array($user->id, $project_leaders)) selected @endif>{{$user->name}}</option>
                        @endforeach
                        </select>
                        <img src="" alt="" class="width:100px;height:100px;">
                        {{-- members --}}
                        <label for="" class="mt-3">Members</label>
                        <select name="members[]" class="mt-4 form-control select2" multiple aria-label="Default select example">

                            @foreach ($users as $user)
                                <option value="{{$user->id}}" @if(in_array($user->id, $project_members)) selected @endif>{{$user->name}}</option>
                            @endforeach
                        </select>

                        {{-- priority --}}
                        <select name="priority" class="my-3 form-control @error('priority') is-invalid @enderror" aria-label="Default select example">
                            <option value="" selected>-- Select Priority --</option>
                            <option value="low" @if($project->priority == 'low') selected @endif>Low</option>
                            <option value="middle" @if($project->priority == 'middle') selected @endif>Middle</option>
                            <option value="high" @if($project->priority == 'high') selected @endif>High</option>
                        </select>
                        @error('priority')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror

                        {{-- Status --}}
                        <select name="status" class="form-control @error('status') is-invalid @enderror" aria-label="Default select example">
                            <option value="" selected>-- Select Status -- </option>
                            <option value="pending" @if($project->status == 'pending') selected @endif>Pending</option>
                            <option value="in_progress" @if($project->status == 'in_progress') selected @endif>On Progress</option>
                            <option value="completed" @if($project->status == 'completed') selected @endif>Completed</option>
                        </select>
                        @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror

                        <div class="row justify-content-center mt-3">
                            <div class="col-md-6">
                                <button class="btn btn-theme btn-block" type="submit"><i class="fas fa-toolbox mr-3"></i>Update</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>


        </div>
    </div>

</div>


@section('custom-script')
{{-- {!! JsValidator::formRequest('App\Http\Requests\StoreEmployee','#StoreEmployee') !!} --}}
    <script>

        $(document).ready(function() {
            //image preview
            $("#image").change(function(){
                var oFReader = new FileReader();
                oFReader.readAsDataURL(document.getElementById("image").files[0]);

                oFReader.onload = function (oFREvent) {
                    $('#uploadPreview').html(`<img id="uploadPreview" src="${oFREvent.target.result}" class="img_demo">`)

                };
            });


            $('.date').daterangepicker({
                "singleDatePicker": true,
                "showDropdowns": true,
                "autoApply": true,
                autoUpdateInput: false,
                "locale": {
                    "format": "YYYY-MM-DD   "
                }
            }).on("apply.daterangepicker", function (e, picker) {
                picker.element.val(picker.startDate.format(picker.locale.format));
            });
                        });
    </script>
@endsection

@endsection
