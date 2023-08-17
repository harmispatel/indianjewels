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
            $table->string('company')->nullable();
            $table->string('tags')->nullable();
            $table->string('code')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('status')->default('1');
            $table->tinyInteger('is_flash')->default('0');
            $table->tinyInteger('highest_selling')->default('0');
            $table->text('description')->nullable();
            $table->float('price',8,2)->nullable();
            $table->float('weight1',8,2)->nullable();
            $table->float('weight2',8,2)->nullable();
            $table->float('weight3',8,2)->nullable();
            $table->float('weight4',8,2)->nullable();
            $table->float('gweight1',8,2)->nullable();
            $table->float('gweight2',8,2)->nullable();
            $table->float('gweight3',8,2)->nullable();
            $table->float('gweight4',8,2)->nullable();
            $table->float('wastage1',8,2)->nullable();
            $table->float('wastage2',8,2)->nullable();
            $table->float('wastage3',8,2)->nullable();
            $table->float('wastage4',8,2)->nullable();
            $table->float('iaj_weight',8,2)->nullable();
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
