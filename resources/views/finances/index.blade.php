<x-master>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <h2
              class="my-6 text-4xl font-semibold text-black dark:text-gray-200"
            >
              Récapitulatifs

            </h2>
            @foreach($constructibles as $header => $constructible)
<hr>  
            <h3
              class="my-6 text-lg font-semibold text-black dark:text-gray-200"
            >
              Récapitulatif des {{$header}}

            </h3>
            @if($$constructible->count() == 0)
                        <p class="text-xs text-black mb-4">
                          Aucune donnée à afficher.
                        </p>            
              @continue
            @endif
            <!-- New Table -->
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
              <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap table-auto">
                  <thead>
                    <tr
                      class="text-xs font-semibold bg-{{$color[$loop->index]}}-300 tracking-wide text-left text-black border  dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="py-3 bg-{{$color[$loop->index]}}-400">Tranche</th>

                      @can('afficher nombre ' . $constructible)
                      <th class="py-3">Nombre de {{$header}}</th>
                      @endcan

                      @can('afficher ' . $constructible . ' réservés')
                      <th class="py-3">{{$header}} Réservés</th>
                      @endcan

                      @can('afficher superficie totale '. $constructible)
                      <th class="py-3">Superficie Totale</th>
                      @endcan

                      @can('afficher superficie réservée '. $constructible)
                      <th class="py-3">Superficie Réservée</th>
                      @endcan

                      @can('afficher taux réservation ' . $constructible)
                      <th class="py-3">Taux Réservation</th>
                      @endcan

                      @can('afficher CA prévisionnel '. $constructible)
                      <th class="py-3">C.A Prévisionnel</th>
                      @endcan

                      @can('afficher CA réservé '. $constructible)
                      <th class="py-3">C.A Réservé</th>
                      @endcan

                      @can('afficher taux de réalisation CA '. $constructible)
                      <th class="py-3">Taux réalisation CA</th>
                      @endcan

                      @can('afficher montant avances versées '. $constructible)
                      <th class="py-3">Montant Avances Versées</th>
                      @endcan

                      @can('afficher 30% du CA réservé '. $constructible)
                      <th class="py-3">30% du CA Réservé</th>
                      @endcan

                      @can('afficher taux avance '. $constructible)
                      <th class="py-3">Taux d'Avance</th>
                      @endcan

                      @can('afficher reliquat avance non encaissée '. $constructible)
                      <th class="py-3">Reliquat Avance Non Encaissées</th>
                      @endcan

                      @can('afficher reliquat du CA réservé '. $constructible)
                      <th class="py-3">Reliquat du CA Réservé</th>
                      @endcan

<!--                  @can('afficher 70% du CA total '. $constructible)
                      <th class="py-3">70% du CA total</th>
                      @endcan -->



                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >
                  @foreach ($$constructible as $key => $data)
                    <tr class="text-black dark:text-gray-400">

                      <td class="px-1 py-3 bg-{{$color[$loop->parent->index]}}-300">
                        <p class="text-xs text-black dark:text-gray-400">
                          {{$key}}
                        </p>
                      </td>    

                      @can('afficher nombre '. $constructible)
                      <td class="px-1 py-3">
                        <p class="text-xs text-black dark:text-gray-400">
                          {{$data['total'] }}
                        </p>
                      </td>
                      @endcan

                      @can('afficher '. $constructible .' réservés')
                      <td class="px-1 py-3">
                        <p class="text-xs text-black dark:text-gray-400">
                          {{$data['nbrVendus'] }}

                        </p>
                      </td>
                      @endcan

                      @can('afficher superficie totale '. $constructible)
                      <td class="px-1 py-3">
                        <p class="text-xs text-black dark:text-gray-400">
                          {{$data['totalSurface'] }} m<sup>2</sup>

                        </p>
                      </td>
                      @endcan

                      @can('afficher superficie réservée '. $constructible)
                      <td class="px-1 py-3">
                        <p class="text-xs text-black dark:text-gray-400">
                          {{$data['totalSurfaceReserve'] }} m<sup>2</sup>

                        </p>
                      </td>                      
                      @endcan

                      @can('afficher taux réservation '. $constructible)
                      <td class="px-1 py-3">
                        <p class="text-xs text-black dark:text-gray-400">
                          {{$data['tauxReservation'] }}%

                        </p>
                      </td>
                      @endcan
                    
                      @can('afficher CA prévisionnel '. $constructible)
                      <td class="px-1 py-3">
                        <p class="text-xs text-black dark:text-gray-400">
                          {{numberFormat($data['totalCA']) }} Dhs

                        </p>
                      </td>
                      @endcan

                      @can('afficher CA réservé '. $constructible)
                      <td class="px-1 py-3">
                        <p class="text-xs text-black dark:text-gray-400">
                          {{numberFormat($data['CaReserve']) }} Dhs

                        </p>
                      </td>
                      @endcan
                                
                      @can('afficher taux de réalisation CA '. $constructible)
                      <td class="px-1 py-3">
                        <p class="text-xs text-black dark:text-gray-400">
                          {{$data['tauxRealisationCA'] }}%

                        </p>
                      </td>
                      @endcan
                    
                      @can('afficher montant avances versées '. $constructible)
                      <td class="px-1 py-3">
                        <p class="text-xs text-black dark:text-gray-400">
                          {{numberFormat($data['totalPaiementsV']) }} Dhs

                        </p>
                      </td>
                      @endcan

                      @can('afficher 30% du CA réservé '. $constructible)
                      <td class="px-1 py-3">
                        <p class="text-xs text-black dark:text-gray-400">
                          {{numberFormat($data['avance30']) }} Dhs

                        </p>
                      </td>
                      @endcan

                      @can('afficher taux avance '. $constructible)
                      <td class="px-1 py-3">
                        <p class="text-xs text-black dark:text-gray-400">
                          {{$data['tauxPaiement'] }}%

                        </p>
                      </td>
                      @endcan

                      @can('afficher reliquat avance non encaissée '. $constructible)
                      <td class="px-1 py-3">
                        <p class="text-xs text-black dark:text-gray-400">
                          {{numberFormat($data['reliquatDu30Pourcent']) }} Dhs

                        </p>        
                      </td>
                      @endcan

                      @can('afficher reliquat du CA réservé '. $constructible)
                      <td class="px-1 py-3">
                        <p class="text-xs text-black dark:text-gray-400">
                          {{numberFormat($data['reliquat']) }} Dhs

                        </p>
                      </td>
                      @endcan

