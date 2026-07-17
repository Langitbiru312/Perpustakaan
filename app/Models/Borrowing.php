<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $fillable = ['member_id', 'book_copy_id', 'borrow_date', 'due_date', 'return_date', 'status', 'notes'];

    protected $casts = [
        'borrow_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function bookCopy()
    {
        return $this->belongsTo(BookCopy::class);
    }

    public function fine()
    {
        return $this->hasOne(Fine::class);
    }
}
