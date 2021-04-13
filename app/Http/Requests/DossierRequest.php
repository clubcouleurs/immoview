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
        return [
            'date' => 'sometimes|date|required',
            'delai' => 'sometimes|date|required', //|after:today',

            'frais' => 'sometimes|required|numeric',
            'detail' => 'string|nullable',         
            'client.*' => 'required|integer|exists:clients,id',
            'produit' => 'sometimes|required|integer|exists:produits,id',
            'actePj' => 'sometimes|required|max:5000|mimetypes:application/pdf,image/png,image/jpeg,image/tiff,image/gif',
            'isVente'    => 'sometimes|required|boolean',


        ];
    }
    public function messages()
    {
        return [
            'date.required' => 'Il faut une date à ce dossier',
            'date.date' => 'Il faut une date à ce dossier',
            'frais.required' => 'Il faut saisir les frais de ce dossier',
            'frais.numeric' => 'Les frais du dossier doivent être en numéraire',
            'delai.after' => 'La date du délai doit être une date postérieure à celle d\'aujourd\'hui',

        ];
    } 
}
