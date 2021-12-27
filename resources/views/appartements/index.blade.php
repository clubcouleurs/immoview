<x-master>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <div class="flex justify-between">
              <div>
              <h2
                class="my-6 text-4xl font-semibold text-black dark:text-gray-200"
              >
                Récapitulatif des Appartements 
                @if ($standing == 1)
                Standing
                @endif
              </h2>
            </div>
            <div class="flex justify-between">
              <div class="my-6 mr-2">
              <a href="/appartements/export{{$urlWithQueryString}}">
                <img class="h-6" src="{{asset('excel.png')}}">
              </a>
            </div>
              <div class="my-6">
                <img class="h-6" src="{{asset('printer.png')}}" onclick="window.print()">
            </div>  
            </div>          
          </div>
<hr> 

            <!-- Cards -->
            <div class="grid gap-6 mb-2 md:grid-cols-2 xl:grid-cols-6">
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"
                    ></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Total appartements
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{$totalappartements}}
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      fill-rule="evenodd"
                      d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Valeur total
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                  {{number_format($valeurTotal, 2)}} Dhs
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-red-500 bg-red-100 rounded-full dark:text-blue-100 dark:bg-blue-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"
                    ></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Appartements vendus
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{$appartementsReserved}}
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-red-500 bg-red-100 rounded-full dark:text-blue-100 dark:bg-blue-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"
                    ></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Appartements réservés
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{$appartementsR}}
                  </p>
                </div>
              </div>
              @can('voir etat bloque')
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-teal-500 bg-black rounded-full dark:text-teal-100 dark:bg-teal-500"
                >
                  <svg class="w-5 h-5" fill="white" viewBox="0 0 20 20">
