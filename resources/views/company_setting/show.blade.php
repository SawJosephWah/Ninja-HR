@extends('layouts.app')
@section('title','COMPANY SETTING')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h6>Company Name</h6>
                    <h6 class="text-muted">{{$company_setting->company_name}}</h6>
                </div>
                <div class="col-md-6 mb-3">
                    <h6>Company Email</h6>
                    <h6 class="text-muted">{{$company_setting->company_email}}</h6>
                </div>
                <div class="col-md-6 mb-3">
                    <h6>Company Phone</h6>
                    <h6 class="text-muted">{{$company_setting->company_phone}}</h6>
                </div>
                <div class="col-md-6 mb-3">
                    <h6>Company Address</h6>
                    <h6 class="text-muted">{{$company_setting->company_address}}</h6>
                </div>
                <div class="col-md-6 mb-3">
                    <h6>Company Start Time</h6>
                    <h6 class="text-muted">{{$company_setting->company_start_time}}</h6>
                </div>
                <div class="col-md-6 mb-3">
                    <h6>Company End Time</h6>
                    <h6 class="text-muted">{{$company_setting->company_end_time}}</h6>
                </div>
                <div class="col-md-6 mb-3">
                    <h6>Company Break Start</h6>
                    <h6 class="text-muted">{{$company_setting->company_break_start}}</h6>
                </div>
                <div class="col-md-6 mb-3">
                    <h6>Company Break End</h6>
                    <h6 class="text-muted">{{$company_setting->company_break_end}}</h6>
                </div>

            </div>
            @can('edit_company_setting')
            <div class="row justify-content-center">
                <div class="">
                    <a href="{{route('company_setting.edit',$company_setting->id)}}" class="btn btn-sm btn-warning"><i class="fas fa-edit mr-3"></i>Edit Company Setting</a>
                </div>
            </div>
            @endcan

        </div>
    </div>
</div>

@endsection



@section('custom-script')
@endsection
