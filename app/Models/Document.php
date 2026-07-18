<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'type', 'title', 'file_path', 'file_type', 'file_size'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
