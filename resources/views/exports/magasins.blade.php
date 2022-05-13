
                <table>
                  <thead>
                    <tr>
                      <th width="20" bgcolor="#ffdc73">Tranche</th>
                      <th width="20" bgcolor="#ffdc73">Immeuble</th>
                      <th width="20" bgcolor="#ffdc73">Magasins N°</th>
                      <th width="20" bgcolor="#ffdc73">Voie</th>
                      <th width="20" bgcolor="#ffdc73">RDC en m2</th>
                      <th width="20" bgcolor="#ffdc73">Mezz en m2</th>
                      <th width="20" bgcolor="#ffdc73">Sous-Sol en m2</th>
                      <th width="20" bgcolor="#ffdc73">Superficie Total en m2</th>
                      <th width="20" bgcolor="#ffdc73">Prix de vente en DHS</th>
                      <th width="20" bgcolor="#ffdc73">Etat</th>
                      <th width="20" bgcolor="#ffdc73">Superficie Vendable en m2</th>

                      <th width="20" bgcolor="#ffdc73">PU</th>
                      <th width="20" bgcolor="#ffdc73">Prix moyen</th>

                    </tr>
                  </thead>
                  <tbody>

                  @foreach ($magasins as $produit)
                 
                    <tr>
                      <td>{{ $produit->constructible->tranche->num }}</td>
                      <td>{{ $produit->constructible->immeuble->num }}</td>
                      <td>{{ $produit->constructible->num }}</td>
                      <td>Voie {{$produit->quellesVoies}}</td>

                      <td>{{ $produit->constructible->surfacePlancher }}</td> 
                      <td>{{ $produit->constructible->surfaceMezzanine }}</td> 
                      <td>{{ $produit->constructible->surfaceSousSol }}</td>
                      <td>{{ $produit->constructible->surfaceSousSol + $produit->constructible->surfaceMezzanine + $produit->constructible->surfacePlancher}}</td>
                      <td>{{ $produit->totalIndicatif}}</td>
                      <td>{{ $produit->etiquette->label }}</td>
                      <td>{{ $produit->constructible->surfaceSousSol + $produit->constructible->surfacePlancher }}</td>

                      <td>{{ $produit->prixM2Indicatif }}</td>
                      <td>{{ $produit->totalIndicatif / ($produit->constructible->surfaceSousSol + $produit->constructible->surfaceMezzanine + $produit->constructible->surfacePlancher)}}</td>

                    </tr>
                    @endforeach
                  </tbody>
                </table>

