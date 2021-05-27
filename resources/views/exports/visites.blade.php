                <table>
                  <thead>
                    <tr>
                      <th width="15" bgcolor="#ffdc73">N° Visite</th>
                      <th width="15" bgcolor="#ffdc73">Type</th>
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
                      <td bgcolor={{($visite->typeContact == 'appel') ? '#d1fae5' : '#ffffff'}}>
                              {{$visite->id }} 
                      </td>
                      <td bgcolor={{($visite->typeContact == 'appel') ? '#d1fae5' : '#ffffff'}}>

                              {{($visite->typeContact == 'appel') ? 'appel' : 'visite'}} 
                      </td>                      
                      <td bgcolor={{($visite->typeContact == 'appel') ? '#d1fae5' : '#ffffff'}}>

                        {{ $visite->date }}
                      </td>
                      <td bgcolor={{($visite->typeContact == 'appel') ? '#d1fae5' : '#ffffff'}}>
                          {{ $visite->client->nom }} {{ $visite->client->prenom }}
                        </td>
							<td bgcolor={{($visite->typeContact == 'appel') ? '#d1fae5' : '#ffffff'}}>
								{{ $visite->client->mobile}}
							</td>
                      
                      <td bgcolor={{($visite->typeContact == 'appel') ? '#d1fae5' : '#ffffff'}}>
                        {{ $visite->interet}}
                      </td>   
                      <td bgcolor={{($visite->typeContact == 'appel') ? '#d1fae5' : '#ffffff'}}>
                        {{ $visite->user->name}}
                      </td>                                          
                      <td bgcolor={{($visite->typeContact == 'appel') ? '#d1fae5' : '#ffffff'}}>
                          {{ $visite->detail}}
                      </td>
                      <td bgcolor={{($visite->typeContact == 'appel') ? '#d1fae5' : '#ffffff'}}>
                        {{$visite->remarqueClient}}
                      </td>
                      <td bgcolor={{($visite->typeContact == 'appel') ? '#d1fae5' : '#ffffff'}}>
                        {{ $visite->source }} 
                      </td>                      
                    </tr>
                    @endforeach
                  </tbody>
                </table>
