<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'description', 'head_of_department_id', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function head()
    {
        return $this->belongsTo(User::class, 'head_of_department_id');
    }

    public function programmes()
    {
        return $this->hasMany(Programme::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
