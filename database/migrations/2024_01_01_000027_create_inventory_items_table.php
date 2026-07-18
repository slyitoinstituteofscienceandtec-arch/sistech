<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('category', ['computer', 'furniture', 'projector', 'printer', 'networking', 'laboratory', 'office_supplies', 'other']);
            $table->integer('quantity')->default(0);
            $table->integer('available')->default(0);
            $table->decimal('unit_cost', 12, 2)->nullable();
            $table->string('location')->nullable();
            $table->string('condition', 20)->default('good');
            $table->date('purchase_date')->nullable();
            $table->string('supplier')->nullable();
            $table->string('serial_number')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
