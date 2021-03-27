<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetterapiaeval2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detterapiaeval2s', function (Blueprint $table) {
            $table->id();
            $table->integer('terapia_id');
            $table->string('t',10)->nullable();
            $table->string('v',10)->nullable();
            $table->string('sao2',10)->nullable();
            $table->string('fc',10)->nullable();
            $table->string('actividad',150)->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('detterapiaeval2s');
    }
}
