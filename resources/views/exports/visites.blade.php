                <table>
                  <thead>
                    <tr>
                      <th width="15" bgcolor="#ffdc73">N° Visite</th>
                      <th width="15" bgcolor="#ffdc73">Date de la visite</th>
                      <th width="25" bgcolor="#ffdc73">Prospect</th>
                      <th width="15" bgcolor="#ffdc73">Tél</th>
                      <th width="15" bgcolor="#ffdc73">Intéressez par</th>        
                      <th width="15" bgcolor="#ffdc73">Commercial</th>                      
                      <th width="25" bgcolor="#ffdc73">Détails de la visite</th>
                      <th width="25" bgcolor="#ffdc73">Remarques du prospect</th>
                      <th width="15" bgcolor="#ffdc73">Source</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($visites as $visite)
                    <tr>
                      <td>
                              {{$visite->id }} 
                      </td>
                      <td>

                        {{ $visite->date }}
                      </td>
                      <td>
                          {{ $visite->client->nom }} {{ $visite->client->prenom }}
                        </td>
							<td>
								{{ $visite->client->mobile}}
							</td>
                      
                      <td>
                        {{ $visite->interet}}
                      </td>   
                      <td>
                        {{ $visite->user->name}}
                      </td>                                          
                      <td>
                          {{ $visite->detail}}
                      </td>
                      <td>
                        {{$visite->remarqueClient}}
                      </td>
                      <td>
                        {{ $visite->source }} 
                      </td>                      
                    </tr>
                    @endforeach
                  </tbody>
                </table>
