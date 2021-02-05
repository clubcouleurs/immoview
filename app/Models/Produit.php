<?php

namespace App\Models;

use App\Models\Lot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;
    protected $fillable = ['prixM2Indicatif','prixM2Definitif'];

    public function lot()
    {
        return $this->hasOne(Lot::class);
    }
    public function voies()
    {
        return $this->belongsToMany(Voie::class, 'produit_voie');
    }  

    public function scopeTranche($query, $tranche)
    {
        return $query->where('lot.tranche_id', '=', $tranche);
    }

    public function etiquette()
    {
        return $this->belongsTo(Etiquette::class);
    }    

}
