<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['super_admin', 'principal', 'registrar', 'accountant', 'lecturer', 'student', 'parent', 'staff'])->default('student');
            $table->string('phone')->nullable()->after('email');
            $table->string('avatar')->nullable()->after('phone');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active')->after('role');
            $table->boolean('two_factor_enabled')->default(false)->after('status');
            $table->timestamp('last_login_at')->nullable()->after('two_factor_enabled');
            $table->string('campus')->nullable()->after('last_login_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'avatar', 'status', 'two_factor_enabled', 'last_login_at', 'campus']);
        });
    }
};
