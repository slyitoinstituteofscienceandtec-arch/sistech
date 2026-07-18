<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('staff_id')->unique();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('position', ['lecturer', 'hod', 'registrar', 'accountant', 'admin', 'librarian', 'it_support', 'security', 'cleaner', 'other'])->default('lecturer');
            $table->enum('employment_type', ['full_time', 'part_time', 'contract', 'visiting'])->default('full_time');
            $table->date('hire_date');
            $table->decimal('salary', 12, 2)->nullable();
            $table->string('qualification')->nullable();
            $table->string('specialization')->nullable();
            $table->enum('status', ['active', 'inactive', 'on_leave', 'terminated'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
