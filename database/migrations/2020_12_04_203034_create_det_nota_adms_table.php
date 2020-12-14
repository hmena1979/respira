<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetNotaAdmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('det_nota_adms', function (Blueprint $table) {
            $table->id();
            $table->integer('notaadm_id');
            $table->text('servicio');
            $table->decimal('cantidad',10,2);
            $table->decimal('precio',10,2);
            $table->decimal('subtotal',10,2);
            $table->string('afectacion_id',2)->default('10');
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
        Schema::dropIfExists('det_nota_adms');
    }
}
