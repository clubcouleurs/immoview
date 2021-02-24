<?php

namespace App\Models;

use App\Models\Office;
use App\Models\Immeuble;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appartement extends Model
{
    use HasFactory;
    protected $fillable = ['num', 'surfaceApp','surfaceTerrasse','type','etage','description'];

    public function produit()
    {
        return $this->morphOne(Produit::class, 'constructible');
    }


    public function immeuble()
    {
        return $this->belongsTo(Immeuble::class);
    } 

    public function office()
    {
        return $this->morphOne(Office::class, 'situable');
    }

    public function getprixM2DefinitifAttribute()
    {
        if ($this->type === 'Economique')
        {
            return 250000 / $this->surface;
        }else
        {
            return $this->produit->prixM2Definitif ;
        }
    }
    
    public function getprixM2IndicatifAttribute()
    {
        if ($this->type === 'Economique')
        {
            return 250000 / $this->surface;
        }else
        {
            return $this->produit->prixM2Indicatif ;
        }
    }

    public function getSurfaceDetailAttribute()
    {
        return 'S. Couvert : ' . $this->surfaceApp . 'm<sup>2</sup> | ' .
        'S. Terrasse : ' . $this->surfaceTerrasse . 'm<sup>2</sup>'
        ;
    } 


    public function getSurfaceAttribute()
    {
        return $this->surfaceTerrasse + $this->surfaceApp ;

    }

    public function getTrancheAttribute()
    {
        return $this->immeuble->tranche ;

    }

}
