<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id')->nullable(); //@todo unique?
            $table->foreignId('pic_id')->nullable();
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->string('building_code')->nullable(); //@todo unique?
            $table->text('allotment')->nullable();
            $table->string('phone_number')->nullable();
            $table->integer('surface_area')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
}
