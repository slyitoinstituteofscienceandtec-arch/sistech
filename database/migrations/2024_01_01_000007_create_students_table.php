<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('student_id')->unique();
            $table->string('index_number')->unique();
            $table->foreignId('programme_id')->constrained()->cascadeOnDelete();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_year_id')->nullable()->constrained()->nullOnDelete();
            $table->string('status')->default('active');
            $table->integer('level')->default(100);
            $table->integer('semester')->default(1);
            $table->date('admission_date');
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->text('address')->nullable();
            $table->string('national_id')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_phone')->nullable();
            $table->string('guardian_email')->nullable();
            $table->string('relationship')->nullable();
            $table->string('photo')->nullable();
            $table->string('previous_school')->nullable();
            $table->string('qualification')->nullable();
            $table->timestamps();

            $table->index(['programme_id', 'department_id']);
            $table->index(['level', 'semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
