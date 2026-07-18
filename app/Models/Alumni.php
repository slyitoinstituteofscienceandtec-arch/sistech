<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'student_id', 'name', 'email', 'phone', 'programme_id', 'graduation_year', 'current_employer', 'current_position', 'skills', 'willing_to_mentor', 'total_donations', 'is_active'];

    protected function casts(): array
    {
        return ['willing_to_mentor' => 'boolean', 'total_donations' => 'decimal:2', 'is_active' => 'boolean'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function programme()
    {
        return $this->belongsTo(Programme::class);
    }
}
