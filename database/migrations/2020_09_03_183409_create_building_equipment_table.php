<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id');
            $table->foreignId('building_equipment_category_id');
            $table->string('equipment_number');
            $table->string('equipment_name');
            $table->date('date_installation');
            $table->string('manufacture');
            $table->string('manufacture_model_number');
            $table->year('year_of_construction');
            $table->float('cost_center', 12);
            $table->text('location');
            $table->string('barcode_number');
            $table->string('additional_information')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('building_equipment');
    }
}
