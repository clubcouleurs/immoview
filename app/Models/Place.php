<?php

namespace App\Models;

use App\Models\Immeuble;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;
    protected $fillable = ['num', 'surface','etage', 'description'];

    public function produit()
    {
        return $this->morphOne(Produit::class, 'constructible');
    }

    public function getRPlusEtageAttribute()
    {
        return $this->etage ;
    }    

    public function immeuble()
    {
        return $this->belongsTo(Immeuble::class);
    }    


    public function getprixM2DefinitifAttribute()
    {

            return $this->produit->prixM2Definitif ;

    }
    
    public function getprixM2IndicatifAttribute()
    {

            return $this->produit->prixM2Indicatif ;

    }

    public function getSurfaceDetailAttribute()
    {
        return 'Surface : ' . $this->surface . 'm<sup>2</sup> ';
    } 

    public function getTrancheAttribute()
    {
        return $this->immeuble->tranche ;

    }     
}
