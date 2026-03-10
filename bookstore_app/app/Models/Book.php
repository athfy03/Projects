<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'isbn', 'price'];

    public function authors()
    {
        return $this->belongsToMany(Author::class)->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }
}
