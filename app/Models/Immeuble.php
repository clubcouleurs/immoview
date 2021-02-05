<?php

namespace App\Models;

use App\Models\Tranche;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Immeuble extends Model
{
    use HasFactory;
    protected $fillable = ['description'];

    public function tranche()
    {
        return $this->belongsTo(Tranche::class);
    }
    
}
