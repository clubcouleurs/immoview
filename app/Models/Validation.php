<?php

namespace App\Models;

use App\Models\Dossier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validation extends Model
{
    use HasFactory;
    protected $fillable = [
        'raison',
    ];

    public function dossier()
    {
        return $this->belongsTo(Dossier::class);
    }    
}
