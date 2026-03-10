<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function students()
    {
        return $this->belongsToMany(Student::class)->withTimestamps();
    }

    public function lecturers()
    {
        return $this->belongsToMany(Lecturer::class)->withTimestamps();
    }
    protected $fillable = ['code', 'title', 'credit_hour'];

}
