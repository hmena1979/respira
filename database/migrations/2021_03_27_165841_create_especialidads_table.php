<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEspecialidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('especialidads', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->string('nom_corto', 30)->nullable();
            $table->string('icono', 100)->nullable();
            $table->text('imagen')->nullable();
            $table->text('contenido')->nullable();
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
        Schema::dropIfExists('especialidads');
    }
}
