<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'type', 'target', 'academic_year_id', 'created_by', 'is_active', 'publish_date'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'publish_date' => 'datetime'];
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('publish_date', '<=', now());
    }
}
