<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('precio',10,2)->nullable();
            $table->decimal('clinica',10,2)->nullable();
            $table->decimal('especialista',10,2)->nullable();
            $table->string('codant',5)->nullable();
            $table->softDeletes();
            $table->timestamps();
            //'nombre','precio','clinica','especialista','codant'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicios');
    }
}
