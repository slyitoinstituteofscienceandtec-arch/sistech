<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fee_structures', function (Blueprint $table) {
            $table->dropColumn('fee_type');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('fee_type');
        });
    }

    public function down(): void
    {
        Schema::table('fee_structures', function (Blueprint $table) {
            $table->json('fee_type')->after('academic_year_id');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->string('fee_type')->default('tuition')->after('academic_year_id');
        });
    }
};
