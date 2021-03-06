<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActividadesInternasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividades_internas', function (Blueprint $table) {
            
            $table->bigInteger('actividad_id')->unsigned()->primary();
            $table->foreign('actividad_id')->references('id')->on('actividades')->onDelete('cascade');
            $table->string('tipo_actividad', 45)->nullable();
            $table->string('proposito', 45)->nullable();
            $table->longText('agenda')->nullable();
            $table->string('ambito', 45)->nullable();
            $table->string('certificacion_actividad', 100)->nullable();
            $table->string('publico_dirigido', 45)->nullable();
            $table->string('recursos', 200)->nullable();
            $table->string('facilitador_externo', 90)->nullable();
            $table->string('personal_facilitador', 90)->nullable();
            $table->foreign('personal_facilitador')->references('persona_id')->on('personas');
            $table->timestamps();
            
            //Creacion de índices
            $table->index('personal_facilitador');
            $table->index('tipo_actividad');
            $table->index('proposito');
            $table->index('ambito');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actividades_internas');
    }
}
