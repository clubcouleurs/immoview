<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('concours.form') ;
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomEnfant'      => 'required|string',
            'nomTuteur'      => 'required|string',
            'mobile'       => 'required|numeric|digits_between:10,10|unique:contacts',
            'email'   => 'required|email|unique:contacts',
            'adresse'   => 'required|string',
        ],
        [
            'nomEnfant.required'      => 'Le nom de l\'enfant est obligatoire.',
            'nomTuteur.required'      => 'Le nom du tuteur est obligatoire.',

            'mobile.required'       => 'Le numéro de téléphone est obligatoire.',
            'mobile.numeric'       => 'Le numéro de téléphone n\'est pas valide.',
            'mobile.unique'       => 'Le numéro de téléphone est déjà utilisée.',

            'email.required'       => 'L\'adresse Email est obligatoire.',
            'email.email'       => 'L\'adresse Email n\'est pas valide.',
            'email.unique'       => 'L\'adresse Email est déjà utilisée.',

            'adresse.required'       => 'L\'adresse est obligatoire.',
            'adresse.string'       => 'L\'adresse Email n\'est pas valide.',
        ]);
    	//dd($request) ;
        $contact = new Contact() ;
        $contact->nomEnfant               = $request['nomEnfant'];
        $contact->nomTuteur        = $request['nomTuteur'];
        $contact->mobile   = $request['mobile'];
        $contact->email              = $request['email'];
        $contact->adresse             = $request['adresse'];
        $contact->save();

        return redirect()->action([ContactController::class, 'index'])
        ->with('message','contact ajouté !');
    }

}
