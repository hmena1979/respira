<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSedesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sedes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->string('lugar', 50)->nullable();
            $table->string('direccion', 50)->nullable();
            $table->string('referencia', 50)->nullable();
            $table->string('ciudad', 30)->nullable();
            $table->text('img_princ')->nullable();
            $table->text('img_sede')->nullable();
            $table->string('telef1', 30)->nullable();
            $table->string('telef2', 30)->nullable();
            $table->string('email', 100)->nullable();
            $table->text('ubicacion')->nullable();
            $table->integer('activo')->nullable();
            $table->integer('orden')->default(1);
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
        Schema::dropIfExists('sedes');
    }
}
