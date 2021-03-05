<?php

namespace App\Models;

use App\Models\Immeuble;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    use HasFactory;
    protected $fillable = ['num', 'surface','etage', 'description'];

    /*public function produit()
    {
        return $this->belongsTo(Produit::class);
    }*/

    public function produit()
    {
        return $this->morphOne(Produit::class, 'constructible');
    }

    public function getRPlusEtageAttribute()
    {
        return 'R+' . $this->etage ;
    }    

    public function immeuble()
    {
        return $this->belongsTo(Immeuble::class);
    }     
}
