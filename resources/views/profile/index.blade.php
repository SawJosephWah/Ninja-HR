@extends('layouts.app')
@section('title','PROFILE')
@section('content')
<div class="container">
    <div class="card py-5 mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-5 mb-md-1">
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

    <div class="card mb-3">
        <div class="card-body">
            <a href="#" id="logoutBtn" class="btn btn-danger btn-block"><i class="fas fa-sign-out-alt mr-3"></i>LOGOUT</a>
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

@section('custom-script')
    <script>
        $( document ).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).on("click","#logoutBtn",function(e) {
                e.preventDefault();


                Swal.fire({
                title: 'Logout?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'LOGOUT',
                reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                    type: "POST",
                    url: '/logout',
                    }).done(()=>{
                        window.location.replace('/login');
                    });
                }
                })
            });
        });

    </script>
@endsection
