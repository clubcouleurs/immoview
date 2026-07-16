<?php

use App\Http\Controllers\AppartementController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BanqueController;
use App\Http\Controllers\BordereauController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContratController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DelaiController;
use App\Http\Controllers\DossierController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\EtiquetteController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ImmeubleController;
use App\Http\Controllers\LotController;
use App\Http\Controllers\MagasinController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\RecuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SyntheseController;
use App\Http\Controllers\TrancheController;
use App\Http\Controllers\TransfertController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValidationController;
use App\Http\Controllers\VisiteController;
use App\Http\Controllers\VoieController;
use App\Models\Dossier;
use App\Models\Etiquette;
use Illuminate\Support\Facades\Route;
//use PDF; // at the top of the file


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

// routes ajoutés après 19/09/2023
// Authorization not OK
Route::resource('types', TypeController::class);

Route::resource('projets', ProjetController::class)->middleware('can:editer projets');

Route::resource('contrats', ContratController::class);
Route::post('/contratsDuplicate', [ContratController::class, 'duplicate']) ;

Route::resource('entreprises', EntrepriseController::class)->middleware('can:editer entreprises');

Route::resource('banques', BanqueController::class);
Route::resource('articles', ArticleController::class);

Route::get('/produits/{produit}/fiche', [ProduitController::class, 'fiche']);	

// end nouveaux routes

// Authorization OK, taking car of it in the controller
Route::post('/synthese', [SyntheseController::class, 'synthese']) ;

Route::get('/recouvrement', [DossierController::class, 'recouvrement'])
						->middleware('can:voir finance');

Route::get('/finances', [FinanceController::class, 'index'])->middleware('can:voir finance');

Route::get('/stocks', [StockController::class, 'index'])->middleware('can:voir stock');

Route::get('finances/export/', [FinanceController::class, 'export'])->middleware('can:export finance');
Route::get('stocks/export/', [StockController::class, 'export'])->middleware('can:export finance');

Route::get('dossiers/export/', [DossierController::class, 'export'])->middleware('can:export finance');
Route::get('paiements/export/', [PaiementController::class, 'export'])->middleware('can:export finance');
Route::get('lots/export/', [LotController::class, 'export'])->middleware('can:export finance');
Route::get('visites/export/', [VisiteController::class, 'export'])->middleware('can:export finance');
Route::get('clients/export/', [ClientController::class, 'export'])->middleware('can:export finance');

Route::get('appartements/export/', [AppartementController::class, 'export'])->middleware('can:voir appartements');
Route::get('magasins/export/', [MagasinController::class, 'export'])->middleware('can:voir magasins');

//Route::get('/{constructible?}/{tranche?}/dossiers', [DossierController::class, 'index']);

// cette route est utilisée par javascript sur le formulaire d'ajout de client
Route::get('/produits_data/{num}/{type}/', [ProduitController::class, 'produits_data']);

// Authorization OK, taking car of it in the controller
Route::resource('lots', LotController::class);
// Authorization OK, taking car of it in the controller
Route::resource('appartements', AppartementController::class);
// Authorization OK, taking car of it in the controller
Route::resource('magasins', MagasinController::class);
// Authorization OK, taking car of it in the controller
Route::resource('places', PlaceController::class);
// Authorization OK, taking car of it in the controller
Route::resource('offices', OfficeController::class);
// Authorization OK, taking car of it in the controller
Route::resource('clients', ClientController::class);
// Authorization OK, taking car of it in the controller
Route::resource('users', UserController::class);

// Authorization OK, taking car of it in the middleware
Route::resource('roles', RoleController::class)->middleware('can:voir roles');

// Authorization OK, taking car of it in the middleware
Route::resource('voies', VoieController::class)->middleware('can:voir voies');
// Authorization OK, taking car of it in the middleware
Route::resource('tranches', TrancheController::class)->middleware('can:voir tranches');
// Authorization OK, taking car of it in the middleware
Route::resource('immeubles', ImmeubleController::class)->middleware('can:voir immeubles');
// Authorization OK, taking car of it in the middleware
Route::patch('/etiquettes/{etiquette}', [EtiquetteController::class, 'update'])
				->middleware('can:update,etiquette');

