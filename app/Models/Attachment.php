<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'company_name', 'company_address', 'supervisor_name', 'supervisor_phone', 'department', 'start_date', 'end_date', 'status', 'description', 'stipend', 'report_path', 'evaluation'];

    protected function casts(): array
    {
        return ['start_date' => 'date', 'end_date' => 'date', 'stipend' => 'decimal:2'];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
