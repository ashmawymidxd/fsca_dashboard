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
        Schema::create('service_categories', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['category', 'banner']);
            $table->string('cover_image');
            $table->string('main_header_en');
            $table->string('main_header_ar');
            $table->string('sub_header_en')->nullable();
            $table->string('sub_header_ar')->nullable();
            $table->text('description_en');
            $table->text('description_ar');
            $table->string('focus_en')->nullable();
            $table->string('focus_ar')->nullable();
            $table->string('button_text_en')->nullable();
            $table->string('button_text_ar')->nullable();
            $table->string('slug_en');
            $table->string('slug_ar');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_categories');
    }
};
