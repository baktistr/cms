<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id');
            $table->string('tenant');
            $table->string('floor');
            $table->string('object_rent'); // is Options have value A : Tanah / Lahan b: Tanah Gedung
            $table->string('allotment');
            $table->string('name_contract_gsd');
            $table->string('number_and_date');
            $table->string('status_contract_make'); //  is options kontrak terpusat / kontrak area
            $table->string('phisycal_check_contract');
            $table->date('period_start');
            $table->date('period_end');
            $table->integer('duration');
            $table->string('area');
            $table->float('price' , 15);
            $table->float('service_price', 15);
            $table->text('status_contract_desc')->nullable();
            $table->text('company_status')->nullable(); // is A Options
            $table->text('contract_desc')->nullable();
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
        Schema::dropIfExists('tenants');
    }
}
