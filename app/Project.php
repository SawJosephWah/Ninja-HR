<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function leaders()
    {
        return $this->belongsToMany(User::class,'project_leaders', 'project_id', 'user_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class,'project_members', 'project_id', 'user_id');
    }

    public function tasks(){
        return $this->hasMany(Task::class,'project_id','id');
    }
}
