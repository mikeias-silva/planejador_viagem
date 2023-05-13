<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rotas', function (Blueprint $table) {
            $table->id();
            $table->string('nome_trajeto');
            $table->date('data_viagem');
            $table->string('partida_nome');
            $table->string('partida_endereco');
            $table->string('partida_longitude');
            $table->string('partida_latitude');
            $table->string('destino_nome');
            $table->string('destino_endereco');
            $table->string('destino_longitude');
            $table->string('destino_latitude');
            $table->jsonb('waypoints')->nullable();
            $table->jsonb('itinerario')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rotas');
    }
};
