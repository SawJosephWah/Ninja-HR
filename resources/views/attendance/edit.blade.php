@extends('layouts.app')
@section('title','ATTENDANCE UPDATE')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('attendance.update',$attendance->id)}}" method="POST">
                        <div class="form-group">
                            @csrf
                            @method('PUT')

                            {{-- <label for="">User Name</label> --}}
                            <select class="form-select select2 form-control  @error('user_id') is-invalid @enderror" name="user_id" aria-label="Default select example">
                                <option selected value=""></option>
                                @foreach ($users as $user)
                                <option value={{$user->id}} @if($attendance->user_id == $user->id) selected @endif>{{$user->name}}</option>
                                @endforeach


                            </select>
                            @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="md-form">
                            <input id="date" type="text" class="form-control @error('date') is-invalid @enderror" name="date"
                            value="{{ old('date',$attendance->date) }}" autocomplete="off" >
                            <label for="materialLoginFormEmail">Date</label>

                            @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>


                        <div class="md-form">
                            <input id="check_in_time" type="text" class="form-control timepicker @error('check_in_time') is-invalid @enderror" name="check_in_time"
                            value="{{ old('check_in_time',\Carbon\Carbon::parse($attendance->check_in_time ? $attendance->check_in_time : "00:00:00")->toTimeString()) }}" >
                            <label for="check_in_time">Check In Time</label>

                            @error('check_in_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>


                        <div class="md-form">
                            <input id="check_out_time" type="text" class="form-control timepicker @error('check_out_time') is-invalid @enderror" name="check_out_time"
                            value="{{ old('check_out_time',\Carbon\Carbon::parse($attendance->check_out_time ? $attendance->check_out_time : "00:00:00")->toTimeString() ) }}" >
                            <label for="check_out_time">Check Out Time</label>

                            @error('check_out_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success btn-sm">Update Attendance</button>
                    </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-script')
<script>
  $(document).ready(function() {
            $('#date').daterangepicker({
                "singleDatePicker": true,
                "showDropdowns": true,
                "autoApply": true,
                "autoUpdateInput": true,
                "locale": {
                    "format": "YYYY-MM-DD",
                    cancelLabel: 'Clear'
                }
            })

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
