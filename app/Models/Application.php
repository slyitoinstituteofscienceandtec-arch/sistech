<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_number', 'first_name', 'last_name', 'email', 'phone',
        'gender', 'date_of_birth', 'address', 'programme_id',
        'previous_school', 'qualification', 'guardian_name', 'guardian_phone',
        'status', 'reviewed_by', 'reviewed_at', 'review_notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'reviewed_at' => 'datetime',
    ];

    public function programme()
    {
        return $this->belongsTo(Programme::class);
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public static function generateNumber(): string
    {
        $year = date('Y');
        $last = self::where('application_number', 'like', "APP-{$year}-%")
            ->pluck('application_number')
            ->map(fn($n) => (int) str_replace("APP-{$year}-", '', $n))
            ->max() ?? 0;
        return 'APP-' . $year . '-' . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
    }
}
