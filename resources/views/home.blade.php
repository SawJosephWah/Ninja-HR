@extends('layouts.app')
@section('title','HOME')
@section('content')
<div class="container">
    <div class="card py-3">
        <div class="card-body">
            <div class="text-center">
                <img src="{{asset('/img/profiles/'.$employee->image)}}" class="profile_img mb-3" alt="">
                <div class="">
                    <h4>{{$employee->name}}</h4>
                    <p class="mb-1 text-muted mb-2">
                        <span>{{$employee->employee_id}}</span> |
                        <span class="text-theme">{{$employee->phone}}</span>
                    </p>
                    <p class="mb-1 text-muted">
                        <span class="badge badge-pill badge-dark">
                            {{$employee->department->title}}
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
    .dash_border{
        border-left: 1px dashed rgb(155, 155, 155);
    }
</style>
@endsection
