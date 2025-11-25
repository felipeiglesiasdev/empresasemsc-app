<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CnpjController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MunicipioController; 
use App\Http\Controllers\CepController; 

Route::get('/', [HomeController::class, 'home'])->name('home');


//########################################################################################################################
//########################################################################################################################
// --- ROTAS DE CONSULTA DE CNPJ ---
Route::post('/consultar-cnpj', [CnpjController::class, 'consultar'])->name('cnpj.consultar');                           // ROTA PARA PROCESSAR O FORMULÁRIO DE CONSULTA
Route::get('/cnpj/{cnpj}', [CnpjController::class, 'show'])->name('cnpj.show');               
//########################################################################################################################
//########################################################################################################################
// --- ROTAS DOS MUNICIPIOS ---
Route::get('/municipios', [MunicipioController::class, 'index'])->name('municipios.index');
// NOVA ROTA LIMPA: Apenas o slug da cidade (ex: /municipios/florianopolis)
Route::get('/municipios/{slug}', [MunicipioController::class, 'show'])->name('municipios.show');
//########################################################################################################################
//########################################################################################################################
// --- ROTAS DE CEP ---
Route::get('/ceps', [CepController::class, 'index'])->name('ceps.index');
Route::get('/ceps/{cep}', [CepController::class, 'show'])->where('cep', '\d{5}-?\d{3}')->name('ceps.show');