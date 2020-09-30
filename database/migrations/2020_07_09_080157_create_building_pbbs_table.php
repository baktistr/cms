<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingPbbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_pbbs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id');
            $table->string('location_code');
            $table->string('object_name');
            $table->string('address');
            $table->string('nop');
            $table->float('njop_land_per_meter', 12);
            $table->float('njop_building_per_meter', 12);
            $table->float('pbb_paid', 12);
            $table->string('surface_area');
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
        Schema::dropIfExists('building_pbbs');
    }
}
