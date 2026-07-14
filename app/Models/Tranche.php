<?php

namespace App\Models;

use App\Http\Traits\BelongsToProject;
use App\Models\Immeuble;
use App\Models\Lot;
use App\Models\Projet;
use App\Scopes\ProjetScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tranche extends Model
{
    use BelongsToProject;
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
    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }    

    protected static function booted()
    {
        static::addGlobalScope(new ProjetScope);
    }
}
