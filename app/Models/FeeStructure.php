<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeStructure extends Model
{
    use HasFactory;

    protected $fillable = ['programme_id', 'academic_year_id', 'description', 'amount', 'level', 'semester', 'is_mandatory'];

    protected function casts(): array
    {
        return ['amount' => 'decimal:2', 'is_mandatory' => 'boolean'];
    }

    public function programme()
    {
        return $this->belongsTo(Programme::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
