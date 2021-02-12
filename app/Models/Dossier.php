<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Paiement;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dossier extends Model
{
    use HasFactory;
    protected $fillable = ['num', 'date', 'frais','detail','client_id','user_id', 'produit_id'];
    
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }  
    public function user()
    {
        return $this->belongsTo(User::class);
    }      
    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
            
    public function getTotalPaiementsAttribute()
    {
        return $this->paiements()->sum('montant');
    }
    public function getReliquatAttribute()
    {
        return  $this->produit->total - $this->paiements()->sum('montant') ;
    }  
    public function getTauxPaiementAttribute()
    {       
        return round(($this->totalPaiements * 100) / $this->produit->total , 2) ;
    }       

}
