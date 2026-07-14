<?php

namespace App\Models;

use App\Models\Projet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    use HasFactory;

    //protected $primaryKey = 'id';
    protected $fillable = ['nom', 'logo', 'rc', 'patente', 'if', 'capital', 'siege','ville'];
    protected $table = 'entreprises';    
    protected $primaryKey = 'id';

    public function projets()
    {
        return $this->hasMany(Projet::class);
    }

}
