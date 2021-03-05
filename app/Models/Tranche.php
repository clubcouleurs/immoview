<?php

namespace App\Models;

use App\Models\Immeuble;
use App\Models\Lot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tranche extends Model
{
    use HasFactory;
    protected $fillable = ['description', 'num'];

    public function immeubles()
    {
        return $this->hasMany(Immeuble::class);
    }
    public function lots()
    {
        return $this->hasMany(Lot::class);
    }
}
