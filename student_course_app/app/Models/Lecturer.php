<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    public function courses()
    {
        return $this->belongsToMany(Course::class)->withTimestamps();
    }
protected $fillable = ['name', 'staff_id', 'email'];

}
