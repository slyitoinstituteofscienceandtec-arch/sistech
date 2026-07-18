<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_number', 'student_id', 'academic_year_id', 'description', 'amount', 'paid_amount', 'balance', 'due_date', 'status', 'notes'];

    protected function casts(): array
    {
        return ['amount' => 'decimal:2', 'paid_amount' => 'decimal:2', 'balance' => 'decimal:2', 'due_date' => 'date'];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public static function generateNumber(): string
    {
        $year = date('Y');
        $last = self::whereYear('created_at', $year)->count() + 1;
        return 'INV-' . $year . '-' . str_pad($last, 5, '0', STR_PAD_LEFT);
    }
}
