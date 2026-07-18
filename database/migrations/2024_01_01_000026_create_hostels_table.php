<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hostels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('gender', ['male', 'female', 'mixed']);
            $table->integer('total_rooms')->default(0);
            $table->integer('total_beds')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('hostel_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hostel_id')->constrained()->cascadeOnDelete();
            $table->string('room_number');
            $table->enum('type', ['single', 'double', 'triple', 'shared'])->default('double');
            $table->integer('capacity')->default(2);
            $table->decimal('fee_per_semester', 10, 2)->nullable();
            $table->enum('status', ['available', 'occupied', 'maintenance'])->default('available');
            $table->timestamps();

            $table->unique(['hostel_id', 'room_number']);
        });

        Schema::create('bed_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('hostel_rooms')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_year_id')->constrained()->cascadeOnDelete();
            $table->date('allocation_date');
            $table->date('release_date')->nullable();
            $table->enum('status', ['active', 'released'])->default('active');
            $table->timestamps();

            $table->unique(['room_id', 'student_id', 'academic_year_id'], 'bed_alloc_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bed_allocations');
        Schema::dropIfExists('hostel_rooms');
        Schema::dropIfExists('hostels');
    }
};
