@extends('layouts.app')
@section('title','CREATE DEPARTMENT')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('department.store')}}" id="StoreEmployee" method="POST">
                        @csrf
                           <!-- Name -->
                            <div class="md-form">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                value="{{ old('title') }}">
                                <label for="title">Title</label>

                                @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <button class="btn btn-theme btn-block" type="submit"><i class="feather-user-plus mr-3"></i>Create</button>
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
                        });
    </script>
@endsection

@endsection
