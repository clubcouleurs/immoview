<?php

use App\Http\Controllers\EtiquetteController;
use App\Http\Controllers\ImmeubleController;
use App\Http\Controllers\LotController;
use App\Http\Controllers\TrancheController;
use App\Http\Controllers\VoieController;
use App\Models\Etiquette;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/moi', function () {
	dd(App::getLocale() ) ;
    return view('dashboard');
});

Route::middleware('auth')->group(function(){
Route::resource('lots', LotController::class);
Route::resource('voies', VoieController::class);
Route::resource('tranches', TrancheController::class);
Route::resource('immeubles', ImmeubleController::class);
Route::resource('etiquettes', EtiquetteController::class);

//Route::patch('/lots', [LotController::class, 'updateBatch']);



Route::get('/parametres', function () {
	$totalEtiquettes = Etiquette::all() ;
    return view('settings', ['totalEtiquettes' => $totalEtiquettes->count()]);
});

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

});

require __DIR__.'/auth.php';