<path  fill-rule="evenodd" d="M11.4142136,10 L14.2426407,7.17157288 L12.8284271,5.75735931 L10,8.58578644 L7.17157288,5.75735931 L5.75735931,7.17157288 L8.58578644,10 L5.75735931,12.8284271 L7.17157288,14.2426407 L10,11.4142136 L12.8284271,14.2426407 L14.2426407,12.8284271 L11.4142136,10 L11.4142136,10 Z M2.92893219,17.0710678 C6.83417511,20.9763107 13.1658249,20.9763107 17.0710678,17.0710678 C20.9763107,13.1658249 20.9763107,6.83417511 17.0710678,2.92893219 C13.1658249,-0.976310729 6.83417511,-0.976310729 2.92893219,2.92893219 C-0.976310729,6.83417511 -0.976310729,13.1658249 2.92893219,17.0710678 L2.92893219,17.0710678 Z M4.34314575,15.6568542 C7.46734008,18.7810486 12.5326599,18.7810486 15.6568542,15.6568542 C18.7810486,12.5326599 18.7810486,7.46734008 15.6568542,4.34314575 C12.5326599,1.21895142 7.46734008,1.21895142 4.34314575,4.34314575 C1.21895142,7.46734008 1.21895142,12.5326599 4.34314575,15.6568542 L4.34314575,15.6568542 Z" clip-rule="evenodd"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Appartements Bloqués
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{$appartementsBlocked}}
                    
                  </p>
                </div>
              </div>              
              @endcan
              <!-- Card -->              
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-green-700 bg-green-100 rounded-full dark:text-teal-100 dark:bg-teal-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path fill-rule="evenodd" d="M0,2 C0,0.8954305 0.898212381,0 1.99079514,0 L18.0092049,0 C19.1086907,0 20,0.887729645 20,2 L20,4 L0,4 L0,2 Z M1,5 L19,5 L19,18.0081158 C19,19.1082031 18.1073772,20 17.0049107,20 L2.99508929,20 C1.8932319,20 1,19.1066027 1,18.0081158 L1,5 Z M7,7 L13,7 L13,9 L7,9 L7,7 Z" clip-rule="evenodd"></path>

                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Appartements en stock
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{$appartementsStocked}}
                    
                  </p>
                </div>
              </div>
              
            </div>
            <!-- filtre -->
              <p class="text-sm text-gray-600 dark:text-gray-400 ml-2 mb-2">Filtres</p>   

                <form action="/appartements/">
              @csrf
            <div
              class="flex items-center justify-between p-2 mb-2 text-sm font-semibold text-blue-600 bg-blue-100 rounded-lg shadow-sm focus:outline-none focus:shadow-outline-blue rounded-2xl"
              
            >
              <div class="flex items-center gap-2">
                <a
                  class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-2xl active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue"
                  href="/appartements?standing={{$standing}}"
                >Tout</a>
                <input type="hidden" name="standing" value="{{$standing}}"/>

                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray rounded-2xl"
                  name="tranche"
                >
                  <option value="-">Tranche</option>
                
                @foreach($tranches as $tranche)
                  <option value="{{$tranche->id}}"
                    @if ( $SearchByTr == $tranche->id)
                    selected
                    @endif
                    >Tranche {{$tranche->num}}
                  </option>
                @endforeach
                </select>


                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray rounded-2xl"
                  name="immeuble"
                >
                  <option value="-">Immeuble</option>
                
                @foreach($immeubles as $immeuble)
                  <option value="{{$immeuble->id}}"
                    @if ( $SearchByImm == $immeuble->id)
                    selected
                    @endif
                    >Imm {{$immeuble->num}} - Tranche {{$immeuble->tranche->num}}
                  </option>
                @endforeach
                </select>

                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray rounded-2xl"
                  name="nombreFacadesappartement"
                >
                  <option value="-">Façades </option>

                  @for ($i = 0; $i < 3; $i++)
                  <option value="{{$i+1}}"
                    @if ( $SearchByFacade == ($i+1) )
                    selected
                    @endif
                    >{{$i+1}} Façade(s)
                  </option>
                @endfor

                </select>        
                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray rounded-2xl"
                  name="etage"
                >
                  <option value="-">Etages</option>
                
                  <option value="1" @if ( $SearchByEtage == 1) selected @endif>R+1</option>
                  <option value="2" @if ( $SearchByEtage == 2) selected @endif>R+2</option>
                  <option value="3" @if ( $SearchByEtage == 3) selected @endif>R+3</option>
                  <option value="4" @if ( $SearchByEtage == 4) selected @endif>R+4</option>
                  <option value="5" @if ( $SearchByEtage == 5) selected @endif>R+5</option>
                  <option value="6" @if ( $SearchByEtage == 6) selected @endif>R+6</option>
                  <option value="7" @if ( $SearchByEtage == 7) selected @endif>R+7</option>
                  <option value="8" @if ( $SearchByEtage == 8) selected @endif>R+8</option>
                  <option value="9" @if ( $SearchByEtage == 9) selected @endif>R+9</option>
                  <option value="10" @if ( $SearchByEtage == 10) selected @endif>R+10</option>
              
                </select>
                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray rounded-2xl"
                  name="etatProduit"
                >
                  <option value="-">Etat</option>
                
                
                @foreach($etiquettes as $etiquette)
                  <option value="{{$etiquette->id}}"
                    @if ( $SearchByEtat == $etiquette->id)
                    selected
                    @endif
                    > {{$etiquette->label}}
                  </option>
                @endforeach
              
                </select>
                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray rounded-2xl"
                  name="type"
                >
                  <option value="-">Type</option>
                
                  <option value="Economique"  @if ( $SearchByType == "Economique") selected @endif>Social</option>
                  <option value="Standing" @if ( $SearchByType == "Standing") selected @endif>Standing</option>              
                </select> 
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded-2xl"
                  placeholder="prix min"
                  type="number"
                  step="0.1"
                  name="minPrix"
                  value={{$SearchByMin}}
                />
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded-2xl"
                  placeholder="prix max"
                  type="number"
                  step="0.1"
                  name="maxPrix"
                  value={{$SearchByMax}}
                />
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded-2xl"
                  placeholder="Numéros de appartement séparés par (,)"
                  type="text"
                  name="numsappartement"
                  value="{{$SearchByNum}}"
                />



                            <button
                  class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-2xl active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue"
                  type="submit"
                >
                  <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                  </svg>
                </button>

              </div>
            </div>
              </form>

            <!-- New Table -->
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
              <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="px-4 py-3">N° du appartement</th>
                      <th class="px-4 py-3">Surface en m2</th>

                      <th class="px-4 py-3">Prix m2 Indicatif</th>
                      <!--<th class="px-4 py-3">Prix m2 Définitif</th>-->
                      <th class="px-4 py-3">Nombre de façades</th>
                      <th class="px-4 py-3">Etage</th>
                      <th class="px-4 py-3">Etat</th>
                      <th class="px-4 py-3">Type</th>
                      <th class="px-4 py-3">Actions</th>


                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >

                  @foreach ($appartements as $produit)
                    @if (!in_array($produit->etiquette_id, [2,3,9]))
                          @cannot('voir etat bloque')
                            @continue
                          @endcannot
                    @endif
                    <tr class="
                    @if ($produit->etiquette->label == 'En stock')
                      bg-green-50
                    @elseif ($produit->etiquette->label == 'Réservé')
                      bg-gray-200
                    @elseif ($produit->etiquette->label == 'Vendu')
                      bg-purple-200
                    @else
                      bg-red-100
                    @endif
                    text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">

                          <!-- Avatar with inset shadow -->
                          <div
                            class="relative hidden w-8 h-8 mr-3 rounded-full md:block"
                          >
                            <img
                              class="object-cover w-full h-full rounded-full"
                              src="{{asset('floor-plan.png')}}"
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
                             <!-- <a href="/appartements/{{ $produit->constructible->id }}"> -->
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-700 dark:text-blue-100"
                        >                              
                              {{$produit->constructible->num }} 
                        </span>
                      <!-- </a> -->
                            </p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                              Imm. {{ $produit->constructible->immeuble->num }} | Tr. {{ $produit->constructible->immeuble->tranche->num }}
                            </p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">

                        {{ $produit->constructible->surface }} m<sup>2</sup>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                              {!! $produit->constructible->surfaceDetail !!}
                            </p> 

                        
                      </td>
                      @if($produit->constructible->type === "Standing")
                      <td class="px-4 py-3 text-xs">
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                        >
                          {{ number_format($produit->totalIndicatif)}} Dhs
                        </span>
                      
                      </td>
                      @else
                      <td class="px-4 py-3 text-xs">
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                        >
                          {{ number_format($produit->constructible->prixM2Indicatif) }} Dhs
                        </span>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                              Total : {{ number_format($produit->totalIndicatif)}} Dhs
                            </p>                        
                      </td>
                      @endif
                      <!--<td class="px-4 py-3 text-xs">
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                        >
                          {{ number_format($produit->constructible->prixM2Definitif) }} Dhs
                        </span>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                              Total : {{ number_format($produit->totalDefinitif)}} Dhs
                            </p>                         
                      </td>-->

                      <td class="px-4 py-3 text-xs">
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                        >
                        {{$produit->nombreVoies}}F-{{$produit->quellesVoies}}

                           
                        </span>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        R+{{ $produit->constructible->etage }}
                      </td>                      
                      <td class="px-4 py-3 text-sm">
                        <span
                          class="px-2 py-1 font-semibold leading-tight rounded-full dark:bg-green-700 dark:text-green-100

                    @if ($produit->etiquette->label == 'En stock')
                      text-green-700 bg-green-100 
                    @elseif ($produit->etiquette->label == 'Réservé')
                      text-gray-200 bg-gray-900
                    @elseif ($produit->etiquette->label == 'Vendu')
                      text-purple-100 bg-purple-900                      
                    @else
                      text-white bg-red-900
                    @endif



                          "
                        >
                          {{ $produit->etiquette->label }}
                        </span>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{ $produit->constructible->type }}
                      </td>

                      <td class="px-4 py-3 text-sm">
                        
              <div class="flex px-1 py-1">
                @can('Ajouter dossiers appartements')
                @if(null == $produit->dossier && $produit->etiquette->label == 'En stock')
                <div class="mr-1">
             
                <a
                  class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray"
                  aria-label="Like"
                  href="/produits/{{ $produit->id }}/dossiers/create"
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
            @endif
            @can('editer appartements')
                <div class="mr-1">
             
                <a
                  class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray"
                  aria-label="Like"
                  href="/appartements/{{ $produit->constructible->id }}/edit"
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
            @can('supprimer appartements')
            <div>
                        <form action="/appartements/{{$produit->constructible->id}}" method="POST">
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
              </div>

                      @endcan
                      </td>




                    </tr>

                    @endforeach
                  </tbody>
                </table>
              </div>
              <div
                class="grid py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t"
              >
                {{$appartements->links()}}
              </div>
            </div>


          </div>
        </main>
</x-master>
