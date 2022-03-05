<?php

use App\Attendance;
use App\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        foreach($users as $user){
            $periods = new CarbonPeriod('2020-01-01', '2021-12-31');
            foreach($periods as $period){
                if($period->format('D') != 'Sat' && $period->format('D') != 'Sun'){
                    $attendance = new Attendance();
                    $attendance->user_id = $user->id;
                    $attendance->date = $period->format('Y-m-d');
                    $attendance->check_in_time = Carbon::parse($period->format('Y-m-d').' '.'09:15:00')->subMinutes(rand(1, 55)) ;
                    $attendance->check_out_time = Carbon::parse($period->format('Y-m-d').' '.'17:30:00')->addMinutes(rand(1, 55));
                    $attendance->save();
                }

                    // $attendance = new Attendance();
                    // $attendance->user_id = $user->id;
                    // $attendance->date = $period->format('Y-m-d');
                    // $attendance->check_in_time = Carbon::parse($period->format('Y-m-d').' '.'09:15:00')->subMinutes(rand(1, 55)) ;
                    // $attendance->check_out_time = Carbon::parse($period->format('Y-m-d').' '.'17:30:00')->addMinutes(rand(1, 55));
                    // $attendance->save();


            }

        }
    }
}
