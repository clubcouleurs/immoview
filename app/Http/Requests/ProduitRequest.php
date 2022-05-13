<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProduitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $idLot = (isset($this->lot->id)) ? $this->lot->id : Null ;
        $idApp = (isset($this->appartement->id)) ? $this->appartement->id : Null ;
        $idMag = (isset($this->magasin->id)) ? $this->magasin->id : Null ;
        $idBur = (isset($this->office->id)) ? $this->office->id : Null ;
        $idBox = (isset($this->box->id)) ? $this->box->id : Null ;

        return [
            // 'numLot' => 'sometimes|required|numeric',
            // 'numLot' => 'unique:lots,num,'.$idLot,

            // 'numApp' => 'sometimes|required|numeric',
            // 'numApp' => 'unique:appartements,num,'.$idApp,        

            // 'numMag' => 'sometimes|required|numeric',
            // 'numMag' => 'unique:magasins,num,'.$idMag, 

            // 'numBur' => 'sometimes|required|numeric',
            // 'numBur' => 'unique:offices,num,'.$idBur, 

            // 'numBox' => 'sometimes|required|numeric',
            // 'numBox' => 'unique:boxes,num,'.$idBox, 

            'surface' => 'sometimes|required|numeric',
            'surfaceApp' => 'sometimes|required|numeric',
            'surfaceTerrasse' => 'sometimes|required|numeric',

            'surfacePlancher' => 'sometimes|required|numeric',
            'surfaceMezzanine' => 'sometimes|required|numeric',

            'type' => 'sometimes|required|string',
            'etage' => 'sometimes|required|integer',
            'description' => 'string|nullable',
            'titre_foncierr' => 'string|nullable',                  
            'etatProduit' => 'sometimes|required|numeric',
            'prixM2Indicatif' => 'sometimes|required|numeric|nullable',
            'prixM2Definitif' => 'numeric|nullable',
            'remise' => 'numeric|nullable',
            'voies' => 'array',

            'chambres' => 'sometimes|required|numeric',
            'cuisines' => 'sometimes|required|numeric',
            'sdbs' => 'sometimes|required|numeric',
            'toilettes' => 'sometimes|required|numeric',
            'extra' => 'sometimes|required|string',


        ];
    }
    public function messages()
    {
        return [
            'numLot.unique' => 'Ce numéro de lot existe déjà',
            'numMag.unique' => 'Ce numéro de magasin existe déjà',
            'numApp.unique' => 'Ce numéro d\' appartement existe déjà',
            'numBur.unique' => 'Ce numéro de bureau existe déjà',
            'numBox.unique' => 'Ce numéro de box existe déjà',

            'surfaceLot.required' => 'Merci de siaisir une surface pour ce lot',
            'surfaceLot.numeric' => 'La surface du lot doit être en chiffre',

            'typeLot' => 'sometimes|required|string',
            'nombreEtagesLot' => 'sometimes|required|integer',
            'descriptionLot' => 'string|nullable',         
            'etatProduit' => 'required|numeric',
            'prixM2Indicatif' => 'required|numeric|nullable',
            'prixM2Definitif' => 'numeric|nullable',
            'remise' => 'numeric|nullable',
            'voies' => 'array',
        ];
    }    
}
