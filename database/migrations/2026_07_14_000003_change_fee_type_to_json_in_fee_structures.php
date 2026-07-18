<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // fee_type is already a string from the create migration
        // This migration is now a no-op for PostgreSQL compatibility
    }

    public function down(): void
    {
        // No-op
    }
};
