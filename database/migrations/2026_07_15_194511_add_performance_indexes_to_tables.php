<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->index('role');
            $table->index('status');
        });

        Schema::table('academic_years', function (Blueprint $table) {
            $table->index('is_current');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->index('status');
            $table->index('created_at');
        });

        Schema::table('staff', function (Blueprint $table) {
            $table->index('status');
            $table->index('position');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->index('status');
            $table->index('due_date');
            $table->index(['status', 'due_date']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->index('status');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->index(['user_id', 'is_read']);
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->index(['is_active', 'publish_date']);
        });

        Schema::table('enquiries', function (Blueprint $table) {
            $table->index('status');
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->index('status');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->index('is_active');
            $table->index('lecturer_id');
        });

        Schema::table('programmes', function (Blueprint $table) {
            $table->index('is_active');
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->index('is_active');
        });

        Schema::table('gallery_items', function (Blueprint $table) {
            $table->index('is_active');
            $table->index('category');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->index('date');
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->index('category');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropIndex(['status']);
        });

        Schema::table('academic_years', function (Blueprint $table) {
            $table->dropIndex(['is_current']);
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('staff', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['position']);
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['due_date']);
            $table->dropIndex(['status', 'due_date']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'is_read']);
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'publish_date']);
        });

        Schema::table('enquiries', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropIndex(['lecturer_id']);
        });

        Schema::table('programmes', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });

        Schema::table('gallery_items', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropIndex(['category']);
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropIndex(['date']);
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->dropIndex(['category']);
        });
    }
};
