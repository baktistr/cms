<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingProcurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_procurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('help_desk_category_id')->nullable();
            $table->foreignId('building_equipment_id')->nullable();
            $table->date('date_of_problem');
            $table->date('date_of_problem_fixed');
            $table->string('action');
            $table->string('title');
            $table->text('description');
            $table->float('cost', 12);
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
        Schema::dropIfExists('building_procurements');
    }
}
