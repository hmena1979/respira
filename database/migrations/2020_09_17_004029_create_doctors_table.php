<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',50);
            $table->string('especialidad',30)->nullable();
            $table->string('cmp',10)->nullable();
            $table->string('rne',10)->nullable();
            $table->string('celular',10)->nullable();
            $table->string('telefono',10)-> nullable();
            $table->text('imagen')-> nullable();
            $table->text('firma')-> nullable();
            $table->integer('activo')->default(1);
            $table->string('codant',3)->nullable();
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
        Schema::dropIfExists('doctors');
    }
}
