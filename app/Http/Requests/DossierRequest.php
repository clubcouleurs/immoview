<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DossierRequest extends FormRequest
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
        $numDossier = (isset($this->dossier->num)) ? $this->dossier->num : Null ;

        return [
            'num' => 'sometimes|required|numeric',
            'num' => 'unique:dossiers,num,'.$numDossier,
            'date' => 'date|required',
            'frais' => 'required|numeric',
            'detail' => 'string|nullable',         
            'client' => 'required|integer',
            'produit' => 'required|integer',

        ];
    }
    public function messages()
    {
        return [
            'num.unique' => 'Ce numéro de dossier existe déjà',
            'num.required' => 'Il faut un numéro à ce dossier',
            'date.required' => 'Il faut une date à ce dossier',
            'date.date' => 'Il faut une date à ce dossier',
            'frais.required' => 'Il faut saisir les frais de ce dossier',
            'frais.numeric' => 'Les frais du dossier doivent être en numéraire',

        ];
    } 
}
