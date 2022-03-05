<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'user_id' , 'date','check_in_time','check_out_time'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
