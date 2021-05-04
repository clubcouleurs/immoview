
                <table>
                  <thead>
                    <tr>
                      <th width="30" bgcolor="#ffdc73">N° produit Immo</th>
                      <th width="15" bgcolor="#ffdc73">Montant</th>
                      <th width="15" bgcolor="#ffdc73">Date du paiement</th>
                      <th width="30" bgcolor="#ffdc73">Client</th>
                      <th width="15" bgcolor="#ffdc73">Banque</th>
                      <th width="15" bgcolor="#ffdc73">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($paiements as $p)
                  <!-- @ foreach($produit->paiements as $p) -->
                    <tr>
                      <td>
                        {{ $p->dossier->produit->constructible_type }} N° {{ $p->dossier->produit->constructible->num }}

                      </td>
                      <td>
                        {{ $p->montant }}
                      </td>
                      <td>
                        @php
                        $date=date_create($p->date);
                        @endphp
                        {{ date_format($date,"d/m/Y") }}

                      </td>    

                      <td>
                            @foreach($p->dossier->clients as $client)
                            {{ $client->nom}} {{ $client->prenom}} <br>
                            @endforeach  
                      </td> 
                      <td>
                        @isset($p->banque)
                            {{$p->banque->abreviation}}
                        @endisset
                      </td>                       
                      <td>
                    {{($p->valider)? 'Oui' : 'Non'}}
                  </td>
                     
                    </tr>
                    @endforeach
                  </tbody>
                </table>
