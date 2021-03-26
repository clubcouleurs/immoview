<?php

namespace App\Models;

use App\Models\Dossier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delai extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'raison'
    ];
    protected $dates = ['date'];
    public function dossier()
    {
        return $this->belongsTo(Dossier::class);
    }

   
}
