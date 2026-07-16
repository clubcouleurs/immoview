
                <table>
                  <thead>
                    <tr>
                      <th width="20" bgcolor="#ffdc73">N° Place</th>
                      <th width="20" bgcolor="#ffdc73">Tranche|GH</th>
                      <th width="20" bgcolor="#ffdc73">Immeuble</th>
                      <th width="20" bgcolor="#ffdc73">Surface Total (m2)</th>

                      <th width="20" bgcolor="#ffdc73">Prix m2 Indicatif</th>
                      <th width="20" bgcolor="#ffdc73">Prix m2 Définitif</th>
                      <th width="20" bgcolor="#ffdc73">Prix de vente Définitif</th>

                      <th width="20" bgcolor="#ffdc73">Etage</th>
                      <th width="20" bgcolor="#ffdc73">Etat</th>


                    </tr>
                  </thead>
                  <tbody>

                  @foreach ($places as $produit)
                 
                    <tr>
                      <td>{{ $produit->constructible->num }}</td>
                      <td>{{ $produit->constructible->tranche->description }}</td>
                      <td>{{ $produit->constructible->immeuble->num }}</td>
                      <td>{{ $produit->constructible->surface }} </td>

                      <td>{{ $produit->prixM2Indicatif }}</td>
                      <td>{{ $produit->prixM2Definitif }}</td>
                      <td>{{ $produit->totalDefinitif}}</td>                                                                  


                      <td>{{ $produit->constructible->etage }}</td>                      
                      <td>

                          {{ $produit->etiquette->label }}
                      </td>
                   



                    </tr>
                    @endforeach
                  </tbody>
                </table>

