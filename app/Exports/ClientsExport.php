<?php

namespace App\Exports;

use App\Models\Client;
use App\Models\Visite;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Facades\Excel;


class ClientsExport implements FromView
{
    protected $request;

 function __construct($request) {
        $this->request = $request;
 }
    /**
    * @return \Illuminate\Support\Collection
    */
	public function view(): View
    {
        if (! Gate::allows('voir clients')) {
                abort(403);
        }         
        $activer = (isset($this->request['activer'])) ? $this->request['activer'] : 1 ;

        $clientsAll = Client::with('dossiers')
                            ->where('activer', '=', $activer )
                            ->orderby('created_at', 'desc')
                            ->get();

        //recherche par nom, prénom ou CIN client
        if (isset($this->request['client']) && $this->request['client'] != '' ) {
            $value = strtolower($this->request['client']) ;

            $clientsAll = $clientsAll->filter(function ($item) use ($value)  {
            $client = strtolower(trim($item->cin . ' ' . $item->nom . ' ' . $item->prenom . ' ' ));

                    if (strpos($client , $value) !== false) {
                        return true;
                    }
                        return false;
            });                

        } 
        return view('exports.clients', [
            'clients'              => $clientsAll,
            'totalClients'         => $clientsAll->count(),
            'activer'          => $activer,
            'SearchByClient'   => '',
        ]);
    }
}
