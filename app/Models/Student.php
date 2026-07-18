<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'student_id', 'index_number', 'programme_id', 'department_id',
        'academic_year_id', 'status', 'level', 'semester', 'admission_date',
        'date_of_birth', 'gender', 'address', 'national_id',
        'guardian_name', 'guardian_phone', 'guardian_email', 'relationship',
        'photo', 'previous_school', 'qualification',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function programme()
    {
        return $this->belongsTo(Programme::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function courseRegistrations()
    {
        return $this->hasMany(CourseRegistration::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function parents()
    {
        return $this->belongsToMany(ParentModel::class, 'student_parent', 'student_id', 'parent_id');
    }

    public function graduations()
    {
        return $this->hasMany(Graduation::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function bookBorrowings()
    {
        return $this->hasMany(BookBorrowing::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
