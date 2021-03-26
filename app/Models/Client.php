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

    protected $fillable = ['nom', 'prenom','cin','mobile','adresse', 'cinPj'];

    public function dossiers()
    {
        return $this->hasMany(Dossier::class);
    }
    public function visites()
    {
        return $this->hasMany(Visite::class);
    }    

    public static function tauxConversion()
    {
        $countClients = Client::count() ;
        if( $countClients != 0 )
        {
            return round((Client::where('activer' , 1)->count() * 100) / $countClients , 2) ;
        }
        else
        {
            return 0 ;
        }
    }
}
