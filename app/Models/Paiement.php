<?php

namespace App\Models;

use App\Models\Dossier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;
    protected $fillable = ['num', 'date', 'montant','type'];

    public function dossier()
    {
        return $this->belongsTo(Dossier::class);
    }     
}
