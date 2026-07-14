<?php

namespace App\Models;

use App\Models\Dossier;
use App\Models\Entreprise;
use App\Models\Paiement;
use App\Models\Produit;
use App\Models\Tranche;
use App\Models\Visite;
use App\Models\Voie;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Projet extends Model
{
    use HasFactory;

    //protected $primaryKey = 'id';
    protected $fillable = ['id','date_projet', 'nom_projet'];
    protected $table = 'projets';    
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }


    public function visites()
    {
        return $this->hasMany(Visite::class);
    }
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function produits()
    {
        return $this->hasMany(Produit::class);
    }

    public function dossiers()
    {
        return $this->hasManyThrough(Dossier::class, Produit::class );
    }

    public function paiements()
    {
        return $this->hasManyThrough(Paiement::class, Dossier::class );
    }

    public function contrats()
    {
        return $this->hasMany(Contrat::class);
    }
    public function tranches()
    {
        return $this->hasMany(Tranche::class);
    }
    public function voies()
    {
        return $this->hasMany(Voie::class);
    }
    ///////////////////////////////////////    
    public function typesConstructiblesSupportes()
    {
        $projetConstructibles = explode(',' , $this->type_constructible);
        $projetConstructibles = array_map('trim', $projetConstructibles);
        return $projetConstructibles ;
    }

    public function isHandlingType(String $type)
    {
        return in_array($type, $this->typesConstructiblesSupportes()) ;
    }

    public static function getFinancesOfThisProjet (String $projet)
    {
        // sélectionner les produits vendus càd avec un dossier
        $groupedDossiers = Projet::getAllDossiersOfThisProjet($projet)->filter(function ($item, $key) {
            if (isset($item->dossier)) {
               return true ;    
            }
        });
        $groupedDossiers = $groupedDossiers->map(function ($item, $key) {
                    return
                    [
               'CA' => $item->totalDefinitif,
               'paiements'  => $item->dossier->totalPaiements,
               'paiementsV' => $item->dossier->totalPaiementsV,
               'paiementsN' => ($item->dossier->totalPaiements - $item->dossier->totalPaiementsV),
               'tauxPaiement' => $item->dossier->tauxPaiementV,
               'reliquat' => $item->dossier->reliquat,
                    ];
        });        
        $groupedDossiers = $groupedDossiers->groupBy('projet_id');
        $groupedDossiers = $groupedDossiers->map(function ($item, $key) {
                return
                [
                'CA'            => numberFormat($item->sum('CA')),
                'paiements'     => numberFormat($item->sum('paiements')),
                'paiementsV'    => numberFormat($item->sum('paiementsV')),
                'paiementsN'    => numberFormat($item->sum('paiementsN')),
                'tauxPaiement'  => numberFormat($item->sum('tauxPaiement') / $item->count()),
                'reliquat'      => numberFormat($item->sum('reliquat')),                    
                ]  ;    
           
        });
            $groupedDossiers = $groupedDossiers->collapse() ;

            if ($groupedDossiers->isEmpty()) {
                $groupedDossiers = collect([
                    'CA'           => 0,
                    'paiements'    => 0,
                    'paiementsV'   => 0,
                    'paiementsN'   => 0,
                    'tauxPaiement' => 0,
                    'reliquat'     => 0,
                ]);
             } 

            return $groupedDossiers ;
    }

    public static function getAllDossiersOfThisProjet (String $projet)
    {
        $collection = Produit::with('dossier')
                            ->where('projet_id' , $projet)
                            ->with('constructible')
                            ->with('paiements')
                            ->get();
        return $collection ;
    }    









}
