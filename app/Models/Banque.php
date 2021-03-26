<?php

namespace App\Models;

use App\Models\Paiement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banque extends Model
{
    use HasFactory;

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }     
}
