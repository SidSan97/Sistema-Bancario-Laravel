<?php

namespace App\Http\Controllers;

use App\Models\DadosBancarioModel;
use App\Models\ExtratoModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OperacoesBancariaController extends Controller
{
    public function depositar(Request $request)
    {
        $numeroConta = $request->num_conta;

        $dados = DadosBancarioModel::where('numero_conta', $numeroConta)->first();

        if ($dados == null) {
            return response()->json([
                "status"  => 204,
                "message" => "Nenhuma conta bancária foi encontrada"
            ], 204);
        }

        $dados->saldo += $request->valor_deposito;

        $dados->save();

        return response()->json([
            "status"  => 200,
            "message" => "Depósito feito com sucesso"
        ], 200);
    }

    public function transferencia(Request $request)
    {
        DB::beginTransaction();

        $usuario = DadosBancarioModel::join('dados_cadastro_cliente', 'dados_bancarios.id_cliente', '=', 'dados_cadastro_cliente.id')
        ->where('dados_bancarios.id_cliente', 2)
        ->first();

        $dados = $this->verificarDestinatario($request->num_conta_destinatario);

        if($dados == false) {
            return response()->json([
                "status"  => 204,
                "message" => "Nenhuma conta bancária foi encontrada"
            ], 204);
        }

        if(($usuario->saldo) < ($request->valor_transferencia)) {
            return response()->json([
                "status"  => 400,
                "message" => "Saldo insuficiente."
            ], 400);
        }

        $usuario->saldo = ($usuario->saldo - $request->valor_transferencia);
        $dados->saldo   = ($dados->saldo + $request->valor_transferencia);

        if(!$usuario->save() || !$dados->save()) {
            DB::rollBack();

            return response()->json([
                "status"  => 500,
                "message" => "Erro ao fazer transferência, tente novamente."
            ], 500);
        }

        //$this->InserirNoExtrato("Transferência", null, $usuario->nome, $dados->nome, $request->valor_transferencia, "saída", "TED", $usuario->id, $dados->id);

        DB::commit();
        return response()->json([
            "status"  => 200,
            "message" => "Transação efetuada com sucesso."
        ], 200);
    }

    public function verificarDestinatario(int $numeroConta)
    {
        $dados = DadosBancarioModel::join('dados_cadastro_cliente', 'dados_bancarios.id_cliente', '=', 'dados_cadastro_cliente.id')
                ->where('dados_bancarios.numero_conta', $numeroConta)
                ->first();

        if ($dados == null) {
            return false;
        }

        return $dados;
    }

    public function InserirNoExtrato(string $titulo,
                    string $msg = null,
                    string $nomeRem,
                    string $nomeDest,
                    float $valor,
                    string $movimentacao,
                    string $metodo,
                    int $idRem,
                    int $idDest
                )
    {
        $extrato = new ExtratoModel();

        $extrato->titulo = $titulo;
        $extrato->mensagem = $msg;
        $extrato->nome_remetente = $nomeRem;
        $extrato->nome_destinatario = $nomeDest;
        $extrato->valor = $valor;
        $extrato->movimentacao = $movimentacao;
        $extrato->metodo = $metodo;
        $extrato->id_remetente = $idRem;
        $extrato->id_destinatario = $idDest;

        $extrato->save();

        return;
    }
}
