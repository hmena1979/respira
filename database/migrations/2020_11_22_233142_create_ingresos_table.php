<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos', function (Blueprint $table) {
            $table->id();
            $table->string('periodo',6);
            $table->integer('tipo')->default(1);
            $table->string('dias',3)->nullable();
            $table->date('fecha');
            $table->date('vencimiento')->nullable();
            $table->date('cancelacion')->nullable();
            $table->string('moneda',3)->default('PEN');
            $table->decimal('tc',10,3)->nullable();
            $table->string('comprobante_id',2);
            $table->string('serie',4);
            $table->string('numero',8);
            $table->string('proveedor_id',15);
            $table->decimal('subtotal',12,2)->nullable();
            $table->decimal('igv',12,2)->nullable();
            $table->decimal('total',12,2)->nullable();
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
        Schema::dropIfExists('ingresos');
    }
}
