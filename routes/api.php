<?php
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

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
