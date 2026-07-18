<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_year_id')->constrained()->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained()->cascadeOnDelete();
            $table->decimal('ca_score', 6, 2)->nullable();
            $table->decimal('exam_score', 6, 2)->nullable();
            $table->decimal('total_score', 6, 2)->nullable();
            $table->string('grade', 2)->nullable();
            $table->decimal('grade_point', 4, 2)->nullable();
            $table->decimal('credit_unit', 4, 2)->nullable();
            $table->decimal('quality_point', 8, 2)->nullable();
            $table->string('remark')->nullable();
            $table->string('status')->default('pending');
            $table->foreignId('entered_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['student_id', 'course_id', 'academic_year_id', 'semester_id'], 'res_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
