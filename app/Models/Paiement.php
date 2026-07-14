<?php

namespace App\Models;

use App\Models\Banque;
use App\Models\Dossier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;


class Paiement extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $fillable = ['num', 'date', 'montant','type'];
    protected $dates = ['deleted_at'];

    const STATUS_NON_ENCAISSE = 0;
    const STATUS_ENCAISSE = 1;
    const STATUS_IMPAYE = 2;
    const STATUS_ANNULE = 3;

    
    public function dossier()
    {
        return $this->belongsTo(Dossier::class);
    }

    public function produit()
    {
        return $this->hasOneThrough(Produit::class, Dossier::class);
    }

    public function banque()
    {
        return $this->belongsTo(Banque::class);
    } 

    public static function getNbrPaiementsDueToday(String $projet, $stat = null, $day = null)
    { 

        // 0 : non-encaissé | 1 : encaissé | 2 : impayé 
        $statArr = ($stat == null) ? [0,1,2] :  $stat  ;
        if (!is_null($day)) {
            $date = Carbon::now()->toDateString();
        } else {
            $date = null;
        }
        $statArr = collect($stat)->flatten()->map(fn($id) => (int) $id)->all() ;

        $paiementsDueNbr = 
        DB::table('paiements')
        ->join('dossiers', 'dossiers.id', '=', 'paiements.dossier_id')
        ->join('produits','produits.id','=','dossiers.produit_id')
        ->join('projets','projets.id','=','produits.projet_id')
        ->whereIn('valider' ,  $statArr )
        ->where('projets.id', $projet)
        ->select('paiements.montant', 'paiements.date')
        ->where(function ($query) use ($date) {
            if($date != NULL){
            return $query->where('paiements.date', $date );
        };
        })->count() ;
        //dd($paiementsDueNbr) ; 
        return $paiementsDueNbr ;
    }


    public static function getNbrPaiementsDueUntilToday(String $projet, $stat = null, $day = null)
    { 
        // dd($stat) ;
        // 0 : non-encaissé | 1 : encaissé | 2 : impayé 
        $statArr = ($stat == null) ? [0,1,2] :  $stat  ;
        if (!is_null($day)) {
            $date = Carbon::now()->toDateString();
        } else {
            $date = null;
        }
        $statArr = collect($stat)->flatten()->map(fn($id) => (int) $id)->all() ;

        $paiementsDueNbr = 
        DB::table('paiements')
        ->join('dossiers', 'dossiers.id', '=', 'paiements.dossier_id')
        ->join('produits','produits.id','=','dossiers.produit_id')
        ->join('projets','projets.id','=','produits.projet_id')
        ->whereIn('valider' ,  $statArr )
        ->where('projets.id', $projet)
        ->select('paiements.montant', 'paiements.date')
        ->where(function ($query) use ($date) {
            if($date != NULL){
            return $query->where('paiements.date', '<=' ,  $date );
        };
        })->count() ;
        return $paiementsDueNbr ;
    }

    public static function getAllPaiementsByProjet(String $projet)
    {
            return DB::table('paiements')
            ->join('dossiers', 'dossiers.id', '=', 'paiements.dossier_id')
            ->join('produits','produits.id','=','dossiers.produit_id')
            ->join('projets','projets.id','=','produits.projet_id')
            ->where('projets.id', $projet)
            ->select('paiements.montant', 'paiements.valider') ;
    }
    public static function getAllPaiementsParProjet(String $projet)
    {
        $paiementsCollection = collect([]) ;
            $paiementsfromDb = Projet::getAllPaiementsByProjet($projet);

            //var_dump($paiements);
        $paiements = $paiementsfromDb->sum('paiements.montant');
        $paiementsV =$paiementsfromDb->where('paiements.valider', 1)->sum('paiements.montant') ;
        $paiementsN = $paiements - $paiementsV ;
        // $CA = $CAdossiers->sum() ;
        // $reliquat = $CA - $paiementsV ; 

        $paiementsCollection->put('paiements', $paiements) ;
        $paiementsCollection->put('paiementsV', $paiementsV) ;
        $paiementsCollection->put('paiementsN', $paiementsN) ;
        // $paiementsCollection->put('CA', $CA) ;
        // $paiementsCollection->put('reliquat', $reliquat) ;

        return $paiementsCollection ;

    }
    public function getEtatAttribute()
    {
        switch ($this->valider)
            {
               case 0:
                   $etat = 'Non-Encaissé' ;
                   break;
               case 1:
                   $etat = 'Encaissé' ;
                   break;
               case 2:
                   $etat = 'Impayé' ;                
                   break;                          
               default:
                   $etat = 'Non-Encaissé' ;
                   break;
           } 
       return $etat ;
    }    
    public function getColorAttribute()
    {
        switch ($this->valider)
            {
               case 0:
                   $color = 'gray' ;
                   break;
               case 1:
                   $color = 'green' ;
                   break;
               case 2:
                   $color = 'red' ;                
                   break;                          
               default:
                   $color = 'gray' ;
                   break;
           } 
       return $color ;
    }
    public function getValidateAttribute()
    {    
    switch ($this->valider) {
           case 0:
               $etat = 'Non-Encaissé' ;
               
               $svg = ' <svg class="h-4 w-4 text-gray-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
      </svg>' ; 
               break;
           case 1:
                $etat = 'Encaissé' ;
               
               $svg = '<svg class="h-4 w-4 text-green-500" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M13.6091 3.41829C13.8594 3.68621 14 4.04952 14 4.42835C14 4.80718 13.8594 5.1705 13.6091 5.43841L6.93313 12.5817C6.68275 12.8495 6.3432 13 5.98916 13C5.63511 13 5.29556 12.8495 5.04518 12.5817L2.3748 9.72439C2.13159 9.45494 1.99701 9.09406 2.00005 8.71947C2.00309 8.34488 2.14351 7.98656 2.39107 7.72167C2.63862 7.45679 2.9735 7.30654 3.32359 7.30328C3.67367 7.30002 4.01094 7.44403 4.26276 7.70427L5.98916 9.55152L11.7211 3.41829C11.9715 3.15046 12.3111 3 12.6651 3C13.0191 3 13.3587 3.15046 13.6091 3.41829Z" fill="currentColor"/>
      </svg>' ; 
               break;
           case 2:
               $etat = 'Impayé' ;
               $svg = '<svg class="h-4 w-4 text-red-400 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
      </svg>' ;                
               break;                          
           default:
               $color = 'gray' ;
               break;
       }   

        if (Gate::allows('valider paiements')) {
            return '
  <div class="relative space-x-2 flex items-center border-b border-'. $this->color. '-500 py-2 ">
                    <select name="valider" id="select-1" class="py-1 px-6 pr-16 block w-full
                    border-'. $this->color. '-500 rounded-md text-sm
                    focus:border-'. $this->color. '-500
                    focus:ring-'. $this->color. '-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                    
                      <option value =0 ' .  (($this->valider == 0) ? "selected" : "") .' >Non-Encaissé</option>
                      <option value =1 ' .  (($this->valider == 1) ? "selected" : "") .' >Encaissé</option>
                      <option value =2 ' .  (($this->valider == 2) ? "selected" : "") .' >Impayé</option>
                    </select>

    <button class="py-1 bg-blue-500 hover:bg-blue-700 text-white font-bold px-2 rounded-md" type="submit">
      OK
    </button>
                    <div class="absolute inset-y-0 right-0 flex items-center pointer-events-none pr-20">'
                    . $svg . '</div>
  </div>' ;
        }
        else
        {
                '<div class="bg-'. $this->color. '-800/[.1] border border-'. $this->color. '-200 text-sm text-'. $this->color. '-600 rounded-md p-4 dark:bg-gray-900/[.1] dark:border-gray-700 dark:text-white" role="alert">
                  '. $etat .'
                </div>';
        }
    }     




