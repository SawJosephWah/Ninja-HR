@extends('layouts.app')
@section('title','Edit COMPANY SETTING')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="{{route('company_setting.update',$company_setting->id)}}" method="post">
                @csrf
                @method('PUT')
                <div class="md-form">
                    <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name"
                    value="{{ old('company_name' ,$company_setting->company_name) }}" >
                    <label for="company_name">Company Name</label>

                    @error('company_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>

                <div class="md-form">
                    <input id="company_email" type="text" class="form-control @error('company_email') is-invalid @enderror" name="company_email"
                    value="{{ old('company_email' ,$company_setting->company_email) }}" >
                    <label for="company_email">Company Email</label>

                    @error('company_email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>

                <div class="md-form">
                    <input id="company_phone" type="text" class="form-control @error('company_phone') is-invalid @enderror" name="company_phone"
                    value="{{ old('company_phone',$company_setting->company_phone) }}" >
                    <label for="company_phone">Company Phone</label>

                    @error('company_phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>

                <div class="md-form">
                    <textarea id="company_address" class="md-textarea form-control @error('company_address') is-invalid @enderror" name="company_address" rows="2">{{ old('company_address',$company_setting->company_address) }}</textarea>
                    <label for="company_address">Company Address</label>

                    @error('company_address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>

                <div class="md-form">
                    <input id="company_start_time" type="text" class="form-control timepicker @error('company_start_time') is-invalid @enderror" name="company_start_time"
                    value="{{ old('company_start_time',$company_setting->company_start_time) }}" >
                    <label for="company_start_time">Company Start Time</label>

                    @error('company_address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>

                <div class="md-form">
                    <input id="company_end_time" type="text" class="form-control timepicker @error('company_end_time') is-invalid @enderror" name="company_end_time"
                    value="{{ old('company_end_time',$company_setting->company_end_time) }}" >
                    <label for="company_end_time">Company End Time</label>

                    @error('company_address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>

                <div class="md-form">
                    <input id="company_break_start" type="text" class="form-control timepicker @error('company_break_start') is-invalid @enderror" name="company_break_start"
                    value="{{ old('company_break_start',$company_setting->company_break_start) }}" >
                    <label for="company_break_start">Company Break Start</label>

                    @error('company_break_start')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>

                <div class="md-form">
                    <input id="company_break_end" type="text" class="form-control timepicker @error('company_break_end') is-invalid @enderror" name="company_break_end"
                    value="{{old('company_break_end', $company_setting->company_break_end) }}" >
                    <label for="company_break_end">Company Break End</label>

                    @error('company_break_end')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>


                @can('update_company_setting')
                <div class="row justify-content-center">
                    <div class="">
                        <button href="" class="btn btn-sm btn-warning" type="submit"><i class="fas fa-edit mr-3"></i>Update Company Setting</button>
                    </div>
                </div>
                @endcan


            </form>
        </div>
    </div>
</div>

@endsection

@section('custom_css')

@endsection

@section('custom-script')
<script>
      $(document).ready(function() {
            $('.timepicker').daterangepicker({
                singleDatePicker: true,
                autoApply: true,
                timePicker : true,
                timePicker24Hour : true,
                timePickerIncrement : 1,
                timePickerSeconds : true,
                locale : {
                    format : 'HH:mm:ss'
                }
            }).on('show.daterangepicker', function(ev, picker) {
            picker.container.find(".calendar-table").hide();
   });

                        });
</script>
@endsection
