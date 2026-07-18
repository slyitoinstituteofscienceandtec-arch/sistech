<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'percentage', 'amount', 'type', 'is_active'];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_scholarships')
            ->withPivot(['amount_awarded', 'start_date', 'end_date', 'status'])
            ->withTimestamps();
    }
}
