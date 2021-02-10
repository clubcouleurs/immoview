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
}