// Authorization OK, taking car of it in the middleware
Route::resource('etiquettes', EtiquetteController::class)->except([
    'update'
])->middleware('can:voir etiquettes');

// Authorization OK, taking car of it in the middleware
Route::resource('visites', VisiteController::class)->middleware('can:voir visites');

Route::get('/prospects/{activer?}', [ClientController::class, 'index'])->name('prospectsRoute')
->middleware('can:voir prospection');









// Authorization OK, taking car of it in the controller
Route::get('/dossiers/{dossier}/delais/create', [DelaiController::class, 'create']);

// Authorization OK, taking car of it in the controller
Route::post('/dossiers/{dossier}/delais', [DelaiController::class, 'store']);


// DOSSIERS ROUTES

// Authorization OK, taking car of it in the controller
Route::get('/dossiers/litige', [DossierController::class, 'litige']);

// Authorization OK, taking car of it in the controller
Route::get('/dossiers', [DossierController::class, 'index'])->name('dossiers.index');;

// Authorization OK, taking car of it in the controller
Route::get('/dossiers/create', [DossierController::class, 'createWithoutClient']);

// Authorization OK, taking car of it in the controller
Route::post('/dossiers', [DossierController::class, 'store']);

// Authorization OK, taking car of it in the middleware
Route::get('/dossiers/{dossier}', [DossierController::class, 'show'])
			->middleware('can:show,dossier');

// Authorization OK, taking car of it in the middleware
Route::get('/dossiers/{dossier}/edit', [DossierController::class, 'edit'])
			->middleware('can:edit,dossier');



// Authorization OK, taking car of it in the controller/middleware
Route::put('/dossiers/{dossier}', [DossierController::class, 'update'])
			->middleware('can:edit,dossier');

// Authorization OK, taking car of it in the controller/middleware
Route::delete('/dossiers/{dossier}', [DossierController::class, 'destroy'])
				->middleware('can:supprimer dossiers,dossier');

Route::get('/dossiers/{dossier}/desisstement', [DossierController::class, 'desisstement'])
				->middleware('can:supprimer dossiers,dossier');

Route::post('/dossiers/{dossier}/demandeDesisstement', [DossierController::class, 'demandeDesisstement'])
				->middleware('can:supprimer dossiers,dossier');

Route::post('/dossiers/{dossier}/demandeTransfert', [DossierController::class, 'demandeTransfert'])
				->middleware('can:supprimer dossiers,dossier');

Route::put('/dossiers/{dossier}/desister', [DossierController::class, 'desister'])
				->middleware('can:supprimer dossiers,dossier');

///////////////////////
// Route::get('/dossiers/{dossier}/transfert', [TransfertController::class, 'index'])
// 				->name('dossiers.transfert.index');


// Authorization OK, taking car of it in the middleware
Route::get('/dossiers/{dossier}/transfert', [TransfertController::class, 'index'])
			->name('dossiers.transfert.generer')
			->middleware('can:edit,dossier');

Route::post('/dossiers/{dossier}/transfert/generer', [TransfertController::class, 'genererDocument']);

Route::post('/dossiers/{dossier}/transfert/{transfert}/finaliser', [TransfertController::class, 'finaliser'])
				->name('dossiers.transfert.finaliser');
Route::delete('/dossiers/{dossier}/transfert/{transfert}', [TransfertController::class, 'supprimer'])
				->name('dossiers.transfert.supprimer');


Route::get('/dossiers/{dossier}/transfert/{transfert}/telecharger', [TransfertController::class, 'telechargerDocument'])
    ->name('dossiers.transfert.telecharger')
    ->middleware('can:edit,dossier');;


// Authorization OK, taking car of it in the middleware
Route::middleware(['can:view,dossier'])->group(function () {
	Route::get('/dossiers/{dossier}/retour', [DossierController::class, 'retour']);
	//rajoutée le 06/07/22 
	Route::get('/dossiers/{dossier}/acte-vente', [DossierController::class, 'acte_vente']);

	// fin modification du 06/07/22
	Route::get('/dossiers/{dossier}/actes', [DossierController::class, 'actes']);



});

// Authorization OK, taking car of it in the middleware
Route::post('/dossiers/{dossier}/validation', [ValidationController::class, 'store'])
			->middleware('can:valider dossiers');

