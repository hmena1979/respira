<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetfacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detfacturas', function (Blueprint $table) {
            $table->id();
            $table->integer('factura_id');
            $table->text('servicio');
            $table->decimal('cantidad',10,2);
            $table->decimal('precio',10,2);
            $table->decimal('subtotal',10,2);
            $table->string('afectacion_id',2)->default('10');
            $table->decimal('precli',10,2);
            $table->decimal('stcli',10,2);
            $table->decimal('predr',10,2);
            $table->decimal('stdr',10,2);
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
        Schema::dropIfExists('detfacturas');
    }
}
