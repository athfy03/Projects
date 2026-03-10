<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function courses()
    {
        return $this->belongsToMany(Course::class)->withTimestamps();
    }
protected $fillable = ['name', 'matric_no', 'email'];

}
