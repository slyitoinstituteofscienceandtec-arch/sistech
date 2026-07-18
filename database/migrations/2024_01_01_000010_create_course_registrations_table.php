<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_year_id')->constrained()->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['registered', 'dropped', 'completed'])->default('registered');
            $table->timestamps();

            $table->unique(['student_id', 'course_id', 'academic_year_id', 'semester_id'], 'cr_unique_reg');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_registrations');
    }
};
