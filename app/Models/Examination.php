<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examination extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'academic_year_id', 'semester_id', 'type', 'title', 'total_marks', 'weight', 'date', 'start_time', 'end_time', 'room', 'instructions'];

    protected function casts(): array
    {
        return ['date' => 'date'];
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
