<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';
    protected $fillable = [
        'user_id', 'staff_id', 'department_id', 'position', 'employment_type',
        'hire_date', 'salary', 'qualification', 'specialization', 'status',
    ];

    protected function casts(): array
    {
        return [
            'hire_date' => 'date',
            'salary' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function courses()
    {
        return $this->hasManyThrough(Course::class, User::class, 'id', 'lecturer_id', 'user_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeLecturers($query)
    {
        return $query->where('position', 'lecturer');
    }
}