// Authorization OK, taking car of it in the middleware
Route::get('/produits/{produit}/dossiers/create', [DossierController::class, 'create'])
->middleware('can:create,produit');

// Authorization OK, taking car of it in the middleware
Route::get('/produits/{produit}/clients/{client}/dossiers/create', [DossierController::class, 'createWithClient'])->middleware('can:create,produit');

// Authorization OK, taking car of it in the controller
Route::get('/clients/{client}/dossiers/create', [DossierController::class, 'createWithoutProduit']);

// Authorization OK in the middelware
Route::get('/dossiers/{dossier}/validation/create', [ValidationController::class, 'create'])
			->middleware('can:create,dossier', 'can:valider dossiers');

// FIN DOSSIERS ROUTES



// Route::resource('dossiers', DossierController::class)->except([
//     'create', 'createWithoutClient'
// ])->middleware('can:voir dossiers');



// DEBUT PAIEMENTS DOSSIER ROUTES
// Authorization OK in the middelware
Route::get('/paiements', [PaiementController::class, 'historique'])
			->middleware('can:voir paiements');

// Authorization OK in the middelware
Route::get('/dossiers/{dossier}/paiements', [PaiementController::class, 'index'])
			->middleware('can:showPaiement,dossier');

// Authorization OK in the middelware
Route::get('/dossiers/{dossier}/paiements/{paiement}', [PaiementController::class, 'show'])
			->middleware('can:edit,paiement');

// Authorization OK in the middelware
Route::post('/dossiers/{dossier}/paiements', [PaiementController::class, 'store'])
			->middleware('can:ajoutPaiement,dossier');

// Authorization OK in the middelware
Route::patch('/dossiers/{dossier}/paiements/{paiement}', [PaiementController::class, 'update'])
			->middleware('can:edit,paiement');

// Route pour générer le reçu de paiement
// Authorization OK in the middelware
Route::get('/dossiers/{dossier}/paiements/{paiement}/generate', [RecuController::class, 'recu'])
			->middleware('can:edit,paiement');


// Authorization OK in the middelware
Route::delete('/dossiers/{dossier}/paiements/{paiement}', [PaiementController::class, 'destroy'])
			->middleware('can:delete,paiement');
// FIN PAIEMENTS DOSSIER ROUTES

// DEBUT PAIEMENTS DOSSIER ROUTES
// Authorization OK in the middelware
Route::get('/dossiers/{dossier}/bordereaux', [BordereauController::class, 'index'])
			->middleware('can:showPaiement,dossier');

// Authorization OK in the middelware
Route::get('/dossiers/{dossier}/bordereaux/{bordereau}', [BordereauController::class, 'show'])
			->middleware('can:edit,bordereau');

// Authorization OK in the middelware
Route::post('/dossiers/{dossier}/bordereaux', [BordereauController::class, 'store'])
			->middleware('can:ajoutPaiement,dossier');

// Authorization OK in the middelware
Route::patch('/dossiers/{dossier}/bordereaux/{bordereau}', [BordereauController::class, 'update'])
			->middleware('can:edit,bordereau');

// Authorization OK in the middelware
Route::delete('/dossiers/{dossier}/bordereaux/{bordereau}', [BordereauController::class, 'destroy'])
			->middleware('can:delete,bordereau');

// Authorization OK in the middelware
Route::get('/dossiers/{dossier}/bordereaux/{bordereau}/generate', [BordereauController::class, 'bordereau'])
			->middleware('can:edit,bordereau');

			
// FIN PAIEMENTS DOSSIER ROUTES









// Authorization OK in the middelware
Route::get('/parametres', function () {
	$totalEtiquettes = Etiquette::all() ;
    return view('settings', ['totalEtiquettes' => $totalEtiquettes->count()]);
})->middleware('can:voir parametres');

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
// adding dashboard by project, updated 26/0/823
// old
//Route::get('/dashboard', [DashboardController::class, 'index']);
// new
Route::get('/dashboard/{projet?}', [DashboardController::class, 'index']);
//Route::get('/dashboard', [DashboardController::class, 'indexWithoutProject']);


/*Route::get('/', function () {
    return view('dashboard');
});*/

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->name('dashboard');

});

require __DIR__.'/auth.php';

