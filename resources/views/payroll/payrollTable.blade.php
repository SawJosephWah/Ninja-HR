<div class="table-responsive mb-3">
    <table id="" class="table table-bordered table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Employee</th>
                {{-- @foreach ($periods as $period)
                <th class="text-center @if($period->format('D') == 'Sat' || $period->format('D') == 'Sun') alert-danger @endif">
                    {{$period->format('d')}}
                    <br>
                    {{$period->format('D')}}
                </th>
                @endforeach --}}
                <th class="text-center">Role</th>
                <th class="text-center">Days Of Month</th>
                <th class="text-center">Working Day</th>
                <th class="text-center">Off Day</th>
                <th class="text-center">Attendance Day</th>
                <th class="text-center">Leave and Late</th>
                <th class="text-center">Per Day (MMK)</th>
                <th class="text-center">Total (MMK)</th>
            </tr>

        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{$user->name}}</td>

                <td>@foreach ($user->roles as $role)
                    {{$role->name}}
                @endforeach</td>
                <td>{{$daysInMonth}}</td>
                <td>{{$workingDays}}</td>
                <td>{{$offDays}}</td>
                    @php
                    $attendanceDays = 0;
                    $leaveDays = 0;
                    $salary = collect($user->salaries)->where('month',$month)->where('year',$year)->first();
                    $perDay = $salary ? $salary->amount/$workingDays : 0 ;
                    @endphp

                    @foreach ($periods as $period)
                    @php





                    $company_start_time =  $period->format('Y-m-d').' '.$companySetting->company_start_time;
                    $company_end_time =  $period->format('Y-m-d').' '.$companySetting->company_end_time;
                    $company_break_start =  $period->format('Y-m-d').' '.$companySetting->company_break_start;
                    $company_break_end =  $period->format('Y-m-d').' '.$companySetting->company_break_end;

                    $attendance = collect($attendances)->where('date',$period->format('Y-m-d'))->where('user_id',$user->id)->first();


                    if($attendance){

                        if($attendance->check_in_time > $company_break_start && $attendance->check_out_time < $company_break_end ){
                            $leaveDays++;
                        }else{
                            $attendanceDays++;
                        }
                    }else{
                        if($period->isWeekday())
                        $leaveDays++;
                    }


                @endphp

                @endforeach
                <td>
                    {{$attendanceDays}}
                </td>
                <td> {{$leaveDays}}</td>
                <td>{{number_format($perDay) }}</td>
                <td>{{number_format($perDay * $attendanceDays)}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
