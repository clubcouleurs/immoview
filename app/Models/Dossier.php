<?php

namespace App\Models;

use App\Models\Appartement;
use App\Models\Box;
use App\Models\Client;
use App\Models\Delai;
use App\Models\Lot;
use App\Models\Paiement;
use App\Models\Produit;
use App\Models\User;
use App\Models\Validation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Gate;

class Dossier extends Model
{
    use HasFactory;
    // y'avait 'num' dans les fillables
    protected $fillable = ['date', 'frais','detail', 'user_id', 'produit_id', 'isVente'];
    
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
    public function clients()
    {
        return $this->belongsToMany(Client::class, 'dossier_client');
    }  

    public static function litige()
    {
       return count(Dossier::where('litige', '=', true)->get()) ;
    }  

    public function user()
    {
        return $this->belongsTo(User::class);
    }      
    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    public function bordereaux()
    {
        return $this->hasMany(Bordereau::class);
    }

    public function delais()
    {
        return $this->hasMany(Delai::class)->latest();
    }


    public function validation()
    {
        return $this->hasOne(Validation::class);
    }


    public function getAvanceNonEncAttribute()
    {
        $r = ($this->produit->total * 0.3) - $this->totalPaiementsV ;
        return ($r < 0) ? 0 : $r ;

    } 


            
    public function getTotalPaiementsAttribute()
    {
        return $this->paiements()->sum('montant');
    }
// les paiements validés
    public function getTotalPaiementsVAttribute()
    {
        return $this->paiements()->where('valider',1)->sum('montant');
    }
    public function getTauxPaiementVAttribute()
    {       
        return round(($this->totalPaiementsV * 100) / $this->produit->total , 2) ;
    }     
// fin paiements validés
    public function getReliquatAttribute()
    {
        return  $this->produit->total - $this->totalPaiementsV ;
    }  
    public function getTauxPaiementAttribute()
    {       
        return round(($this->totalPaiements * 100) / $this->produit->total , 2) ;
    }     

    public static function dossiersParType()
    {       
        return \DB::table('dossiers')
                ->select('produits.constructible_type', \DB::raw('COUNT(*) as nombre'))
                ->leftJoin('produits', 'dossiers.produit_id', '=', 'produits.id')
                ->groupBy('produits.constructible_type')
                ->get();
    } 

    public function getHasActeAttribute()
    {       
        if ($this->produit->constructible_type != 'appartement') {           
            return $this->tauxPaiementV >= 30 ;
        }elseif ($this->produit->constructible_type === 'appartement') {
                            // cette condition et rajoutée en 29/09/2021 par bidouh
            // 100000 dhs pour les apps en 1er et 2ème Etage (2ème tranche) & 75000 dhs pour les autres
            if ($this->produit->constructible->immeuble->tranche->num == 2
                && ($this->produit->constructible->etage == 1 || 
                    $this->produit->constructible->etage == 2)) {
                return $this->totalPaiementsV >= 100000 ;
                }
            // fin condition rajoutée en 29/09/2021 
            }
            return $this->totalPaiementsV >= 75000 ;
    }  
    public function getValidateAttribute()
    {       
        return boolval($this->validation);
    } 

