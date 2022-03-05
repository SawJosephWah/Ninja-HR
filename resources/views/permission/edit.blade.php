@extends('layouts.app')
@section('title','EDIT PERMISSION')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('permission.update',$permission->id)}}"  method="POST">
                        @csrf
                        @method('PUT')
                           <!-- Title -->
                            <div class="md-form">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name',$permission->name) }}">
                                <label for="name">Permission Name</label>

                                @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <button class="btn btn-theme btn-block" type="submit"><i class="fas fa-shield-alt mr-3"></i>Update</button>
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
