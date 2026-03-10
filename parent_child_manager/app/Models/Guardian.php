<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    protected $fillable = ['father_name', 'mother_name', 'contact_number'];

    public function children()
    {
        return $this->hasMany(Child::class);
    }
}

