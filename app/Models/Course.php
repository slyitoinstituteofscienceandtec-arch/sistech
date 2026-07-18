<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'department_id', 'programme_id', 'credit_units', 'semester', 'level', 'lecturer_id', 'description', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function programme()
    {
        return $this->belongsTo(Programme::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    public function registrations()
    {
        return $this->hasMany(CourseRegistration::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function examinations()
    {
        return $this->hasMany(Examination::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function timetables()
    {
        return $this->hasMany(Timetable::class);
    }
}
