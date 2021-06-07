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
                          {{$data['totalCA']}}

                        </p>
                      </td>

                      <td>
                        <p>
                          {{$data['CaReserve']}}

                        </p>
                      </td>

                      <td>
                        <p>
                          {{$data['tauxRealisationCA'] }}%

                        </p>
                      </td>

                      <td>
                        <p>
                          {{$data['totalPaiementsV']}} 

                        </p>
                      </td>

                      <td>
                        <p>
                          {{$data['avance30']}}

                        </p>
                      </td>

                      <td >
                        <p>
                          {{$data['tauxPaiement'] }}%

                        </p>
                      </td>

                      <td >
                        <p>
                          {{$data['reliquatDu30Pourcent']}} 

                        </p>        
                      </td>

                      <td >
                        <p>
                          {{$data['reliquat']}} 

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

                      <td bgcolor="#dbdbdb">
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
                            echo $$header['totalCA']; 
                          @endphp
                          
                        </p>
                      </td>

                      <td  bgcolor="#dbdbdb">
                        <p>
                          @php
                            echo $$header['CaReserve']; 
                          @endphp
                          
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
                            echo $$header['totalPaiementsV']; 
                          @endphp
                          
                        </p>
                      </td>

                      <td bgcolor="#dbdbdb">
                        <p>
                          @php
                            echo $$header['avance30']; 
                          @endphp
                          
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
                            echo $$header['reliquatDu30Pourcent']; 
                          @endphp
                          
                        </p>        
                      </td>

                      <td bgcolor="#dbdbdb">
                        <p>
                          @php
                            echo $$header['reliquat']; 
                          @endphp
                          
                        </p>
                      </td>

                    </tr>

                  </tbody>
                </table>
            @endforeach

