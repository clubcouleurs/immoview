<?php

namespace App\Models;

use App\Models\Contrat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    public function contrat()
    {
        return $this->belongsTo(Contrat::class);
    }

}
