<?php

namespace App\Models;

use App\Models\Office;
use App\Models\Immeuble;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appartement extends Model
{
    use HasFactory;
    protected $fillable = ['num', 'surfaceApp','surfaceTerrasse','type','etage','description',
    'chambres', 'cuisines' , 'sdbs' , 'toilettes' , 'extra'];

    public function produit()
    {
        return $this->morphOne(Produit::class, 'constructible');
    }


    public function immeuble()
    {
        return $this->belongsTo(Immeuble::class);
    } 

    public function office()
    {
        return $this->morphOne(Office::class, 'situable');
    }

    public function getprixM2DefinitifAttribute()
    {
        if ($this->type === 'Economique')
        {
            return 250000 / $this->surface;
        }else
        {
            return $this->produit->prixM2Definitif ;
        }
    }
    
    public function getprixM2IndicatifAttribute()
    {
        if ($this->type === 'Economique')
        {
            return 250000 / $this->surface;
        }else
        {
            return $this->produit->prixM2Indicatif ;
        }
    }

    public function getSurfaceDetailAttribute()
    {
        return 'S. Couvert : ' . $this->surfaceApp . 'm<sup>2</sup> | ' .
        'S. Terrasse : ' . $this->surfaceTerrasse . 'm<sup>2</sup>'
        ;
    } 

    public function getComposerAttribute()
    {
        $chambres = '' ;
        switch ($this->chambres)
        {
        case 1:
        $chambres = 'واحدة غرفة' ;
            break;
        case 2:
        $chambres = 'غرفتين' ;
            break;
        case NULL:
        $chambres = 'بدون غرف' ;
            break;
        default:
        $chambres = $this->chambres . ' غرف' ;
            break;
        }

        $cuisines = '' ;
        switch ($this->cuisines)
        {
        case 1:
        $cuisines = 'مطبخ واحد' ;
            break;
        case 2:
        $cuisines = 'مطبخين' ;
            break;
        case NULL:
        $cuisines = 'بدون مطبخ' ;
            break;
        default:
        $cuisines = $this->cuisines . ' مطابخ' ;
            break;
        }

        $sdbs = '' ;
        switch ($this->sdbs)
        {
        case 1:
        $sdbs = 'حمام واحد' ;
            break;
        case 2:
        $sdbs = 'حمامين' ;
            break;
        case NULL:
        $sdbs = 'بدون حمام' ;
            break;
        default:
        $sdbs = $this->sdbs . ' حمامات' ;
            break;
        }

        $toilettes = '' ;
        switch ($this->toilettes)
        {
        case 1:
        $toilettes = 'مرحاض واحد' ;
            break;
        case 2:
        $toilettes = 'مرحاضين' ;
            break;
        case NULL:
        $toilettes = 'بدون مرحاض' ;
            break;
        default:
        $toilettes = $this->toilettes . ' مراحيض' ;
            break;
        }

        $extra = '' ;
        switch ($this->extra)
        {
        case 'Cour':
        $extra = 'بهو' ;
            break;
        case 'Terrasse':
        $extra = 'شرفة' ;
            break;
        case 'Balcon': 
        $extra = 'شرفة' ;
            break; 

        case 'Balcon & Terrasse': 
        $extra = 'شرفة و بهو' ;
            break;                 

        default:
        $extra = 'بدون شرفة و بدون بهو' ;
            break;
        }

        return $chambres . ' | ' . $cuisines  . ' | ' . $sdbs . ' | ' . $toilettes . ' | ' . $extra ;

    }

    public function getSurfaceAttribute()
    {
        return $this->surfaceTerrasse + $this->surfaceApp ;

    }

    public function getTrancheAttribute()
    {
        return $this->immeuble->tranche ;

    }

}
