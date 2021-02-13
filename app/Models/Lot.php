<?php

namespace App\Models;

use App\Models\Produit;
use App\Models\Tranche;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    use HasFactory;
    protected $fillable = ['num', 'surface','typeLot','nombreEtagesLot','descriptionLot'];

    /*public function produit()
    {
        return $this->belongsTo(Produit::class);
    }*/

    public function produit()
    {
        return $this->morphOne(Produit::class, 'constructible');
    }


    public function tranche()
    {
        return $this->belongsTo(Tranche::class);
    }      
}
