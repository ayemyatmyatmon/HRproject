<?php

namespace App;

use App\User;
use App\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function members(){
        return $this->belongsToMany(User::class,'Task_members','task_id','user_id');
    }
    
}
