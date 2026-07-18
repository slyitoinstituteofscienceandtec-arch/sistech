<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['payment_reference', 'invoice_id', 'student_id', 'amount', 'method', 'transaction_id', 'bank_name', 'account_number', 'receipt_path', 'status', 'notes', 'verified_by', 'verified_at'];

    protected function casts(): array
    {
        return ['amount' => 'decimal:2', 'verified_at' => 'datetime'];
    }

    public function getReferenceNumberAttribute()
    {
        return $this->payment_reference;
    }

    public function getPaymentDateAttribute()
    {
        return $this->created_at;
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public static function generateReference(): string
    {
        $year = date('Y');
        $last = self::whereYear('created_at', $year)->count() + 1;
        return 'PAY-' . $year . '-' . str_pad($last, 5, '0', STR_PAD_LEFT);
    }
}