<!--                  @can('afficher 70% du CA total '. $constructible)                    
                      <td class="px-1 py-3">
                        <p class="text-xs text-black dark:text-gray-400">
                          {{numberFormat($data['reliquat70Pourcent']) }} Dhs

                        </p>
                      </td> 
                      @endcan -->
                    </tr>

                    @endforeach

                    <!-- la ligne des totaux -->

                    <tr class="text-gray-700 font-bold bg-{{$color[$loop->index]}}-100 dark:text-gray-400">

                      <td class="px-1 py-3 bg-{{$color[$loop->index]}}-300">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          Total
                        </p>
                      </td>
                      @can('afficher nombre '. $constructible)
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo $$header['total']; 
                          @endphp
                        </p>
                      </td>
                      @endcan

                      @can('afficher '. $constructible .' réservés')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo $$header['nbrVendus']; 
                          @endphp
                        </p>
                      </td>
                      @endcan

                      @can('afficher superficie totale '. $constructible)
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo $$header['totalSurface']; 
                          @endphp
                          m<sup>2</sup>
                        </p>
                      </td>
                      @endcan

                      @can('afficher superficie réservée '. $constructible)
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo $$header['totalSurfaceReserve']; 
                          @endphp
                          m<sup>2</sup>
                        </p>
                      </td>                      
                      @endcan

                      @can('afficher taux réservation '. $constructible)
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo $$header['tauxReservation']; 
                          @endphp
                          %
                        </p>
                      </td>
                      @endcan
                    
                      @can('afficher CA prévisionnel '. $constructible)
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo numberFormat($$header['totalCA']); 
                          @endphp
                          Dhs
                        </p>
                      </td>
                      @endcan

                      @can('afficher CA réservé '. $constructible)
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo numberFormat($$header['CaReserve']); 
                          @endphp
                          Dhs
                        </p>
                      </td>
                      @endcan
                                
                      @can('afficher taux de réalisation CA '. $constructible)
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo $$header['tauxRealisationCA']; 
                          @endphp
                          %
                        </p>
                      </td>
                      @endcan
                    
                      @can('afficher montant avances versées '. $constructible)
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo numberFormat($$header['totalPaiementsV']); 
                          @endphp
                          Dhs
                        </p>
                      </td>
                      @endcan

                      @can('afficher 30% du CA réservé '. $constructible)
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo numberFormat($$header['avance30']); 
                          @endphp
                          Dhs
                        </p>
                      </td>
                      @endcan

                      @can('afficher taux avance '. $constructible)
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo $$header['tauxPaiement']; 
                          @endphp
                          %
                        </p>
                      </td>
                      @endcan

                      @can('afficher reliquat avance non encaissée '. $constructible)
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo numberFormat($$header['reliquatDu30Pourcent']); 
                          @endphp
                          Dhs
                        </p>        
                      </td>
                      @endcan

                      @can('afficher reliquat du CA réservé '. $constructible)
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo numberFormat($$header['reliquat']); 
                          @endphp
                          Dhs
                        </p>
                      </td>
                      @endcan

<!--                       @can('afficher 70% du CA total '. $constructible)                    
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo numberFormat($$header['reliquat70Pourcent']); 
                          @endphp
                          Dhs
                        </p>
                      </td> 
                      @endcan -->
                    </tr>

                  </tbody>
                </table>
              </div>

            </div>
            @endforeach

          </div>
        </main>
</x-master>
