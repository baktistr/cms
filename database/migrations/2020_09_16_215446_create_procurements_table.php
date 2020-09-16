<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_equipment_id');
            $table->foreignId('help_desk_category_id');
            $table->date('date_of_problem');
            $table->date('date_of_problem_fixed');
            $table->string('title');
            $table->text('message');
            $table->float('cost', 12);
            $table->text('additional_information')->nullable();
            $table->string('action');
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
        Schema::dropIfExists('procurements');
    }
}
