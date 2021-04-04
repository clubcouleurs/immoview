<?php

namespace App\Models;

use App\Models\Banque;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bordereau extends Model
{
    use HasFactory;
    protected $fillable = ['num', 'date', 'montant','type'];

    public function dossier()
    {
        return $this->belongsTo(Dossier::class);
    }
    
    public function banque()
    {
        return $this->belongsTo(Banque::class);
    }
}
