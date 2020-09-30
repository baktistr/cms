<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingHelpDesksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_help_desks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('help_desk_category_id');
            $table->foreignId('building_id');
            $table->foreignId('help_desk_id');
            $table->string('title');
            $table->string('status');
            $table->text('message');
            $table->string('priority');
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
        Schema::dropIfExists('building_help_desks');
    }
}
