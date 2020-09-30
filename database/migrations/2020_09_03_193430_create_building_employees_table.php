<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id');
            $table->string('name');
            $table->string('address');
            $table->string('position');
            $table->string('birth_place');
            $table->date('birth_date');
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
        Schema::dropIfExists('building_employees');
    }
}
