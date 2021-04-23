<x-master>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <h2
              class="my-6 text-4xl font-semibold text-black dark:text-gray-200"
            >
              Etat des stocks

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

                      <th class="py-3">Nombre de {{$header}}</th>

                      <th class="py-3">{{$header}} Vendus</th>

                      <th class="py-3">{{$header}} Réservés</th>

                      <th class="py-3">{{$header}} En Stock</th>

                      <th class="py-3">{{$header}} Bloqués</th>


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

                      <td class="px-1 py-3">
                        <p class="text-xs text-black dark:text-gray-400">
                          {{$data['total'] }}
                        </p>
                      </td>

                      <td class="px-1 py-3">
                        <p class="text-xs text-black dark:text-gray-400">
                          {{$data['vendus'] }}

                        </p>
                      </td>

                      <td class="px-1 py-3">
                        <p class="text-xs text-black dark:text-gray-400">
                          {{$data['reserved'] }}

                        </p>
                      </td>

                      <td class="px-1 py-3">
                        <p class="text-xs text-black dark:text-gray-400">
                          {{$data['stocked'] }}

                        </p>
                      </td>                      

                      <td class="px-1 py-3">
                        <p class="text-xs text-black dark:text-gray-400">
                          {{$data['blocked'] }}

                        </p>
                      </td>
                    </tr>

                    @endforeach

                    <!-- la ligne des totaux -->

                    <tr class="text-gray-700 font-bold bg-{{$color[$loop->index]}}-100 dark:text-gray-400">

                      <td class="px-1 py-3 bg-{{$color[$loop->index]}}-300">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          Total
                        </p>
                      </td>
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo $$header['total']; 
                          @endphp
                        </p>
                      </td>
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo $$header['vendus']; 
                          @endphp
                        </p>
                      </td>
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo $$header['reserved']; 
                          @endphp
                        </p>
                      </td>
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo $$header['stocked']; 
                          @endphp
                        </p>
                      </td>
                      <td class="px-1 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          @php
                            echo $$header['blocked']; 
                          @endphp
                        </p>
                      </td>                                                                                        

                    </tr>

                  </tbody>
                </table>
              </div>

            </div>
            @endforeach

          </div>
        </main>
</x-master>
