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
        Schema::create('support_and_help_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('support_and_help_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index(); // 'en' or 'ar'
            $table->string('title');
            $table->text('description');
            $table->unique(['support_and_help_id', 'locale']);
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_and_help_translations');
    }
};
