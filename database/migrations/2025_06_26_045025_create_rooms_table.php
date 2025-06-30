<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Migratsiyalarni ishga tushirish.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('floor_id')->constrained('floors')->onDelete('cascade');
            $table->string('number')->nullable(); // '->change()' olib tashlandi, chunki bu yangi ustun yaratish
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true); // Default is active
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Migratsiyalarni qaytarish.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
