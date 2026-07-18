<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['isbn', 'title', 'author', 'publisher', 'category', 'edition', 'quantity', 'available', 'shelf_location', 'barcode', 'description', 'cover_image', 'pdf_file', 'price', 'is_active'];

    public function borrowings()
    {
        return $this->hasMany(BookBorrowing::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('available', '>', 0);
    }
}
