<x-master>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <h2
              class="my-6 text-4xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Récapitulatifs

            </h2>
            @foreach($constructibles as $header => $constructible)
<hr>  
            <h3
              class="my-6 text-lg font-semibold text-gray-700 dark:text-gray-200"
            >
              Récapitulatif des {{$header}}

            </h3>
            @if($$constructible->count() == 0)
                        <p class="text-xs text-gray-600 mb-4">
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
                      class="text-xs font-semibold bg-{{$color[$loop->index]}}-300 tracking-wide text-left text-gray-500 border  dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="py-3 bg-{{$color[$loop->index]}}-400">Tranche</th>

                      @can('afficher nombre de constructible')
                      <th class="py-3">Nombre de {{$header}}</th>
                      @endcan

                      @can('afficher constructible réservés')
                      <th class="py-3">{{$header}} Réservés</th>
                      @endcan

                      @can('afficher superficie totale')
                      <th class="py-3">Superficie Totale</th>
                      @endcan

                      @can('afficher superficie réservée')
                      <th class="py-3">Superficie Réservée</th>
                      @endcan

                      @can('afficher taux réservation')
                      <th class="py-3">Taux Réservation</th>
                      @endcan

                      @can('afficher CA prévisionnel')
                      <th class="py-3">C.A Prévisionnel</th>
                      @endcan

                      @can('afficher CA réservé')
                      <th class="py-3">C.A Réservé</th>
                      @endcan

                      @can('afficher taux de réalisation CA')
                      <th class="py-3">Taux réalisation CA</th>
                      @endcan

                      @can('afficher montant avances versées')
                      <th class="py-3">Montant Avances Versées</th>
                      @endcan

                      @can('afficher 30% du CA réservé')
                      <th class="py-3">30% du CA Réservé</th>
                      @endcan

                      @can('afficher taux avance')
                      <th class="py-3">Taux d'Avance</th>
                      @endcan

                      @can('afficher reliquat avance non encaissée')
                      <th class="py-3">Reliquat Avance Non Encaissées</th>
                      @endcan

                      @can('afficher reliquat du CA réservé')
                      <th class="py-3">Reliquat du CA Réservé</th>
                      @endcan

                      @can('afficher 70% du CA total')
                      <th class="py-3">70% du CA total</th>
                      @endcan



                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >
                  @foreach ($$constructible as $key => $data)
                    <tr class="text-gray-700 dark:text-gray-400">

                      <td class="px-1 py-3 bg-{{$color[$loop->parent->index]}}-300">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          {{$key}}
                        </p>
                      </td>    

                      @can('afficher nombre de constructible')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          {{$data['total'] }}
                        </p>
                      </td>
                      @endcan

                      @can('afficher constructible réservés')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          {{$data['nbrVendus'] }}

                        </p>
                      </td>
                      @endcan

                      @can('afficher superficie totale')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          {{$data['totalSurface'] }} m<sup>2</sup>

                        </p>
                      </td>
                      @endcan

                      @can('afficher superficie réservée')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          {{$data['totalSurfaceReserve'] }} m<sup>2</sup>

                        </p>
                      </td>                      
                      @endcan

                      @can('afficher taux réservation')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          {{$data['tauxReservation'] }}%

                        </p>
                      </td>
                      @endcan
                    
                      @can('afficher CA prévisionnel')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          {{number_format($data['totalCA']) }} Dhs

                        </p>
                      </td>
                      @endcan

                      @can('afficher CA réservé')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          {{number_format($data['CaReserve']) }} Dhs

                        </p>
                      </td>
                      @endcan
                                
                      @can('afficher taux de réalisation CA')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          {{$data['tauxRealisationCA'] }}%

                        </p>
                      </td>
                      @endcan
                    
                      @can('afficher montant avances versées')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          {{number_format($data['totalPaiementsV']) }} Dhs

                        </p>
                      </td>
                      @endcan

                      @can('afficher 30% du CA réservé')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          {{number_format($data['avance30']) }} Dhs

                        </p>
                      </td>
                      @endcan

                      @can('afficher taux avance')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          {{$data['tauxPaiement'] }}%

                        </p>
                      </td>
                      @endcan

                      @can('afficher reliquat avance non encaissée')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          {{number_format($data['reliquatDu30Pourcent']) }} Dhs

                        </p>        
                      </td>
                      @endcan

                      @can('afficher reliquat du CA réservé')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          {{number_format($data['reliquat']) }} Dhs

                        </p>
                      </td>
                      @endcan

                      @can('afficher 70% du CA total')                    
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          {{number_format($data['reliquat70Pourcent']) }} Dhs

                        </p>
                      </td> 
                      @endcan
                    </tr>

                    @endforeach

                    <!-- la ligne des totaux -->

                    <tr class="text-gray-700 font-bold bg-{{$color[$loop->index]}}-100 dark:text-gray-400">

                      <td class="px-1 py-3 bg-{{$color[$loop->index]}}-300">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          Total
                        </p>
                      </td>    

                      @can('afficher nombre de constructible')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo $$header['total']; 
                          @endphp
                        </p>
                      </td>
                      @endcan

                      @can('afficher constructible réservés')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo $$header['nbrVendus']; 
                          @endphp
                        </p>
                      </td>
                      @endcan

                      @can('afficher superficie totale')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo $$header['totalSurface']; 
                          @endphp
                          m<sup>2</sup>
                        </p>
                      </td>
                      @endcan

                      @can('afficher superficie réservée')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo $$header['totalSurfaceReserve']; 
                          @endphp
                          m<sup>2</sup>
                        </p>
                      </td>                      
                      @endcan

                      @can('afficher taux réservation')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo $$header['tauxReservation']; 
                          @endphp
                          %
                        </p>
                      </td>
                      @endcan
                    
                      @can('afficher CA prévisionnel')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo number_format($$header['totalCA']); 
                          @endphp
                          Dhs
                        </p>
                      </td>
                      @endcan

                      @can('afficher CA réservé')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo number_format($$header['CaReserve']); 
                          @endphp
                          Dhs
                        </p>
                      </td>
                      @endcan
                                
                      @can('afficher taux de réalisation CA')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo $$header['tauxRealisationCA']; 
                          @endphp
                          %
                        </p>
                      </td>
                      @endcan
                    
                      @can('afficher montant avances versées')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo number_format($$header['totalPaiementsV']); 
                          @endphp
                          Dhs
                        </p>
                      </td>
                      @endcan

                      @can('afficher 30% du CA réservé')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo number_format($$header['avance30']); 
                          @endphp
                          Dhs
                        </p>
                      </td>
                      @endcan

                      @can('afficher taux avance')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo $$header['tauxPaiement']; 
                          @endphp
                          %
                        </p>
                      </td>
                      @endcan

                      @can('afficher reliquat avance non encaissée')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo number_format($$header['reliquatDu30Pourcent']); 
                          @endphp
                          Dhs
                        </p>        
                      </td>
                      @endcan

                      @can('afficher reliquat du CA réservé')
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo number_format($$header['reliquat']); 
                          @endphp
                          Dhs
                        </p>
                      </td>
                      @endcan

                      @can('afficher 70% du CA total')                    
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo number_format($$header['reliquat70Pourcent']); 
                          @endphp
                          Dhs
                        </p>
                      </td> 
                      @endcan
                    </tr>

                  </tbody>
                </table>
              </div>

            </div>
            @endforeach

          </div>
        </main>
</x-master>
