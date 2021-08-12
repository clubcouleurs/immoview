
                <table>
                  <thead>
                    <tr>
                      <th width="20" bgcolor="#ffdc73">N° du lot</th>
                      <th width="20" bgcolor="#ffdc73">Tranche</th>
                         
                      <th width="20" bgcolor="#ffdc73">Surface en m2</th>
                      <th width="20" bgcolor="#ffdc73">Prix m2 Indicatif</th>
                      <th width="20" bgcolor="#ffdc73">Prix de vente indicatif</th>

                      <th width="20" bgcolor="#ffdc73">Prix m2 Définitif</th>
                      <th width="20" bgcolor="#ffdc73">Prix de vente Définitif</th>

                      <th width="20" bgcolor="#ffdc73">Nombre de façades</th>
                      <th width="20" bgcolor="#ffdc73">Etage</th>
                      <th width="20" bgcolor="#ffdc73">Etat</th>
                      <th width="20" bgcolor="#ffdc73">Type produit</th>

                    </tr>
                  </thead>
                  <tbody>

                  @foreach ($appartements as $produit)
                 
                    <tr>
                      <td>{{ $produit->constructible->num }}</td>
                      <td>{{ $produit->constructible->tranche->num }}</td>
                      <td>{{ $produit->constructible->surface }} </td>

                      <td>{{ $produit->prixM2Indicatif }}</td>
                      <td>{{ $produit->totalIndicatif}}</td>
                      <td>{{ $produit->prixM2Definitif }}</td>
                      <td>{{ $produit->totalDefinitif}}</td>                                                                  
                      <td>
                        {{$produit->nombreVoies}}F-{{$produit->quellesVoies}}
                      </td>

                      <td>{{ $produit->constructible->etage }}</td>                      
                      <td>

                          {{ $produit->etiquette->label }}
                      </td>
                      <td>
                        {{ ucfirst($produit->constructible->type) }}
                      </td>

                    </tr>
                    @endforeach
                  </tbody>
                </table>

