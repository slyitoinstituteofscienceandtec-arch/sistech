<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BedAllocation extends Model
{
    use HasFactory;

    protected $fillable = ['room_id', 'student_id', 'academic_year_id', 'allocation_date', 'release_date', 'status'];

    protected function casts(): array
    {
        return ['allocation_date' => 'date', 'release_date' => 'date'];
    }

    public function room()
    {
        return $this->belongsTo(HostelRoom::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
