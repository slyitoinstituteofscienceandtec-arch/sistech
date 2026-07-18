<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'category', 'quantity', 'available', 'unit_cost', 'location', 'condition', 'purchase_date', 'supplier', 'serial_number', 'notes', 'is_active'];

    protected function casts(): array
    {
        return ['purchase_date' => 'date', 'unit_cost' => 'decimal:2', 'is_active' => 'boolean'];
    }
}
