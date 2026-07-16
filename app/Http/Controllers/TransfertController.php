<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Dossier;
use App\Models\Produit;
use App\Models\Transfert;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TransfertController extends Controller
{

    public function index(Dossier $dossier)
    {

        return view('dossiers.transfert' , [
        'clients' => Client::where('activer', '=', 1 )
                            ->orderby('nom', 'desc')
                            ->get(),
            'dossier'   => $dossier,
            'produit'   => $dossier->produit,
            'client'    => $dossier->client,
            'transfert' => $dossier->transferts()->enAttente()->latest()->first(),
            'dataRecap' => $dossier->produit->recap
        ]);
    }

    // public function index(Dossier $dossier)
    // {
    //     $transfertEnAttente = Transfert::enAttente()->where('dossier_id', $dossier->id)->latest()->first();

    //     if ($transfertEnAttente) {
    //         return view('dossiers.transfert.gerer', [
    //             'dossier' => $dossier,
    //             'transfert' => $transfertEnAttente,
    //         ]);
    //     }

    //     $idsClientsActuels = $dossier->clients->pluck('id');
    //     $clients = Client::whereNotIn('id', $idsClientsActuels)->get();

    //     return view('dossiers.transfert.creer', compact('dossier', 'clients'));
    // }

    public function genererDocument(Request $request, Dossier $dossier)
    {
        $request->validate([
            'client' => 'required|array|min:1',
            'clients.*' => 'exists:clients,id',
        ]);

        $nouveauxClients = Client::whereIn('id', $request['client'])->get();

        $pdf = Pdf::loadView('pdf.recaps.transfert', [
            'dossier' => $dossier,
            'nouveauxClients' => $nouveauxClients,
        ]);

        $nomFichier = "demande-transfert-{$dossier->id}-".time().".pdf";
        $cheminGenere = "documents/transferts/{$nomFichier}";
        Storage::disk('public')->put($cheminGenere, $pdf->output());

        $transfert = Transfert::create([
            'batch_id' => (string) Str::uuid(),
            'dossier_id' => $dossier->id,
            'nouveaux_clients' => $request['client'],
            'document_path' => $cheminGenere,
            'transfere_by' => Auth::id(),
        ]);
    return redirect()
        ->route('dossiers.transfert.generer', $dossier)
        ->with('telecharger_pdf', Storage::disk('public')->url($cheminGenere));


        // return $pdf->download("demande-transfert-{$dossier->id}.pdf");
    }


    public function finaliser(Request $request, Dossier $dossier, Transfert $transfert)
    {

        $request->validate([
            'document' => 'required|file|mimes:pdf,jpg,png|max:10240',
        ]);

        DB::transaction(function () use ($request, $dossier, $transfert) {
            $documentPath = $request->file('document')->store('documents/transferts', 'public');

            $transfert->update(['document_legalise_path' => $documentPath]);

            $oldClients = $dossier->clients()->pluck('clients.id')->toArray();
            $newClients = Client::whereIn('id', $transfert->nouveaux_clients)->pluck('clients.id')->toArray();
            
            // array_diff compare les deux tableaux et voit s'il y a des différences
            $hasChanges = (count(array_diff($oldClients, $newClients)) > 0) || (count(array_diff($newClients, $oldClients)) > 0);

            // 2. Si le client a effectivement changé, on prépare l'historique
            if ($hasChanges && !empty($newClients)) {
                
                $batchId = (string) \Illuminate\Support\Str::uuid(); 
                $timestamp = now()->toDateTimeString();
                foreach ($oldClients as $oldClient)
                {
                    foreach($newClients as $newClient)
                    {
                        \Illuminate\Support\Facades\DB::table('client_dossier_histories')->insert( [
                            'batch_id'       => $batchId,
                            'dossier_id'     => $dossier->id,
                            'old_client_id'  => $oldClient,
                            'new_client_id'  => $newClient,
                            'transferred_at' => $timestamp,
                        ]);
                    }
                }
                        $dossier->transferred_at = $timestamp ;
            }
            $dossier->clients()->detach();            
            $dossier->clients()->attach($newClients); 
        });
       
            $dossier->update(); 
        return redirect()->route('dossiers.index', ['constructible' => $dossier->produit->constructible_type])
                        ->with('success', 'Transfert finalisé avec succès.');
    }



public function telechargerDocument(Dossier $dossier, Transfert $transfert)
{
    if (!$transfert->document_path || !Storage::disk('public')->exists($transfert->document_path)) {
        abort(404, 'Document introuvable.');
    }

    return Storage::disk('public')->download(
        $transfert->document_path,
        "demande-transfert-{$dossier->id}.pdf"
    );
}


    public function supprimer(Dossier $dossier, Transfert $transfert)
    {
        $transfert->delete();

        return redirect()->route('dossiers.index', ['constructible' => $dossier->produit->constructible_type])
                        ->with('success', 'Transfert annulé.');
    }
}