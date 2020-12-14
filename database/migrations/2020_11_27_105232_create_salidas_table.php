<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salidas', function (Blueprint $table) {
            $table->id();
            $table->string('periodo',6);
            $table->integer('tipo')->default(1);
            $table->string('dias',3)->nullable();
            $table->date('fecha');
            $table->time('hora');
            $table->date('vencimiento')->nullable();
            $table->date('cancelacion')->nullable();
            $table->string('moneda',3)->default('PEN');
            $table->decimal('tc',10,3)->nullable();
            $table->integer('tipsal')->default(1);//(1)Venta (2) Consumo
            $table->string('ruc',15);
            $table->string('direccion')->nullable();
            $table->integer('guia')->default(2);
            $table->string('tdguia')->default('09');
            $table->string('numguia')->nullable();
            $table->string('comprobante_id',2);
            $table->string('serie',4);
            $table->string('numero',8);
            $table->integer('status')->default(1);
            $table->string('fpago_id',1)->default('1');
            $table->string('noperacion',10)->nullable();
            $table->decimal('tot_gravadas',12,2)->nullable();
            $table->decimal('tot_inafectas',12,2)->nullable();
            $table->decimal('tot_exoneradas',12,2)->nullable();
            $table->decimal('tot_gratuitas',12,2)->nullable();
            $table->decimal('tot_igv',12,2)->nullable();
            $table->decimal('tot_desc',12,2)->nullable();
            $table->decimal('total',12,2)->default(0.00);
            $table->text('cdr')->nullable();
            $table->text('observaciones')->nullable();
            $table->integer('anulado')->default(2);
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
        Schema::dropIfExists('salidas');
    }
}
