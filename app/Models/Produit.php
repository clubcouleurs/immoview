<?php

namespace App\Models;

use App\Http\Traits\BelongsToProject;
use App\Models\Dossier;
use App\Models\Lot;
use App\Models\Projet;
use App\Scopes\ProjetScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NumberToWords\NumberToWords;

class Produit extends Model
{
    use BelongsToProject;
    use HasFactory;
    protected $fillable = ['prixM2Indicatif','prixM2Definitif', 'etiquette_id','projet_id'];

    public function constructible()
    {
        return $this->morphTo();
    }

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }
    
    protected static function booted()
    {
        static::addGlobalScope(new ProjetScope);
    }

    public function voies()
    {
        return $this->belongsToMany(Voie::class, 'produit_voie');
    }  

    public function etiquette()
    {
        return $this->belongsTo(Etiquette::class);
    }    
    public function dossier()
    {
        return $this->hasOne(Dossier::class);
    }

    public function paiements()
    {
        return $this->hasManyThrough(Paiement::class, Dossier::class );
    }

//// end of relationships

    public static function getEtatProduitsProjet(Projet $projet, $inflector)
    {
        $produitsOverView = collect([]) ;
        foreach($projet->typesConstructiblesSupportes() as $typeConstructible) {
            ${$typeConstructible . 'All'} = Produit::with('etiquette')
                                ->with('constructible')
                                ->where('constructible_type',$inflector->singularize($typeConstructible))
                                // adding project update 26/08/23
                                ->where('projet_id' , $projet->id)
                                ->get();
            ${$typeConstructible . 'Reserved'}  = ${$typeConstructible . 'All'}->where('etiquette_id', 3)->count(); 
            ${$typeConstructible . 'Stocked'} =  ${$typeConstructible . 'All'}->where('etiquette_id', 2)->count(); 
            ${$typeConstructible . 'Promised'}  = ${$typeConstructible . 'All'}->where('etiquette_id', 9)->count(); 

            ${$typeConstructible . 'Blocked'} =
            ${$typeConstructible . 'All'}->count() 
            - (${$typeConstructible . 'Stocked'}
            + ${$typeConstructible . 'Reserved'}
            + ${$typeConstructible . 'Promised'});
            $total = 0 ;
            ${'prixTotal' . $typeConstructible} = ${$typeConstructible . 'All'}
                    ->map(function ($item, $key) use ($total) {
                    return $total = $total + $item->totalIndicatif;
            });
                    $produitsOverView->put($typeConstructible.'All', ${$typeConstructible . 'All'}->count()) ;
                    $produitsOverView->put($typeConstructible.'Reserved',${$typeConstructible . 'Reserved'});
                    $produitsOverView->put($typeConstructible.'Stocked',${$typeConstructible . 'Stocked'});
                    $produitsOverView->put($typeConstructible.'Promised',${$typeConstructible . 'Promised'});
                    $produitsOverView->put($typeConstructible.'Blocked',${$typeConstructible . 'Blocked'});

        };

        return $produitsOverView ;
    }

    public function scopeTranche($query, $tranche)
    {
        return $query->where('lot.tranche_id', '=', $tranche);
    }

    public function getTypeAttribute()
    {
        return $this->constructible_type;               
    }

    public function getTrancheAttribute()
    {
        switch ($this->constructible_type) {
            case 'appartement':
            case 'place':
            case 'magasin':
                return $this->constructible->immeuble->tranche->num . '/' . 
                 $this->constructible->immeuble->tranche->description;
                break;

            case 'lot':
                return $this->constructible->tranche->num . '/' . 
                 $this->constructible->tranche->description;
                break;  

            case 'bureau':
                return $this->constructible->situable->immeuble->tranche->num . '/' . 
                 $this->constructible->situable->immeuble->tranche->description;
                break;

            default:
                break;
        }
    }

    public function getEtageAttribute()
    {
        switch ($this->constructible_type) {
            case 'appartement':
            case 'place':
                return $this->constructible->etage === 0
                    ? 'RDC'
                    : $this->constructible->etage;

            case 'magasin':
                return 'RDC' ;
                break;

            case 'lot':
                return 'R+'. $this->constructible->etage ;
                break;  

            case 'bureau':
            if ($this->constructible->situable_type == 'magasin') {
                return 'RDC' ;
                break;
            }
            else
            {
                return $this->constructible->etage ;
                break;   
            }


            default:
                break;
        }
    }

    public function getImmeubleAttribute()
    {
        switch ($this->constructible_type) {
            case 'appartement':
            case 'place':
            case 'magasin':
                return $this->constructible->immeuble->num ;
                break;

            case 'lot':
                return 'LOT' ;
                break;  

            case 'bureau':
                return $this->constructible->situable->immeuble->num ;
                break;
                
            default:
                break;
        }
    }

    public static function produitsParType()
    {       
        return \DB::table('produits')
                ->select('constructible_type', \DB::raw('COUNT(*) as nombre'))
                ->groupBy('constructible_type')
                ->get();
    } 

    //adding project update 26/08/23
    public static function produitsParTypeParProjet(Projet $projet)
    {       
        return \DB::table('produits')
                ->select('constructible_type', \DB::raw('COUNT(*) as nombre'))
                ->where('projet_id' , $projet->id)
                ->groupBy('constructible_type')
                ->get();
    } 
    // fin
    
    // public static function produitsParTypeParEtat()
    // {       
    //     return \DB::table('produits')
    //             ->leftJoin('etiquettes', 'etiquettes.id', '=', 'produits.etiquette_id')
    //             ->select('etiquettes.label','constructible_type', \DB::raw('COUNT(*) as nombre'))
    //             ->groupBy('constructible_type','etiquettes.label')
    //             ->get();
    // } 

    public function getPrixAttribute()
    {
        if ($this->constructible->type === 'Economique')
        {
            return round(250000 / $this->constructible->surface) ;
        }
      
        $prix = ($this->prixM2Definitif == 0 || $this->prixM2Definitif == Null)
                    ? $this->prixM2Indicatif
                    : $this->prixM2Definitif ;

        return $prix ;
    }

    public function getTotalDefinitifAttribute()
    {
        $prix = ($this->prixM2Definitif == 0 || $this->prixM2Definitif == Null)
                    ? $this->prixM2Indicatif
                    : $this->prixM2Definitif ;

        if ($this->constructible->type === 'Economique')
        {
            return 250000 ;
        }
        if ($this->constructible->type === 'Standing')
        {
            return $prix * ($this->constructible->surfaceApp + ($this->constructible->surfaceTerrasse/2)) ;
        }          
        if($this->constructible_type === 'magasin')
        {
            return $this->prixM2Indicatif * $this->constructible->surfaceVendable ;
        }
        return $prix * $this->constructible->surface ;
    } 
    public function getTotalDefinitifFormatAttribute()
    {
        return number_format($this->total, 2 , ',' , '.') ;
    }     
    public function getTotalDefinitifLetterAttribute()
    {
        $toWords = new NumberToWords();
        $numberTransformer = $toWords->getNumberTransformer('fr');
        return ucfirst($numberTransformer->toWords($this->total)) . ' Dirhams' ;
    }     
    public function getTotalIndicatifAttribute()
    {
        if ($this->constructible->type === 'Economique')
        {
            return 250000 ;
        }
        if ($this->constructible->type === 'Standing')
        {
            return $this->prixM2Indicatif * ($this->constructible->surfaceApp + ($this->constructible->surfaceTerrasse/2)) ;
        }
        
        if($this->constructible_type === 'magasin')
        {
            return $this->prixM2Indicatif * $this->constructible->surfaceVendable ;
        }
        return $this->prixM2Indicatif * $this->constructible->surface ;
    }     
    public function getTotalAttribute()
    {
        if ($this->constructible->type === 'Economique')
        {
            return 250000 ;
        }
        if ($this->constructible->type === 'Standing')
        {
            return $this->prix * ($this->constructible->surfaceApp + ($this->constructible->surfaceTerrasse/2)) ;
        }         
        if($this->constructible_type === 'magasin')
        {
            return $this->prix * $this->constructible->surfaceVendable ;
        }
        return $this->prix * $this->constructible->surface ;
    }  

    public function getRemiseAttribute()
    {
        if ($this->constructible->type === 'Economique')
        {
            return 0 ;
        }         
        return round(100 - (($this->prixM2Definitif * 100) / $this->prixM2Indicatif ) , 2) ;
    } 
    public function getRemiseNatureAttribute()
    {
        return ($this->remise > 0 ) ? 'Remise' : 'Augmentation' ;
    } 

    public function getNombreVoiesAttribute()
    {
        return count($this->voies) ;
    }
    public function getNombreFacadeAttribute()
    {
        if($this->nombreVoies == 1 )
        {
            return $this->nombreVoies . ' Façade';
        }elseif($this->nombreVoies > 1)
        {
            return $this->nombreVoies . ' Façades';
        }
        return '' ;
    }

    public function getQuellesVoiesAttribute()
    {
        $voies = '' ;
        foreach ($this->voies as $voie)
        {
                        $voies = $voies  . $voie->Largeur . ' | ' ;
        }
        return $voies ;
    }
    public function getDescriptionVoiesAttribute()
    {
        $voies = '' ;
        $i = 0 ;
        foreach ($this->voies as $voie)
        {
            $voies = $voies  . $voie->Largeur . ' m';
             $i += 1 ; 
            if(count($this->voies) > $i )
              {
                $voies = $voies  . ' | ';
              }
             
        }
        return $voies . ' de largeur.' ;
    }     

    public function getRecapAttribute()
    {
        return 
            'Qui concerne ' . $this->constructible_type .' N° ' . $this->constructible->num . 
            ', d\'une surface totale de : ' . $this->constructible->surface . 'm2' .
            '. Vendu au prix total de : ' . number_format($this->total) . ' Dhs'.
            '. Du type : ' . $this->type . '. Etage : ' . $this->etage .
            '. ' . ucfirst($this->constructible_type) .' sur ' . $this->constructible->tranche->description ;
    }    
}
