<?php

namespace App\Models;

use App\Models\Dossier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
	protected $dates = [
	    'created_at',
	    'updated_at'
	];

    protected $fillable = ['nom', 'prenom','cin','mobile','adresse'];

    public function dossiers()
    {
        return $this->hasMany(Dossier::class);
    }
    public function visites()
    {
        return $this->hasMany(Visite::class);
    }      

}
