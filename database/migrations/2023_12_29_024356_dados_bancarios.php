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
        Schema::create('dados_bancarios', function (Blueprint $table) {
            $table->id('id_dados');
            $table->unsignedBigInteger('id_cliente'); // Chave estrangeira
            $table->string('email')->unique();
            $table->string('senha');
            $table->string('agencia', 4);
            $table->string('numero_conta', 6)->unique();
            $table->decimal('saldo', 10, 2);
            $table->timestamp('ultimo_acesso')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // Definir a chave estrangeira
            $table->foreign('id_cliente')->references('id')->on('dados_cadastro_cliente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login');
    }
};
