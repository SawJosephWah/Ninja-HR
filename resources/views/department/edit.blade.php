@extends('layouts.app')
@section('title','EDIT DEPARTMENT')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('department.update',$department->id)}}" id="StoreEmployee" method="POST">
                        @csrf
                        @method('PUT')
                           <!-- Title -->
                            <div class="md-form">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                value="{{ old('title',$department->title) }}">
                                <label for="title">Title</label>

                                @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <button class="btn btn-theme btn-block" type="submit"><i class="feather-user-plus mr-3"></i>Update</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>


        </div>
    </div>

</div>


@section('custom-script')

    <script>

        $(document).ready(function() {
                        });
    </script>
@endsection

@endsection
