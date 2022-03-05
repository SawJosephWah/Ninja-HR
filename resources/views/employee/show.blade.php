@extends('layouts.app')
@section('title','EMPLOYEE DETAILS')
@section('content')
<div class="container">
    <div class="card py-5">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-5 mb-md-1">
                    <div class="row align-items-center">
                        <div class="col-md-5 mb-5 mb-md-1 d-flex justify-content-center">
                            <img src="{{asset('/img/profiles/'.$employee->image)}}" class="profile_img" alt="">
                        </div>
                        <div class="col-md-7">
                            <div class="">
                                <h4>{{$employee->name}}</h4>
                                <p class="mb-1 text-muted mb-2"> {{$employee->employee_id}}</p>
                                <p class="mb-1 text-muted">
                                    <span class="badge badge-pill badge-dark">
                                        {{$employee->department->title}}
                                    </span>
                                </p>

                                <p class="mb-1 text-muted">
                                    @foreach ($employee->roles as $role)
                                        <span class="badge badge-pill badge-primary">
                                            {{$role->name}}
                                        </span>
                                    @endforeach
                                </p>
                            </div>
                        </div>


                    </div>

                </div>
                <div class="col-md-6 dash_border pl-4">
                    <p class="mb-1">
                        <b>Phone :</b> <span class="text-muted"> {{$employee->phone}}</span>
                    </p>
                    <p class="mb-1">
                        <b>Email :</b> <span class="text-muted"> {{$employee->email}}</span>
                    </p>
                    <p class="mb-1">
                        <b>NRC Number :</b> <span class="text-muted"> {{$employee->nrc_number}}</span>
                    </p>
                    <p class="mb-1">
                        <b>Gender :</b> <span class="text-muted"> {{ ucfirst($employee->gender)}}</span>
                    </p>
                    <p class="mb-1">
                        <b>Birthday :</b> <span class="text-muted"> {{$employee->birthday}}</span>
                    </p>
                    <p class="mb-1">
                        <b>Address :</b> <span class="text-muted"> {{$employee->address}}</span>
                    </p>
                    <p class="mb-1">
                        <b>Date of Join :</b> <span class="text-muted"> {{$employee->join_of_date}}</span>
                    </p>
                    <p class="mb-1">
                        <b>Is Present ? :</b> <span class="text-muted">
                             @if($employee->is_present == 1)
                                <span class="badge badge-pill badge-success">Present</span>
                            @else
                                <span class="badge badge-pill badge-success">leave</span>
                            @endif
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('custom_css')
<style>
    .profile_img{
        width: 200px;
        height: 200px;
        border-radius: 50%;
        border: 1px solid rgb(0, 155, 72);
    }
    .dash_border{
        border-left: 1px dashed rgb(155, 155, 155);
    }
</style>
@endsection
