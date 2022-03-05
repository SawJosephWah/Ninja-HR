@extends('layouts.app')
@section('title','EDIT ROLE')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('role.update',$role->id)}}" id="StoreEmployee" method="POST">
                        @csrf
                        @method('PUT')
                           <!-- Title -->
                            <div class="md-form">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name',$role->name) }}">
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
                                        <input class="" type="checkbox" name="permissions[]" value="{{$permission->name}}" id="permission_{{$permission->id}}" @if(in_array($permission->id,$old_permissions)) checked @endif/>
                                        <label class="form-check-label" for="permission_{{$permission->id}}">
                                            {{$permission->name}}
                                        </label>
                                </div>
                                @endforeach
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
