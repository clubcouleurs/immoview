
                <table>
                  <thead>
                    <tr>
                      <th width="30" bgcolor="#ffdc73">Vente</th>
                      <th width="15" bgcolor="#ffdc73">Date du dossier</th>
                      @if($constructible != 'lot')
                      <th width="15" bgcolor="#ffdc73">Frais</th>
                      @endif
                      <th width="25" bgcolor="#ffdc73">Client</th>
                      <th width="25" bgcolor="#ffdc73">CIN Client</th>
                      <th width="25" bgcolor="#ffdc73">Tél Client</th>
                      <th width="25" bgcolor="#ffdc73">Adresse Client</th>
                      <th width="25" bgcolor="#ffdc73">Actes de réservation</th>
                      <th width="15" bgcolor="#ffdc73">Com</th>
                      <th width="18" bgcolor="#ffdc73">Total Paiements</th>
                      @if($constructible == 'lot')
                      <th width="15" bgcolor="#ffdc73">Prix m2</th>
                      @endif
                      <th width="18" bgcolor="#ffdc73">Prix Total</th>
                      <th width="10" bgcolor="#ffdc73">Taux</th>
                      <th width="10" bgcolor="#ffdc73">Tranche</th>
                      <th width="10" bgcolor="#ffdc73">Surface</th>
                      <th width="10" bgcolor="#ffdc73">Etage</th>
                    </tr>
                  </thead>
                  <tbody>

                  @foreach ($dossiers as $dossier)
                    <tr
                    {{($dossier->isVente)? '' : 'bgcolor="yellow"'}}
                    >
                      <td>
                          {{ ucfirst($dossier->produit->constructible_type) }} N°
                          {{ $dossier->produit->constructible->num }}

                          @if(!$dossier->isVente)

                          (RESERVATION)
                          @endif
                            
                      </td>
                      <td>
                        {{ $dossier->date }}
                          @if(!$dossier->isVente)
                        <br>
                          Rappeler le client :
                      @isset($dossier->delais->last()->date)
                      @if(Carbon\Carbon::today() >= $dossier->delais->last()->date)

                {{$dossier->delais->last()->date->diffForHumans()}}
                      @else

                {{$dossier->delais->last()->date->diffForHumans()}}
                      @endif
                      @else
                Aucune date n'est définie
                      @endisset
                          @endif                        
                      </td>
                      @if($dossier->produit->constructible_type != 'lot')

                      <td>

                          {{ number_format($dossier->frais,2,",",".") }} 

                      </td>
                      @endif

                                                                    
                      <td>
                        @foreach ($dossier->clients as $client)
                        {{$client->nom}} {{$client->prenom}} | 
                        @endforeach                      
                      </td>
                      <td>
                        @foreach ($dossier->clients as $client)
                        {{$client->cin}} | 
                        @endforeach          
                      </td>
                      <td>
                        @foreach ($dossier->clients as $client)
                        {{$client->mobile}} | 
                        @endforeach          
                      </td>
                      <td>
                        @foreach ($dossier->clients as $client)
                        {{$client->adresse}} | 
                        @endforeach          
                      </td>                                            
                      <td>
                        {{ $dossier->actesRetour }}
                      </td>                     
                      <td>
                        {{ substr($dossier->user->name, 0, strpos($dossier->user->name, ' ')+2) }}.
                      </td>                      
                      <td>

                          {{number_format($dossier->totalPaiementsV,2,",",".")}} 
                      </td>

                      @if($dossier->produit->constructible_type == 'lot')

                      <td>

                          {{ number_format($dossier->produit->prixM2Indicatif,2,",",".") }} 

                      </td>
                      @endif

                      <td>
                           {{ number_format($dossier->produit->totalDefinitif,2,",",".")}} 
                      </td>     

                      <td>
                          {{ $dossier->tauxPaiementV }} %
                      </td>      
                      <td>
                          {{ $dossier->produit->tranche }}
                      </td>  
                      <td>
                          {{ $dossier->produit->constructible->surface }}
                      </td>                        
                      <td>
                          {{ $dossier->produit->etage }}
                      </td>                                                                             
                    </tr>
                    @endforeach
                  </tbody>
                </table>
