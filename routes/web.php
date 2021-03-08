<?php

use App\Http\Controllers\AppartementController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DossierController;
use App\Http\Controllers\EtiquetteController;
use App\Http\Controllers\ImmeubleController;
use App\Http\Controllers\LotController;
use App\Http\Controllers\MagasinController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\TrancheController;
use App\Http\Controllers\ValidationController;
use App\Http\Controllers\VisiteController;
use App\Http\Controllers\VoieController;
use App\Models\Dossier;
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
Route::middleware('auth')->group(function(){

Route::get('/moi', function () {
	return view('visites.test') ;

});

Route::get('/produits_data/{num}/{type}/', [ProduitController::class, 'produits_data']);


Route::resource('lots', LotController::class);

Route::resource('appartements', AppartementController::class);

Route::resource('magasins', MagasinController::class);

Route::resource('offices', OfficeController::class);

Route::resource('clients', ClientController::class);



Route::resource('voies', VoieController::class);
Route::resource('tranches', TrancheController::class);
Route::resource('immeubles', ImmeubleController::class);

Route::patch('/etiquettes/{etiquette}', [EtiquetteController::class, 'update'])
				->middleware('can:update,etiquette');


Route::resource('etiquettes', EtiquetteController::class)->except([
    'update'
]);


Route::resource('visites', VisiteController::class);

Route::get('/prospects/{activer?}', [ClientController::class, 'index'])->name('prospectsRoute');

Route::get('/dossiers/create', [DossierController::class, 'createWithoutClient']);



Route::get('/produits/{produit}/dossiers/create', [DossierController::class, 'create'])
->middleware('can:create,produit');

Route::get('/produits/{produit}/clients/{client}/dossiers/create', [DossierController::class, 'createWithClient'])->middleware('can:create,produit');

Route::get('/clients/{client}/dossiers/create', [DossierController::class, 'createWithoutProduit']);

Route::resource('dossiers', DossierController::class)->except([
    'create', 'createWithoutClient'
]);

Route::get('/dossiers/{dossier}/actes', [DossierController::class, 'actes'])
						->middleware('can:view,dossier');

Route::get('/paiements', [PaiementController::class, 'historique']);

//Route::patch('/paiements/{paiement}', [PaiementController::class, 'update']);

Route::get('/dossiers/{dossier}/paiements', [PaiementController::class, 'index']);

Route::get('/dossiers/{dossier}/paiements/{paiement}', [PaiementController::class, 'show']);

Route::post('/dossiers/{dossier}/paiements', [PaiementController::class, 'store']);

Route::patch('/dossiers/{dossier}/paiements/{paiement}', [PaiementController::class, 'update']);

Route::delete('/dossiers/{dossier}/paiements/{paiement}', [PaiementController::class, 'destroy']);

//Route::patch('/lots', [LotController::class, 'updateBatch']);

Route::get('/dossiers/{dossier}/validation/create', [ValidationController::class, 'create'])
			->middleware('can:create,dossier');

Route::post('/dossiers/{dossier}/validation', [ValidationController::class, 'store']);


Route::get('/parametres', function () {
	$totalEtiquettes = Etiquette::all() ;
    return view('settings', ['totalEtiquettes' => $totalEtiquettes->count()]);
});

Route::get('/', [DashboardController::class, 'index'])->name('dashboard'); ;
Route::get('/dashboard', [DashboardController::class, 'index']);

/*Route::get('/', function () {
    return view('dashboard');
});*/

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->name('dashboard');

});

require __DIR__.'/auth.php';

