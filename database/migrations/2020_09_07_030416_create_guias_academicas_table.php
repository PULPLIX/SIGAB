<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuiasAcademicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guias_academicas', function (Blueprint $table) {
            $table->id();
            $table->string('persona_id', 15);
            $table->foreign('persona_id')->references('persona_id')->on('personas')->onDelete('cascade'); /* falta->onDelete('cascade'); */
            $table->string('tipo');
            $table->string('solicitud', 15);
            $table->date('fecha');
            $table->string('ciclo_lectivo', 45);
            $table->longText('situacion');
            $table->string('lugar_atencion', 45);
            $table->longText('recomendaciones')->nullable();
            $table->string('archivo_adjunto')->nullable();
            $table->timestamps();
            //Creacion de índices
            $table->index('fecha');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guias_academicas');
    }
}
