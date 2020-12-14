<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historias', function (Blueprint $table) {
            $table->id();
            $table->integer('paciente_id');
            $table->integer('doctor_id')->nullable();
            $table->string('item', 3)->nullable();
            $table->string('tipo', 1)->default('1');
            $table->string('tippac_id',1)->nullable();
            $table->date('fecha');
            $table->time('hora')->nullable();
            $table->string('peso', 5)->nullable();
            $table->string('talla', 5)->nullable();
            $table->string('fc', 10)->nullable();
            $table->string('fr', 10)->nullable();
            $table->string('sato2', 10)->nullable();
            $table->string('pa', 10)->nullable();
            $table->string('temp', 5)->nullable();
            $table->text('anammesis')->nullable();
            $table->text('evolucion')->nullable();
            $table->text('antecedentes')->nullable();
            $table->text('exafisico')->nullable();
            $table->text('plantera')->nullable();
            $table->text('radtorax')->nullable();
            $table->text('tomografia')->nullable();
            $table->text('espirometria')->nullable();
            $table->text('anotaciones')->nullable();
            $table->integer('status')->default(1);
            $table->text('receta')->nullable();
            $table->string('ptipo', 1)->nullable();
            $table->date('pfecha')->nullable();
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
        Schema::dropIfExists('historias');
    }
}
