<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->foreignId('telkom_regional_id');
            $table->foreignId('witel_id');
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('regency_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable(); // @todo required?
            $table->string('name')->nullable();
            $table->text('address_detail');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('allotment')->nullable();
            $table->integer('surface_area')->nullable();
            $table->text('nka_sap')->nullable();
            $table->text('postal_code')->nullable();
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
        Schema::dropIfExists('location_codes');
    }
}
