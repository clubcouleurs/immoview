<?php

namespace App\Models;

use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;
    protected $fillable = ['num'];
	//protected $table = 'bureaux';

    public function situable()
    {
        return $this->morphTo();
    }

    public function produit()
    {
        return $this->morphOne(Produit::class, 'constructible');
    }     

    public function getSurfaceAttribute()
    {
    	if ($this->situable_type == 'appartement')
    	{
        	return $this->situable->surfaceApp + $this->situable->surfaceTerrasse ;
    	}elseif ($this->situable_type == 'magasin') {
        	return $this->situable->surfacePlancher + $this->situable->surfaceMezzanine ;
    	}
    }
    public function getSurfacePrincipaleAttribute()
    {
    	return ($this->situable->surfaceApp != null ) ? $this->situable->surfaceApp : $this->situable->surfacePlancher ;
    }    
    public function getSurfaceSecondaireAttribute()
    {
    	return ($this->situable->surfaceTerrasse != null ) ? $this->situable->surfaceTerrasse : $this->situable->surfaceMezzanine ;
    }   

    public function getSurfacePrincipaleTextAttribute()
    {
    	return ($this->situable->surfaceApp != null ) ? 'S. Couvert' : 'S. Plancher' ;
    }    
    public function getSurfaceSecondaireTextAttribute()
    {
    	return ($this->situable->surfaceTerrasse != null ) ? 'S. Terrasse' : 'S. Mezzanine' ;
    }  

    public function getSurfaceDetailAttribute()
    {
    	return $this->surfacePrincipaleText . ' : ' . $this->surfacePrincipale . 'm<sup>2</sup> | ' .
    	$this->surfaceSecondaireText . ' : ' . $this->surfaceSecondaire . 'm<sup>2</sup>'
    	;
    } 

    public function getEtageAttribute()
    {
    	return ($this->situable->etage != null ) ? 'R+' . $this->situable->etage : 'RDC' ;
    }    

    public function getTrancheAttribute()
    {
        return $this->situable->immeuble->tranche ;

    }

    public function getImmeubleAttribute()
    {
        return $this->situable->immeuble ;

    }

    public function getTypeAttribute()
    {
        return $this->situable_type ;

    }    

}
