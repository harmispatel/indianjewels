<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->unsignedBigInteger('metal_id')->nullable();
            $table->text('tags')->nullable();
            $table->string('code')->nullable();
            $table->text('image')->nullable();
            $table->text('video')->nullable();
            $table->tinyInteger('status')->default('1');
            $table->tinyInteger('highest_selling')->default('0');
            $table->text('description')->nullable();
            $table->float('gemstone_price',8,2)->nullable();
            $table->float('price',8,2)->nullable();
            $table->float('gweight1',8,2)->nullable();
            $table->float('gweight2',8,2)->nullable();
            $table->float('gweight3',8,2)->nullable();
            $table->float('gweight4',8,2)->nullable();
            $table->float('less_gems_stone',8,2)->nullable();
            $table->float('less_cz_stone',8,2)->nullable();
            $table->float('nweight1',8,2)->nullable();
            $table->float('nweight2',8,2)->nullable();
            $table->float('nweight3',8,2)->nullable();
            $table->float('nweight4',8,2)->nullable();
            $table->string('percentage')->nullable();
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
        Schema::dropIfExists('designs');
    }
}