// ancienne version de validate avant la grande mise à jour, quand le paiement avait 2 etats au lieu de 3 !
//     public function getValidateAttribute()
//     {       
//             //verifying Gate::allows('validation-dossier')
//         if (Gate::allows('valider paiements')) {

//             if ($this->valider)
//             {
//             return
//             '<div class="mr-1">
//             <input type="hidden" value=0 name="valider">
//                 <button
//                   class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green"
//                   aria-label="Like"
//                   target="_blank"
//                   type="submit"
//                 >
//                     <svg
//                     class="w-4 h-4"
//                     aria-hidden="true"
//                     fill="none"
//                     viewBox="0 0 20 20"
//                   >
//                     <g id="Page-1" stroke="none" stroke-width="1" fill="currentColor" fill-rule="evenodd">
//                             <g id="icon-shape">
//                                 <path d="M2.92893219,17.0710678 C6.83417511,20.9763107 13.1658249,20.9763107 17.0710678,17.0710678 C20.9763107,13.1658249 20.9763107,6.83417511 17.0710678,2.92893219 C13.1658249,-0.976310729 6.83417511,-0.976310729 2.92893219,2.92893219 C-0.976310729,6.83417511 -0.976310729,13.1658249 2.92893219,17.0710678 L2.92893219,17.0710678 L2.92893219,17.0710678 Z M15.6568542,15.6568542 C18.7810486,12.5326599 18.7810486,7.46734008 15.6568542,4.34314575 C12.5326599,1.21895142 7.46734008,1.21895142 4.34314575,4.34314575 C1.21895142,7.46734008 1.21895142,12.5326599 4.34314575,15.6568542 C7.46734008,18.7810486 12.5326599,18.7810486 15.6568542,15.6568542 L15.6568542,15.6568542 Z M4,10 L6,8 L9,11 L14,6 L16,8 L9,15 L4,10 Z" id="Combined-Shape"></path>                         
//                             </g>
//                         </g>
//                     </svg>
//                 </button>
//              </div>' ;
//             }
//             else
//             {
//             return
//             '<div class="mr-1">
//             <input type="hidden" value=1 name="valider">

