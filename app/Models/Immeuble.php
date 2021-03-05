<?php

namespace App\Models;

use App\Models\Appartement;
use App\Models\Magasin;
use App\Models\Tranche;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Immeuble extends Model
{
    use HasFactory;
    protected $fillable = ['description','num'];

    public function tranche()
    {
        return $this->belongsTo(Tranche::class);
    }

    public function appartements()
    {
        return $this->hasMany(Appartement::class);
    } 

    public function magasins()
    {
        return $this->hasMany(Magasin::class);
    }     
    
}
