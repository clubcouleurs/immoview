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
        $id = (isset($this->lot->id)) ? $this->lot->id : Null ;
        return [
            'num' => 'sometimes|required|numeric',
            'num' => 'unique:lots,num,'.$id,
            'surfaceLot' => 'sometimes|required|numeric',
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
    public function messages()
    {
        return [
            'num.unique' => 'Ce numéro de lot existe déjà',
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
