<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetsalidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detsalidas', function (Blueprint $table) {
            $table->id();
            $table->integer('salida_id');
            $table->integer('producto_id');
            $table->decimal('cantidad',10,2);
            $table->decimal('preprom',10,2);
            $table->decimal('precio',10,2);
            $table->decimal('subtotal',10,2);
            $table->string('afectacion_id',2)->default('10');
            $table->string('vence',10)->nullable();
            $table->string('lote',15)->nullable();
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
        Schema::dropIfExists('detsalidas');
    }
}
