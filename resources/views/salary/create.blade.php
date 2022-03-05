@extends('layouts.app')
@section('title','CREATE SALARY')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{route('salary.store')}}" method="post">
                    @csrf
                    <div class="form-group ">
                        <label for="">User</label>
                        <select name="user_id" id="" class="form-control @error('user_id') border-danger @enderror" >
                            <option value="">-- select user --</option>
                            @foreach ($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach

                        </select>
                        @error('user_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Month</label>
                        <select name="month" id="" class="form-control filter_month  @error('month') border-danger @enderror">
                            <option value="">-- Select Month --</option>
                            <option value="01"  >Jan</option>
                            <option value="02" >Feb</option>
                            <option value="03" >Mar</option>
                            <option value="04" >Apr</option>
                            <option value="05" >May</option>
                            <option value="06" >Jun</option>
                            <option value="07" >July</option>
                            <option value="08" >Aug</option>
                            <option value="09" >Sep</option>
                            <option value="10" >Oct</option>
                            <option value="11" >Nov</option>
                            <option value="12" >Dec</option>
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
                            <option value="{{$i}}" >{{$i}}</option>
                            @endfor
                        </select>
                        @error('year')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="md-form">
                        <label for="">Amount (MMK)</label>
                        <input type="number" class="form-control" name="amount">
                        @error('amount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <button class="btn btn-block btn-success" type="submit">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
