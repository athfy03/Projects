<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Member; 

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
    'member_id',
    'book_id',
    'borrowed_at',
    'due_date',
    'status',
    ];


    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
}


