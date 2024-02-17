<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CadastroClienteController;
use App\Http\Controllers\OperacoesBancariaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('criar-conta', [CadastroClienteController::class, 'cadastro'])->name('criar-conta');
Route::post('depositar', [OperacoesBancariaController::class, 'depositar']);
Route::post('transferencia', [OperacoesBancariaController::class, 'transferencia']);
Route::get('saldo', [OperacoesBancariaController::class, 'getSaldo']);

//JWT
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'
  
], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});
