<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'academic_year_id', 'semester_id', 'day', 'start_time', 'end_time', 'room', 'building'];

    protected function casts(): array
    {
        return ['start_time' => 'datetime:H:i', 'end_time' => 'datetime:H:i'];
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
