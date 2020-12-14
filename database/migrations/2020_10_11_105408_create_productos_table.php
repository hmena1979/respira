<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('codant', 7)->nullable();
            $table->integer('tipmed_id')->nullable();
            $table->integer('composicion_id')->nullable();
            $table->integer('umedida_id')->nullable();
            $table->decimal('stock',12,4)->nullable();
            $table->decimal('stockmin',12,4)->nullable();
            $table->decimal('precompra',12,4)->nullable();
            $table->integer('afecto')->default(1)->nullable();
            $table->integer('laboratorio_id')->nullable();
            $table->decimal('premerca',10,2)->nullable();
            $table->decimal('porganancia',10,2)->nullable();
            $table->string('minsa', 15)->nullable();
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
        Schema::dropIfExists('productos');
    }
}
