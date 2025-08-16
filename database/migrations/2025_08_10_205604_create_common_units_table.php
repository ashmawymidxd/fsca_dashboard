<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommonUnitsTable extends Migration
{
    public function up()
    {
        Schema::create('common_units', function (Blueprint $table) {
            $table->id();
            $table->string('banner_image');
            $table->string('cover_image');
            $table->string('title_en');
            $table->string('title_ar');
            $table->text('description_en');
            $table->text('description_ar');
            $table->text('page_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('common_units');
    }
}
