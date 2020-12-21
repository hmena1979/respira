<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetModrecetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('det_modrecetas', function (Blueprint $table) {
            $table->id();
            $table->integer('modreceta_id');
            $table->integer('producto_id')->nullable();
            $table->string('nombre');
            $table->integer('umedida_id')->nullable();
            $table->decimal('cantidad',12,4)->nullable();
            $table->string('posologia',10)->nullable();
            $table->string('posmed_id',2)->nullable();
            $table->string('posfrec_id',2)->nullable();
            $table->string('postie',5)->nullable();
            $table->string('postie_id',1)->nullable();
            $table->text('recomendacion')->nullable();
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
        Schema::dropIfExists('det_modrecetas');
    }
}
