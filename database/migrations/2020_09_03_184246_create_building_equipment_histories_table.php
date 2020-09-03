<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingEquipmentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_equipment_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_equipment_id');
            $table->date('date_of_problem');
            $table->string('action');
            $table->text('problem');
            $table->date('date_of_problem_fixed');
            $table->float('cost', 12);
            $table->text('additional_information')->nullable();
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
        Schema::dropIfExists('building_equipment_histories');
    }
}
