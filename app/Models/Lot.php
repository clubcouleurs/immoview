<?php

namespace App\Models;

use App\Models\Produit;
use App\Models\Tranche;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    use HasFactory;
    protected $fillable = ['numLot', 'surfaceLot','typeLot','nombreEtagesLot','descriptionLot'];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function tranche()
    {
        return $this->belongsTo(Tranche::class);
    }    

  
}
