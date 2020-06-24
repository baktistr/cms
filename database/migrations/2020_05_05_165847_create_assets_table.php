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
            $table->foreignId('asset_category_id');
            $table->foreignId('telkom_regional_id')->nullable(); // @todo required?
            $table->foreignId('witel_id')->nullable(); // @todo required?
            $table->foreignId('admin_id');
            $table->string('name')->index();
            $table->text('description');
            $table->text('address_detail');
            $table->string('location_code'); //@todo unique?
            $table->string('building_code')->nullable(); //@todo unique?
            $table->text('allotment')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->unsignedBigInteger('province_id')->nullable(); // @todo required?
            $table->unsignedBigInteger('regency_id')->nullable(); // @todo required?
            $table->unsignedBigInteger('district_id')->nullable(); // @todo required?
            $table->string('phone_number')->nullable();
            $table->string('type');
            $table->float('unit_area', 8, 2)->nullable();
            $table->float('price', 12, 2)->nullable();
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
