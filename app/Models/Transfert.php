<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfert extends Model
{
    protected $fillable = [
        'batch_id', 'dossier_id', 'nouveaux_clients', 'document_path', 'document_legalise_path', 'transfere_by',
    ];

    protected $casts = [
        'nouveaux_clients' => 'array',
    ];

    public function dossier()
    {
        return $this->belongsTo(Dossier::class);
    }

    public function transfereBy()
    {
        return $this->belongsTo(User::class, 'transfere_by');
    }
    public function transferts()
    {
        return $this->hasMany(Transfert::class, 'dossier_id');
    }
    public function scopeEnAttente($query)
    {
        return $query->whereNull('document_legalise_path');
    }
}