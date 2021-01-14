<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('historia', 5)->nullable();
            $table->integer('tipo')->default(1);
            $table->string('tipdoc_id',1);
            $table->string('numdoc', 15);
            $table->string('ape_pat', 30)->nullable();
            $table->string('ape_mat', 30)->nullable();
            $table->string('nombre1', 30)->nullable();
            $table->string('nombre2', 30)->nullable();
            $table->string('razsoc');
            $table->date('fecnac')->nullable();
            $table->date('fecing')->nullable();
            $table->string('sexo_id',1)->nullable();
            $table->string('estciv_id',1)->nullable();
            $table->string('ocupacion', 40)->nullable();
            $table->string('lorigen', 40)->nullable();
            $table->string('lresidencia', 40)->nullable();
            $table->string('responsable', 50)->nullable();
            $table->string('direccion', 150)->nullable();
            $table->string('telefono', 40)->nullable();
            $table->string('email', 60)->nullable();            
            $table->text('antecedentes')->nullable();
            $table->text('alergia')->nullable();
            $table->string('tie_enfer', 80)->nullable();
            $table->string('tenfact', 80)->nullable();
            $table->integer('doctor_id')->nullable();
            $table->string('tippac_id',1)->nullable();
            $table->string('codant', 15)->nullable();  
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
        Schema::dropIfExists('pacientes');
    }
}
