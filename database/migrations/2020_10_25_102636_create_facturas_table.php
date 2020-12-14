<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
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
            $table->string('ruc',15);
            $table->string('direccion')->nullable();
            $table->string('direnvio')->nullable();
            $table->string('comprobante_id',2);
            $table->string('serie',4);
            $table->string('numero',8);
            $table->integer('doctor_id')->nullable();
            $table->integer('status')->default(1);
            $table->string('fpago_id',1)->default('1');
            $table->string('noperacion',10)->nullable();
            $table->decimal('tot_gravadas',12,2)->nullable();
            $table->decimal('tot_inafectas',12,2)->nullable();
            $table->decimal('tot_exoneradas',12,2)->nullable();
            $table->decimal('tot_gratuitas',12,2)->nullable();
            $table->decimal('tot_igv',12,2)->nullable();
            $table->decimal('tot_desc',12,2)->nullable();
            $table->decimal('total_clinica',12,2);
            $table->decimal('total_doctor',12,2)->nullable();
            $table->decimal('total',12,2);
            $table->integer('detraccion')->default(2);
            $table->string('detraccion_id',3)->nullable();
            $table->decimal('detraccion_por',12,2)->nullable();
            $table->decimal('detraccion_monto',12,2)->nullable();
            $table->text('observaciones')->nullable();
            $table->text('cdr')->nullable();
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
        Schema::dropIfExists('facturas');
    }
}
