<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookReservation extends Model
{
    protected $fillable = ['member_id', 'book_id', 'book_copy_id', 'reservation_date', 'expiry_date', 'status'];

    protected $casts = [
        'reservation_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function bookCopy()
    {
        return $this->belongsTo(BookCopy::class);
    }
}
