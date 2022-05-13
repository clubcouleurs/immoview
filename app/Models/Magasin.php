<?php

namespace App\Models;

use App\Models\Office;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magasin extends Model
{
    use HasFactory;
    protected $fillable = ['num', 'surfacePlancher','surfaceMezzanine','description'];

    /*public function produit()
    {
        return $this->belongsTo(Produit::class);
    }*/

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
    
    public function getSurfaceAttribute()
    {
        return $this->surfacePlancher + $this->surfaceMezzanine + $this->surfaceSousSol ;

    }

    public function getSurfaceVendableAttribute()
    {
        return $this->surfacePlancher + $this->surfaceSousSol ;

    }

    public function getTrancheAttribute()
    {
        return $this->immeuble->tranche ;

    }    
}
