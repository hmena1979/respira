<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('params', function (Blueprint $table) {
            $table->id();
            $table->string('ruc', 11);
            $table->string('razsoc', 60);
            $table->string('usuario', 15)->default('MODDATOS');
            $table->string('clave', 15)->default('moddatos');
            $table->text('apitoken')->nullable();
            $table->text('servidor')->nullable();
            $table->text('dominio')->nullable();
            $table->string('cuenta')->nullable();
            $table->string('padmision', 6);
            $table->string('pfarmacia', 6);
            $table->string('ubigeo', 6);
            $table->string('direccion', 100);
            $table->string('urbanizacion', 25);
            $table->string('provincia', 30);
            $table->string('departamento', 30);
            $table->string('distrito', 30);
            $table->string('pais', 30)->default('PE');
            $table->decimal('por_igv',12,2)->default(18);
            $table->decimal('por_renta',12,2)->default(8);
            $table->decimal('monto_renta',12,2)->default(1500);
            $table->string('sadmision', 3);
            $table->string('sfarmacia', 3);
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
        Schema::dropIfExists('params');
    }
}
