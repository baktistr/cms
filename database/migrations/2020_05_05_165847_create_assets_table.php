<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_category_id');
            $table->unsignedBigInteger('admin_id');
            $table->string('name')->index();
            $table->unsignedBigInteger('province_id');
            $table->unsignedBigInteger('regency_id');
            $table->unsignedBigInteger('district_id');
            $table->text('address_detail');
            $table->string('phone_number')->nullable();
            $table->float('unit_area', 8, 2)->nullable();
            $table->float('value', 12, 2)->nullable();
            $table->float('price', 12, 2)->nullable();
            $table->string('price_type')->nullable();
            $table->integer('number_of_floors')->nullable();
            $table->boolean('is_available')->default(false);
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
        Schema::dropIfExists('assets');
    }
}
