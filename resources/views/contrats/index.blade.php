<x-master>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <div class="flex justify-between">
              <div>
              <h2
                class="my-6 text-4xl font-semibold text-black dark:text-gray-200"
              >
                Récapitulatif des lots
              </h2>
            </div>
            <div class="flex justify-between">
              <div class="my-6 mr-2">

            </div>
              <div class="my-6">
                <img class="h-6" src="{{asset('storage/'.'printer.png')}}" onclick="window.print()">
            </div>  
            </div>          
          </div>
<hr>  
            <!-- Cards -->
          
            <!-- filtre -->

                    

            <!-- New Table -->
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
              <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="px-4 py-3">N° du lot</th>
                      <th class="px-4 py-3">Surface en m2</th>
                       @can('voir titre foncier')
                      <th class="px-4 py-3">N° Titre Foncier</th>
                      @endcan

                      <th class="px-4 py-3">Prix m2 Indicatif</th>
                      
                      <th class="px-4 py-3">Prix m2 Définitif</th>
                      <th class="px-4 py-3">Nombre de façades</th>
                      <th class="px-4 py-3">Nombre d'etage</th>
                      <th class="px-4 py-3">Etat</th>
                      <th class="px-4 py-3">Type contrat</th>
                      <th class="px-4 py-3">Actions</th>


                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >

                  @foreach ($contrats as $contrat)
              
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">

                          <!-- Avatar with inset shadow -->
                          <div
                            class="relative hidden w-8 h-8 mr-3 rounded-full md:block"
                          >
                            <img
                              class="object-cover w-full h-full rounded-full"
                              src="{{asset('storage/'.'floor-plan.png')}}"
                              alt=""
                              loading="lazy"
                            />
                            <div
                              class="absolute inset-0 rounded-full shadow-inner"
                              aria-hidden="true"
                            ></div>
                          </div>
                          <div>
                           
                            <p class="font-semibold">
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-700 dark:text-blue-100"
                        >                              
                              {{$contrat->id }} 
                        </span>
                      <!-- </a> -->
                            </p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                              Tranche {{ $contrat->id }}
                            </p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">

                        {{ $contrat->id }} m<sup>2</sup>
                      </td>

                      <td class="px-4 py-3 text-xs">
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                        >
                          {{ $contrat->id }} Dhs
                        </span>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                              Total :   Dhs
                            </p>                        
                      </td>
                      <td class="px-4 py-3 text-xs">
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                        >
                          {{ $contrat->id }} Dhs
                        </span>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                              Total :    Dhs
                            </p>                         
                      </td>                                                                  
                      <td class="px-4 py-3 text-xs">
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                        >
                        {{$contrat->id}}

                           
                        </span>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{ $contrat->id }}
                      </td>                      
                      <td class="px-4 py-3 text-sm">
                        <span
                          class="px-2 py-1 font-semibold leading-tight rounded-full dark:bg-green-700 dark:text-green-100"
                        >
                          {{ $contrat->id }}
                        </span>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{ ucfirst($contrat->id) }}
                      </td>

                      <td class="px-4 py-3 text-sm">
                        
                @can('Ajouter dossiers lots')
              <div class="flex px-1 py-1">

                <div class="mr-1">
             
                <a
                  class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray"
                  aria-label="Like"
                  href="/contrats/{{ $contrat->id }}/dossiers/create"
                >
                  <svg
                    class="w-4 h-4"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                      <path d="M2,6 L0,6 L0,8 L2,8 L2,10 L4,10 L4,8 L6,8 L6,6 L4,6 L4,4 L2,4 L2,6 L2,6 Z M8.99999861,6.00166547 C8.99999861,4.34389141 10.3465151,3 11.9999972,3 C13.6568507,3 14.9999958,4.33902013 14.9999958,6.00166547 L14.9999958,7.99833453 C14.9999958,9.65610859 13.6534793,11 11.9999972,11 C10.3431437,11 8.99999861,9.66097987 8.99999861,7.99833453 L8.99999861,6.00166547 L8.99999861,6.00166547 Z M20.0000045,15.1405177 C17.6466165,13.7791553 14.914299,13 12,13 C9.08570101,13 6.35338349,13.7791553 3.99999555,15.1405177 L4,18 L20,18 L20,15.1405151 L20.0000045,15.1405177 L20.0000045,15.1405177 Z" id="Combined-Shape"></path>
                  </svg>
                </a>

              </div>
              @endcan
     
              @can('editer lots')
                <div class="mr-1">
             
                <a
                  class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray"
                  aria-label="Like"
                  href="/lots/{{ $contrat->id }}/edit"
                >
                  <svg
                    class="w-4 h-4"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                  <path d="M12.2928932,3.70710678 L0,16 L0,20 L4,20 L16.2928932,7.70710678 L12.2928932,3.70710678 Z M13.7071068,2.29289322 L16,0 L20,4 L17.7071068,6.29289322 L13.7071068,2.29289322 Z" id="Combined-Shape"></path>
                  </svg>
                </a>

            </div>
            @endcan
            @can('supprimer lots')
            <div>
                        <form action="/lots/{{$contrat->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                <button
                  class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red"
                  aria-label="Like"
                  type="submit"
                >
                  <svg
                    class="w-4 h-4"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >

                    <path
                      d="M2,2 L18,2 L18,4 L2,4 L2,2 Z M8,0 L12,0 L14,2 L6,2 L8,0 Z M3,6 L17,6 L16,20 L4,20 L3,6 Z M8,8 L9,8 L9,18 L8,18 L8,8 Z M11,8 L12,8 L12,18 L11,18 L11,8 Z"
                      clip-rule="evenodd"
                      fill-rule="evenodd"
                    ></path>
                  </svg>
                </button>
                      </form>
                      </div>   
                      @endcan             
              </div>

              
                      </td>




                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div
                class="grid py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t"
              >
                {{--$contrats->links()--}}
              </div>
            </div>


          </div>
        </main>
</x-master>
