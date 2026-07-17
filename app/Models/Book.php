<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'isbn', 'category_id', 'author_id', 'publisher_id', 'publication_year', 'synopsis', 'cover_image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function copies()
    {
        return $this->hasMany(BookCopy::class);
    }

    public function reservations()
    {
        return $this->hasMany(BookReservation::class);
    }

    public function reviews()
    {
        return $this->hasMany(BookReview::class);
    }
}
