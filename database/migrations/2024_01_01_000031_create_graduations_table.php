<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('graduations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_year_id')->constrained()->cascadeOnDelete();
            $table->string('graduation_date');
            $table->string('certificate_number')->unique()->nullable();
            $table->string('class_position')->nullable();
            $table->enum('class_of_degree', ['first_class', 'second_class_upper', 'second_class_lower', 'third_class', 'pass', 'distinction', 'merit', 'pass_merit'])->nullable();
            $table->decimal('final_cpa', 4, 2)->nullable();
            $table->enum('status', ['pending', 'approved', 'certified'])->default('pending');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('graduations');
    }
};
