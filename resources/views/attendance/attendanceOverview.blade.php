@extends('layouts.app')
@section('title','ATTENDANCE')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <input type="text" class="form-control userName" placeholder="Username">
                        </div>
                        <div class="col-md-3">
                            <select name="" id="" class="form-control filter_month">
                                <option value="">-- Select Month --</option>
                                <option value="01"  @if(now()->format('m') == '01') selected @endif>Jan</option>
                                <option value="02" @if(now()->format('m') == '02') selected @endif>Feb</option>
                                <option value="03" @if(now()->format('m') == '03') selected @endif>Mar</option>
                                <option value="04" @if(now()->format('m') == '04') selected @endif>Apr</option>
                                <option value="05" @if(now()->format('m') == '05') selected @endif>May</option>
                                <option value="06" @if(now()->format('m') == '06') selected @endif>Jun</option>
                                <option value="07" @if(now()->format('m') == '07') selected @endif>July</option>
                                <option value="08" @if(now()->format('m') == '08') selected @endif>Aug</option>
                                <option value="09" @if(now()->format('m') == '09') selected @endif>Sep</option>
                                <option value="10" @if(now()->format('m') == '10') selected @endif>Oct</option>
                                <option value="11" @if(now()->format('m') == '11') selected @endif>Nov</option>
                                <option value="12" @if(now()->format('m') == '12') selected @endif>Dec</option>
                            </select>

                        </div>
                        <div class="col-md-3">
                            <select name="" id="" class="form-control filter_year">
                                <option value="">-- Select Year --</option>
                                @foreach(range(now()->format('Y')-1, date('Y')) as $y)
                                    <option value="{{$y}}" @if(now()->format('Y') == $y) selected @endif>{{$y}}</option>
                                @endforeach


                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-success btn-sm btn-block m-0 search_btn">Search</button>
                        </div>
                    </div>
                    <div class="attendance_overview_table"></div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('custom-script')
    <script>
        $(document).ready(function() {

            $('.search_btn').click(function(){
                attendanceOverviewTable();
            });

            function attendanceOverviewTable(){
                let userName= $('.userName').val();
                let month = $(".filter_month").find(":selected").val();
                let year = $(".filter_year").find(":selected").val();
                            $.ajax({
                                url: `/attendanceOverviewTable?userName=${userName}&month=${month}&year=${year}`,
                                type:"GET",
                                success: function(data) {
                                    console.log(data);
                                $('.attendance_overview_table').html(data);
                                }
                            })
            }
            attendanceOverviewTable();
        });

    </script>
@endsection