    public function getActeAttribute()
    {    
    if ($this->actePj)
    {
            return
            '<div class="mr-1">
                <a
                  class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red"
                  aria-label="Like"
                  target="_blank"
                  href="' . asset($this->actePj) . '"
                >
                    <svg
                    class="w-4 h-4"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                        <path d="M14,14 L18,14 L18,2 L2,2 L2,14 L6,14 L6,14.0020869 C6,15.1017394 6.89458045,16 7.99810135,16 L12.0018986,16 C13.1132936,16 14,15.1055038 14,14.0020869 L14,14 L14,14 Z M0,1.99079514 C0,0.891309342 0.898212381,0 1.99079514,0 L18.0092049,0 C19.1086907,0 20,0.898212381 20,1.99079514 L20,18.0092049 C20,19.1086907 19.1017876,20 18.0092049,20 L1.99079514,20 C0.891309342,20 0,19.1017876 0,18.0092049 L0,1.99079514 L0,1.99079514 Z M4,4 L16,4 L16,6 L4,6 L4,4 L4,4 Z M4,7 L16,7 L16,9 L4,9 L4,7 L4,7 Z M4,10 L16,10 L16,12 L4,12 L4,10 L4,10 Z" id="Combined-Shape"></path>
                    </svg>
                </a>
             </div>';         
           
       }   
       else
       {
        if ($this->hasActe || $this->validate)
        {
            return
            '<div class="mr-1">
                <a
                  class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red"
                  aria-label="Like"
                  target="_blank"
                  href="/dossiers/' . $this->id . '/' . $this->produit->constructible_type . '/actes"
                >
                    <svg
                    class="w-4 h-4"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                        <path d="M14,14 L18,14 L18,2 L2,2 L2,14 L6,14 L6,14.0020869 C6,15.1017394 6.89458045,16 7.99810135,16 L12.0018986,16 C13.1132936,16 14,15.1055038 14,14.0020869 L14,14 L14,14 Z M0,1.99079514 C0,0.891309342 0.898212381,0 1.99079514,0 L18.0092049,0 C19.1086907,0 20,0.898212381 20,1.99079514 L20,18.0092049 C20,19.1086907 19.1017876,20 18.0092049,20 L1.99079514,20 C0.891309342,20 0,19.1017876 0,18.0092049 L0,1.99079514 L0,1.99079514 Z M4,4 L16,4 L16,6 L4,6 L4,4 L4,4 Z M4,7 L16,7 L16,9 L4,9 L4,7 L4,7 Z M4,10 L16,10 L16,12 L4,12 L4,10 L4,10 Z" id="Combined-Shape"></path>
                    </svg>
                </a>
             </div>
             <div class="mr-1">
                <a
                  class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red"
                  aria-label="Like"
                  href="/dossiers/' . $this->id . '/retour"
                >
                    <svg
                    class="w-4 h-4"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                        <path d="M14,14 L18,14 L18,2 L2,2 L2,14 L6,14 L6,14.0020869 C6,15.1017394 6.89458045,16 7.99810135,16 L12.0018986,16 C13.1132936,16 14,15.1055038 14,14.0020869 L14,14 Z M0,1.99079514 C0,0.891309342 0.898212381,0 1.99079514,0 L18.0092049,0 C19.1086907,0 20,0.898212381 20,1.99079514 L20,18.0092049 C20,19.1086907 19.1017876,20 18.0092049,20 L1.99079514,20 C0.891309342,20 0,19.1017876 0,18.0092049 L0,1.99079514 Z M5,9 L7,7 L9,9 L13,5 L15,7 L9,13 L5,9 Z" id="Combined-Shape"></path>
                    </svg>
                </a>
             </div>' ;
        }
        else
        {
            //verifying Gate::allows('validation-dossier')
            if (Gate::allows('valider dossiers')) {
            return
            '<div class="mr-1">
                <a
                  class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                  aria-label="Like"
                  href="/dossiers/' . $this->id . '/validation/create"
                >
                    <svg
                    class="w-4 h-4"
                    aria-hidden="true"
                    fill="none"
                    viewBox="0 0 20 20"
                  >
                    <g id="Page-1" stroke="none" stroke-width="1" fill="currentColor" fill-rule="evenodd">
                            <g id="icon-shape">
                                <path d="M2.92893219,17.0710678 C6.83417511,20.9763107 13.1658249,20.9763107 17.0710678,17.0710678 C20.9763107,13.1658249 20.9763107,6.83417511 17.0710678,2.92893219 C13.1658249,-0.976310729 6.83417511,-0.976310729 2.92893219,2.92893219 C-0.976310729,6.83417511 -0.976310729,13.1658249 2.92893219,17.0710678 L2.92893219,17.0710678 L2.92893219,17.0710678 Z M15.6568542,15.6568542 C18.7810486,12.5326599 18.7810486,7.46734008 15.6568542,4.34314575 C12.5326599,1.21895142 7.46734008,1.21895142 4.34314575,4.34314575 C1.21895142,7.46734008 1.21895142,12.5326599 4.34314575,15.6568542 C7.46734008,18.7810486 12.5326599,18.7810486 15.6568542,15.6568542 L15.6568542,15.6568542 Z M4,10 L6,8 L9,11 L14,6 L16,8 L9,15 L4,10 Z" id="Combined-Shape"></path>                         
                            </g>
                        </g>
                    </svg>
                </a>
             </div>' ;
            }
            else
            {
            return
            '<div class="mr-1">
                <span
                  class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray"
                >
                    <svg
                    class="w-4 h-4"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                        <path d="M14,14 L18,14 L18,2 L2,2 L2,14 L6,14 L6,14.0020869 C6,15.1017394 6.89458045,16 7.99810135,16 L12.0018986,16 C13.1132936,16 14,15.1055038 14,14.0020869 L14,14 L14,14 Z M0,1.99079514 C0,0.891309342 0.898212381,0 1.99079514,0 L18.0092049,0 C19.1086907,0 20,0.898212381 20,1.99079514 L20,18.0092049 C20,19.1086907 19.1017876,20 18.0092049,20 L1.99079514,20 C0.891309342,20 0,19.1017876 0,18.0092049 L0,1.99079514 L0,1.99079514 Z M4,4 L16,4 L16,6 L4,6 L4,4 L4,4 Z M4,7 L16,7 L16,9 L4,9 L4,7 L4,7 Z M4,10 L16,10 L16,12 L4,12 L4,10 L4,10 Z" id="Combined-Shape"></path>
                    </svg>
                </span>
             </div>';  

             }  
        }
        }
    }     


}
