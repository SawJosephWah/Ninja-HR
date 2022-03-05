@extends('layouts.app')
@section('title','CREATE ROLE')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('role.store')}}" id="StoreEmployee" method="POST">
                        @csrf
                           <!-- Name -->
                            <div class="md-form">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" autofocus>
                                <label for="name">Role Name</label>

                                @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                            {{-- Permissions --}}
                            <div class="row mb-3">
                                @foreach ($permissions as $permission)
                                <div class="col-6 col-md-3">
                                        <input class="" type="checkbox" name="permissions[]" value="{{$permission->name}}" id="permission_{{$permission->id}}"/>
                                        <label class="form-check-label" for="permission_{{$permission->id}}">
                                            {{$permission->name}}
                                        </label>
                                </div>
                                @endforeach
                            </div>

                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <button class="btn btn-theme btn-block" type="submit"><i class="fas fa-shield-alt mr-3"></i>Create</button>
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
