<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingDailyElectricityConsumptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_daily_electricity_consumptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_electricity_consumption_id');
            $table->foreignId('building_electricity_meter_id');
            $table->bigInteger('electric_meter');
            $table->bigInteger('lwbp');
            $table->float('lwbp_rate');
            $table->bigInteger('wbp');
            $table->float('wbp_rate');
            $table->bigInteger('kvar')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('building_daily_electricity_consumptions');
    }
}
