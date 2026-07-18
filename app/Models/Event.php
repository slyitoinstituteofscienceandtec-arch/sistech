<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'type', 'start_date', 'end_date', 'location', 'target', 'created_by', 'is_active'];

    protected function casts(): array
    {
        return ['start_date' => 'datetime', 'end_date' => 'datetime', 'is_active' => 'boolean'];
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