//                 <button
//                   class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red"
//                   		aria-label="Like"
//                   		target="_blank"
// 	                  	type="submit"
//                 >
//                     <svg
//                     class="w-4 h-4"
//                     aria-hidden="true"
//                     fill="none"
//                     viewBox="0 0 20 20"
//                   >
// 					<g id="Page-1" stroke="none" stroke-width="1" fill="currentColor" fill-rule="evenodd">
// 							<g id="icon-shape">
// 								<path d="M11.4142136,10 L14.2426407,7.17157288 L12.8284271,5.75735931 L10,8.58578644 L7.17157288,5.75735931 L5.75735931,7.17157288 L8.58578644,10 L5.75735931,12.8284271 L7.17157288,14.2426407 L10,11.4142136 L12.8284271,14.2426407 L14.2426407,12.8284271 L11.4142136,10 L11.4142136,10 Z M2.92893219,17.0710678 C6.83417511,20.9763107 13.1658249,20.9763107 17.0710678,17.0710678 C20.9763107,13.1658249 20.9763107,6.83417511 17.0710678,2.92893219 C13.1658249,-0.976310729 6.83417511,-0.976310729 2.92893219,2.92893219 C-0.976310729,6.83417511 -0.976310729,13.1658249 2.92893219,17.0710678 L2.92893219,17.0710678 Z M4.34314575,15.6568542 C7.46734008,18.7810486 12.5326599,18.7810486 15.6568542,15.6568542 C18.7810486,12.5326599 18.7810486,7.46734008 15.6568542,4.34314575 C12.5326599,1.21895142 7.46734008,1.21895142 4.34314575,4.34314575 C1.21895142,7.46734008 1.21895142,12.5326599 4.34314575,15.6568542 L4.34314575,15.6568542 Z" id="Combined-Shape-Copy"></path>
// 							</g>
// 						</g>
//                     </svg>
//                 </button>
//              </div>' ; 

