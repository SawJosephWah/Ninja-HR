<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function members()
    {
        return $this->belongsToMany(User::class,'task_members', 'task_id', 'user_id');
    }
}
