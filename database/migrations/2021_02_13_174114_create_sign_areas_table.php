<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sign_areas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('width');
            $table->decimal('height');
            $table->decimal('elementTop');
            $table->decimal('elementLeft');
            $table->decimal('top');
            $table->decimal('left');
            $table->decimal('parentWidth');
            $table->decimal('parentHeight');
            $table->decimal('targetPage');
            $table->integer('signer_id');
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
        Schema::dropIfExists('sign_areas');
    }
}
