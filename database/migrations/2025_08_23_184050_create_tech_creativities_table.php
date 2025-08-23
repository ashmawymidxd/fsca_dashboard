<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tech_creativities', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['banner','category'])->default('banner'); // NEW
            $table->enum('image_direction', ['left','right','center'])->default('center'); // NEW
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();
            $table->longText('description_en')->nullable();
            $table->longText('description_ar')->nullable();
            $table->string('cover_image')->nullable();
            $table->unsignedInteger('order')->default(1)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tech_creativities');
    }
};
