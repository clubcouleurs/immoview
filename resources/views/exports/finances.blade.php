            @foreach($constructibles as $header => $constructible)
                <table>
                  <thead>
                    <tr height="25" valign="center">
                      <th bgcolor="{{$color[$loop->index]}}" width="15">Tranche</th>

                      <th bgcolor="{{$color[$loop->index]}}" width="22">Nombre de {{$header}}</th>

                      <th bgcolor="{{$color[$loop->index]}}" width="20">{{$header}} Réservés</th>

                      <th bgcolor="{{$color[$loop->index]}}" width="20">Superficie Totale</th>

                      <th bgcolor="{{$color[$loop->index]}}" width="20">Superficie Réservée</th>

                      <th bgcolor="{{$color[$loop->index]}}" width="20">Taux Réservation</th>

                      <th bgcolor="{{$color[$loop->index]}}" width="20">C.A Prévisionnel</th>

                      <th bgcolor="{{$color[$loop->index]}}" width="20">C.A Réservé</th>

                      <th bgcolor="{{$color[$loop->index]}}" width="20">Taux réalisation CA</th>

                      <th bgcolor="{{$color[$loop->index]}}" width="20">Montant Avances Versées</th>

                      <th bgcolor="{{$color[$loop->index]}}" width="20">30% du CA Réservé</th>

                      <th bgcolor="{{$color[$loop->index]}}" width="20">Taux d'Avance</th>

                      <th bgcolor="{{$color[$loop->index]}}" width="25">Reliquat Avance Non Encaissées</th>

                      <th bgcolor="{{$color[$loop->index]}}" width="20">Reliquat du CA Réservé</th>

                    </tr>
                  </thead>
                  <tbody
                  >
                  @foreach ($$constructible as $key => $data)
                    <tr align="center">

                      <td bgcolor="{{$color[$loop->parent->index]}}" >
                        <p>
                          {{$key}}
                        </p>
                      </td>    

                      <td>
                        <p>
                          {{$data['total'] }}
                        </p>
                      </td>

                      <td>
                        <p>
                          {{$data['nbrVendus'] }}

                        </p>
                      </td>

                      <td>
                        <p>
                          {{$data['totalSurface'] }} m<sup>2</sup>

                        </p>
                      </td>

                      <td>
                        <p>
                          {{$data['totalSurfaceReserve'] }} m<sup>2</sup>

                        </p>
                      </td>                      

                      <td>
                        <p>
                          {{$data['tauxReservation'] }}%

                        </p>
                      </td>

                      <td>
                        <p>
                          {{number_format($data['totalCA'],2,",",".") }}

                        </p>
                      </td>

                      <td>
                        <p>
                          {{number_format($data['CaReserve'],2,",",".") }}

                        </p>
                      </td>

                      <td>
                        <p>
                          {{$data['tauxRealisationCA'] }}%

                        </p>
                      </td>

                      <td>
                        <p>
                          {{number_format($data['totalPaiementsV'],2,",",".") }} 

                        </p>
                      </td>

                      <td>
                        <p>
                          {{number_format($data['avance30'],2,",",".") }}

                        </p>
                      </td>

                      <td >
                        <p>
                          {{$data['tauxPaiement'] }}%

                        </p>
                      </td>

                      <td >
                        <p>
                          {{number_format($data['reliquatDu30Pourcent'],2,",",".") }} 

                        </p>        
                      </td>

                      <td >
                        <p>
                          {{number_format($data['reliquat'],2,",",".") }} 

                        </p>
                      </td>

                    </tr>

                    @endforeach

                    <!-- la ligne des totaux -->

                    <tr>

                      <td bgcolor="#dbdbdb">
                        <p>
                          Total
                        </p>
                      </td>

                      <td bgcolor="#dbdbdb">
                        <p>
                          @php
                            echo $$header['total']; 
                          @endphp
                        </p>
                      </td>

                      <td bgcolor="#dbdbdb">
                        <p>
                          @php
                            echo $$header['nbrVendus']; 
                          @endphp
                        </p>
                      </td>

                      <td bgcolor="#dbdbdb">
                        <p>
                          @php
                            echo $$header['totalSurface']; 
                          @endphp
                          m<sup>2</sup>
                        </p>
                      </td>

                      <td  bgcolor="#dbdbdb">
                        <p>
                          @php
                            echo $$header['totalSurfaceReserve']; 
                          @endphp
                          m<sup>2</sup>
                        </p>
                      </td>                      

                      <td  bgcolor="#dbdbdb">
                        <p>
                          @php
                            echo $$header['tauxReservation']; 
                          @endphp
                          %
                        </p>
                      </td>

                      <td  bgcolor="#dbdbdb">
                        <p>
                          @php
                            echo number_format($$header['totalCA'],2,",","."); 
                          @endphp
                          Dhs
                        </p>
                      </td>

                      <td  bgcolor="#dbdbdb">
                        <p>
                          @php
                            echo number_format($$header['CaReserve'],2,",","."); 
                          @endphp
                          Dhs
                        </p>
                      </td>

                      <td  bgcolor="#dbdbdb">
                        <p>
                          @php
                            echo $$header['tauxRealisationCA']; 
                          @endphp
                          %
                        </p>
                      </td>

                      <td  bgcolor="#dbdbdb">
                        <p>
                          @php
                            echo number_format($$header['totalPaiementsV'],2,",","."); 
                          @endphp
                          Dhs
                        </p>
                      </td>

                      <td bgcolor="#dbdbdb">
                        <p>
                          @php
                            echo number_format($$header['avance30'],2,",","."); 
                          @endphp
                          Dhs
                        </p>
                      </td>

                      <td bgcolor="#dbdbdb">
                        <p>
                          @php
                            echo $$header['tauxPaiement']; 
                          @endphp
                          %
                        </p>
                      </td>

                      <td bgcolor="#dbdbdb">
                        <p>
                          @php
                            echo number_format($$header['reliquatDu30Pourcent'],2,",","."); 
                          @endphp
                          Dhs
                        </p>        
                      </td>

                      <td bgcolor="#dbdbdb">
                        <p>
                          @php
                            echo number_format($$header['reliquat'],2,",","."); 
                          @endphp
                          Dhs
                        </p>
                      </td>

                    </tr>

                  </tbody>
                </table>
            @endforeach

