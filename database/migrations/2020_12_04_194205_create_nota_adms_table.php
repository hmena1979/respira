<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaAdmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_adms', function (Blueprint $table) {
            $table->id();
            $table->string('periodo',6);
            $table->date('fecha');
            $table->time('hora');
            $table->string('moneda',3)->default('PEN');
            $table->decimal('tc',10,3)->nullable();
            $table->string('ruc',15);
            $table->string('direccion')->nullable();
            $table->string('comprobante_id',6);
            $table->string('serie',4);
            $table->string('numero',8);

            $table->integer('dmid')->nullable();
            $table->string('dmcomprobante_id',2);
            $table->string('dmserie',4);
            $table->string('dmnumero',8);
            $table->date('dmfecha')->nullable();
            $table->string('dmtipo_id',2);
            $table->string('dmdescripcion');

            $table->string('fpago_id',1)->default('1');
            $table->string('noperacion',10)->nullable();
            $table->decimal('tot_gravadas',12,2)->nullable();
            $table->decimal('tot_inafectas',12,2)->nullable();
            $table->decimal('tot_exoneradas',12,2)->nullable();
            $table->decimal('tot_gratuitas',12,2)->nullable();
            $table->decimal('tot_igv',12,2)->nullable();
            $table->decimal('tot_desc',12,2)->nullable();
            $table->decimal('total',12,2);
            $table->integer('status')->default(1);
            $table->text('observaciones')->nullable();
            $table->text('cdr')->nullable();
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
        Schema::dropIfExists('nota_adms');
    }
}
