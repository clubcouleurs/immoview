                <table>
                  <thead>
                    <tr>
                      <th width="15" bgcolor="#ffdc73">N°</th>

                      <th width="25" bgcolor="#ffdc73">@if($activer==1) Clients @else Prospects @endif</th>
                      
                      @if($activer==1) <th width="5" bgcolor="#ffdc73">N° CIN</th> @endif
                      @if($activer==1) <th width="5" bgcolor="#ffdc73">CIN SCAN</th> @endif

                      @if($activer==1) <th width="5" bgcolor="#ffdc73">Adresse</th> @endif
                      <th width="25" bgcolor="#ffdc73">Mobile</th>
                      
                      <th width="25" bgcolor="#ffdc73">Il est @if($activer==1) client @else prospect @endif ...
                      </th>


                    </tr>
                  </thead>
                  <tbody>

                  @foreach ($clients as $client)
                    <tr>
                        <td>
                          N° {{$client->id }} 

                      </td>                      
                      <td>
                           
                              {{$client->nom }} {{$client->prenom }}
                            </td>

                      @if($activer==1)
                      <td>
                        {{ $client->cin }} 
                      </td>
                      <td>
                        @isset($client->cinPj)
                          Oui
                        @else
                          Aucune pièce jointe
                        @endisset
                      </td> 
                      <td>

                          {{ $client->adresse }}

                      </td>
                      @endif
                      <td>

                          {{ $client->mobile }}
                       
                      </td>                                                                  
                    
                      <td>

                          {{ $client->created_at->diffForHumans()}}
                      </td>

                    </tr>
                    @endforeach
                  </tbody>
                </table>

