<div class="table-responsive mb-3">
    <table id="" class="table table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Employee</th>
                @foreach ($periods as $period)
                <th class="text-center @if($period->format('D') == 'Sat' || $period->format('D') == 'Sun') alert-danger @endif">
                    {{$period->format('d')}}
                    <br>
                    {{$period->format('D')}}
                </th>
                @endforeach
            </tr>

        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{$user->name}}</td>
                @foreach ($periods as $period)
                @php



                    $check_in_icon = '';
                    $check_out_icon = '';

                    $company_start_time =  $period->format('Y-m-d').' '.$companySetting->company_start_time;
                    $company_end_time =  $period->format('Y-m-d').' '.$companySetting->company_end_time;
                    $company_break_start =  $period->format('Y-m-d').' '.$companySetting->company_break_start;
                    $company_break_end =  $period->format('Y-m-d').' '.$companySetting->company_break_end;

                    $attendance = collect($attendances)->where('date',$period->format('Y-m-d'))->where('user_id',$user->id)->first();


                    if($attendance){
                        if($attendance->check_in_time < $company_start_time ){
                        $check_in_icon = '<i class="fas fa-check-circle text-success"></i>';
                    }elseif ($attendance->check_in_time < $company_break_start) {
                        $check_in_icon = '<i class="fas fa-check-circle text-warning"></i>';
                    }else{
                        $check_in_icon = '<i class="fas fa-times-circle text-danger"></i>';
                    }

                    if($attendance->check_out_time > $company_end_time ){
                        $check_out_icon = '<i class="fas fa-check-circle text-success"></i>';
                    }elseif ($attendance->check_out_time > $company_break_end) {
                        $check_out_icon = '<i class="fas fa-check-circle text-warning"></i>';
                    }else{
                        $check_out_icon = '<i class="fas fa-times-circle text-danger"></i>';
                    }
                    }else{

                        if($period->format('D') !== 'Sat' && $period->format('D') !== 'Sun'){

                        // $check_in_icon = '<i class="fas fa-times-circle text-danger"></i>';
                        // $check_out_icon = '<i class="fas fa-times-circle text-danger"></i>';

                        $check_in_icon = '<span class="text-danger">A</span> <br>';
                        $check_out_icon = '<span class="text-danger">A</span>';
                        }
                    }


                @endphp
                <td class="@if($period->format('D') == 'Sat' || $period->format('D') == 'Sun') alert-danger @endif">
                    {!! $check_in_icon !!}
                    {!! $check_out_icon !!}


                </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
