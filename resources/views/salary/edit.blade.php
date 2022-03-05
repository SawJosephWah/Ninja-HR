@extends('layouts.app')
@section('title','UPDATE SALARY')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{route('salary.update',$salary->id)}}" method="post">
                    @method('PUT')
                    @csrf
                    <div class="form-group ">
                        <label for="">User</label>
                        <select name="user_id" id="" class="form-control  @error('user_id') border-danger @enderror">
                            <option value="">-- select user --</option>
                            @foreach ($users as $user)
                            <option value="{{$user->id}}" @if($user->id == $salary->user_id) selected @endif>{{$user->name}}</option>
                            @endforeach

                        </select>
                        @error('user_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Month</label>
                        <select name="month" id="" class="form-control filter_month  @error('month') border-danger @enderror" >
                            <option value="">-- Select Month --</option>
                            <option value="01" @if($salary->month == '01') selected @endif>Jan</option>
                            <option value="02" @if($salary->month == '02') selected @endif>Feb</option>
                            <option value="03" @if($salary->month == '03') selected @endif>Mar</option>
                            <option value="04" @if($salary->month == '04') selected @endif>Apr</option>
                            <option value="05" @if($salary->month == '05') selected @endif>May</option>
                            <option value="06" @if($salary->month == '06') selected @endif>Jun</option>
                            <option value="07" @if($salary->month == '07') selected @endif>July</option>
                            <option value="08" @if($salary->month == '08') selected @endif>Aug</option>
                            <option value="09" @if($salary->month == '09') selected @endif>Sep</option>
                            <option value="10" @if($salary->month == '10') selected @endif>Oct</option>
                            <option value="11" @if($salary->month == '11') selected @endif>Nov</option>
                            <option value="12" @if($salary->month == '12') selected @endif>Dec</option>
                        </select>
                        @error('month')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Year</label>
                        <select name="year" id="" class="form-control filter_year  @error('year') border-danger @enderror">
                            {{$startYear = now()->format('Y')-2}}
                            {{$endYear = now()->format('Y')+2}}

                            <option value="">-- Select Year --</option>
                            @for($i = $startYear; $i <= $endYear; $i++)
                            <option value="{{$i}}" @if($salary->year == $i) selected @endif>{{$i}}</option>
                            @endfor
                        </select>
                        @error('year')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="md-form">
                        <label for="">Amount (MMK)</label>
                        <input type="number" class="form-control" name="amount" value="{{$salary->amount}}">
                        @error('amount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <button class="btn btn-block btn-success" type="submit">Update</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
