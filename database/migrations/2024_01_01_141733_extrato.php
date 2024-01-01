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
        Schema::create('extrato', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 30);
            $table->string('mensagem', 100)->nullable();
            $table->string('nome_remetente', 50);
            $table->string('nome_destinatario', 50);
            $table->decimal('valor', 10, 2);
            $table->string('movimentacao', 20);
            $table->string('metodo', 50);
            $table->timestamps();
            $table->unsignedBigInteger('id_remetente');
            $table->unsignedBigInteger('id_destinatario');

            $table->foreign('id_remetente')->references('id')->on('dados_cadastro_cliente');
            $table->foreign('id_destinatario')->references('id')->on('dados_cadastro_cliente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extrato');
    }
};
