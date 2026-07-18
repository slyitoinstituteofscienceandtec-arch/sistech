<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fee_structures', function (Blueprint $table) {
            $table->json('fee_type')->change();
        });
    }

    public function down(): void
    {
        Schema::table('fee_structures', function (Blueprint $table) {
            $table->enum('fee_type', ['admission', 'tuition', 'examination', 'library', 'graduation', 'hostel', 'medical', 'ca', 'other'])->change();
        });
    }
};