//              }

            
//         }
//         else
//         {
//             if ($this->valider)
//             {
//             return
//             '<div class="mr-1 text-green-500">
//                     <svg
//                     class="w-4 h-4"
//                     aria-hidden="true"
//                     fill="none"
//                     viewBox="0 0 20 20"
//                   >
//                     <g id="Page-1" stroke="none" stroke-width="1" fill="currentColor" fill-rule="evenodd">
//                             <g id="icon-shape">
//                                 <path d="M2.92893219,17.0710678 C6.83417511,20.9763107 13.1658249,20.9763107 17.0710678,17.0710678 C20.9763107,13.1658249 20.9763107,6.83417511 17.0710678,2.92893219 C13.1658249,-0.976310729 6.83417511,-0.976310729 2.92893219,2.92893219 C-0.976310729,6.83417511 -0.976310729,13.1658249 2.92893219,17.0710678 L2.92893219,17.0710678 L2.92893219,17.0710678 Z M15.6568542,15.6568542 C18.7810486,12.5326599 18.7810486,7.46734008 15.6568542,4.34314575 C12.5326599,1.21895142 7.46734008,1.21895142 4.34314575,4.34314575 C1.21895142,7.46734008 1.21895142,12.5326599 4.34314575,15.6568542 C7.46734008,18.7810486 12.5326599,18.7810486 15.6568542,15.6568542 L15.6568542,15.6568542 Z M4,10 L6,8 L9,11 L14,6 L16,8 L9,15 L4,10 Z" id="Combined-Shape"></path>                         
//                             </g>
//                         </g>
//                     </svg>
//              </div>' ;
//             }
//             else
//             {
//             return
//             '<div class="mr-1 text-red-500">
//                     <svg
//                     class="w-4 h-4"
//                     aria-hidden="true"
//                     fill="none"
//                     viewBox="0 0 20 20"
//                   >
//                     <g id="Page-1" stroke="none" stroke-width="1" fill="currentColor" fill-rule="evenodd">
//                             <g id="icon-shape">
//                                 <path d="M11.4142136,10 L14.2426407,7.17157288 L12.8284271,5.75735931 L10,8.58578644 L7.17157288,5.75735931 L5.75735931,7.17157288 L8.58578644,10 L5.75735931,12.8284271 L7.17157288,14.2426407 L10,11.4142136 L12.8284271,14.2426407 L14.2426407,12.8284271 L11.4142136,10 L11.4142136,10 Z M2.92893219,17.0710678 C6.83417511,20.9763107 13.1658249,20.9763107 17.0710678,17.0710678 C20.9763107,13.1658249 20.9763107,6.83417511 17.0710678,2.92893219 C13.1658249,-0.976310729 6.83417511,-0.976310729 2.92893219,2.92893219 C-0.976310729,6.83417511 -0.976310729,13.1658249 2.92893219,17.0710678 L2.92893219,17.0710678 Z M4.34314575,15.6568542 C7.46734008,18.7810486 12.5326599,18.7810486 15.6568542,15.6568542 C18.7810486,12.5326599 18.7810486,7.46734008 15.6568542,4.34314575 C12.5326599,1.21895142 7.46734008,1.21895142 4.34314575,4.34314575 C1.21895142,7.46734008 1.21895142,12.5326599 4.34314575,15.6568542 L4.34314575,15.6568542 Z" id="Combined-Shape-Copy"></path>
//                             </g>
//                         </g>
//                     </svg>
//              </div>' ; 

//              }

// }
     
//     }      
}
