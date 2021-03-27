<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTerapiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terapias', function (Blueprint $table) {
            $table->id();
            $table->integer('paciente_id');
            $table->string('diagnostico',100)->nullable();
            $table->integer('hospitalizacion')->default(2);
            $table->string('hospfech',20)->nullable();
            $table->string('hosplugar',100)->nullable();
            $table->string('hospalta',20)->nullable();
            $table->date('fechaeval')->nullable();
            $table->string('altura',10)->nullable();
            $table->string('peso',10)->nullable();
            $table->string('pesoglosa',50)->nullable();
            $table->integer('fumador')->default(2);
            $table->string('fumcese',100)->nullable();
            $table->string('spo2',10)->nullable();
            $table->string('fc',10)->nullable();
            $table->string('resxmin',10)->nullable();
            $table->string('pa',10)->nullable();
            $table->string('ocupacion',100)->nullable();
            $table->string('enfpersistente',100)->nullable();
            $table->string('hta',100)->nullable();
            $table->string('dbt',100)->nullable();
            $table->string('colytri',100)->nullable();
            $table->string('dolart',100)->nullable();
            $table->string('dolmusc',100)->nullable();
            $table->string('cirujias',100)->nullable();
            $table->string('osteoporosis',100)->nullable();
            $table->text('motivo')->nullable();
            $table->string('tos',20)->nullable();
            $table->string('espectoracion',20)->nullable();
            $table->string('sagita',100)->nullable();
            $table->string('muscresp',100)->nullable();
            $table->string('musccuello',100)->nullable();
            $table->string('muscabdom',100)->nullable();
            $table->string('capresp',100)->nullable();
            $table->string('efisglosa',100)->nullable();
            $table->string('emtono',50)->nullable();
            $table->string('emfuerza',50)->nullable();
            $table->text('objetivos')->nullable();            

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
        Schema::dropIfExists('terapias');
    }
}
