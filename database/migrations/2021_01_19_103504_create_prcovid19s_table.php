<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrcovid19sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prcovid19s', function (Blueprint $table) {
            $table->id();
            
            $table->softDeletes();
            $table->string('periodo',6);
            $table->date('fecha');
            $table->integer('paciente_id')->nullable();
            $table->integer('igm')->default(1);
            $table->integer('igg')->default(1);
            $table->string('marca',50)->nullable();
            $table->string('lote',15)->nullable();
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
        Schema::dropIfExists('prcovid19s');
    }
}
