<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetingresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detingresos', function (Blueprint $table) {
            $table->id();
            $table->integer('ingreso_id');
            $table->integer('producto_id');
            $table->integer('afecto')->default(1);
            $table->integer('igv')->default(1);
            $table->decimal('pre_ini',10,2);
            $table->decimal('cantidad',10,2);
            $table->decimal('precio',10,2);
            $table->decimal('subtotal',10,2);
            $table->string('vence',10)->nullable();
            $table->string('lote',15)->nullable();
            $table->string('glosa');
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
        Schema::dropIfExists('detingresos');
    }
}
