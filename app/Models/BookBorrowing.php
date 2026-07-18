<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookBorrowing extends Model
{
    use HasFactory;

    protected $fillable = ['book_id', 'student_id', 'borrow_date', 'due_date', 'return_date', 'fine', 'status', 'remarks'];

    protected function casts(): array
    {
        return ['borrow_date' => 'date', 'due_date' => 'date', 'return_date' => 'date', 'fine' => 'decimal:2'];
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
