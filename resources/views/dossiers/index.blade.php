<x-master>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <h2
              class="my-6 text-4xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Récapitulatif des dossiers

            </h2>
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
                    Total dossiers
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{$totalDossier}}
                  </p>
                </div>
              </div>
              <!-- Card -->
              @foreach($dossiersParType as $type)
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
                      {{ ucfirst($type->constructible_type) }}s
                    </p>
                    <p
                      class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                    >
                    {{ $type->nombre }}
                    </p>
                  </div>
                </div>
              @endforeach
              <!-- Card -->
              

              

            </div>
            <!-- filtre -->
              <p class="text-sm text-gray-600 dark:text-gray-400 ml-2 mb-2">Filtres</p>   

                <form action="/dossiers">
              
            <div
              class="flex items-center justify-between p-2 mb-2 text-sm font-semibold text-blue-600 bg-blue-100 rounded-lg shadow-sm focus:outline-none focus:shadow-outline-blue rounded-2xl"
              
            >
              <div class="flex items-center gap-2">
                <a
                  class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-2xl active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue"
                  href="/dossiers/"
                >Tout</a>

                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded-2xl"
                  placeholder="Numéro CIN, nom ou prénom"
                  type="text"
                  name="client"
                  value="{{$SearchByClient}}"
                />
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded-2xl"
                  placeholder="lot, appartement etc, séparé par (,)"
                  type="text"
                  name="num"
                  value="{{$SearchByNum}}"
                />                
                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray rounded-2xl"
                  name="user"
                >
                  <option value="-">Commercial </option>

                  @foreach ($users as $user)
                  <option value="{{$user->id}}"
                    @if ( $SearchByUser == $user->id)
                    selected
                    @endif
                    >{{$user->name}} 
                  </option>
                @endforeach

                </select>
                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray rounded-2xl"
                  name="sign"
                >
                
                  <option value="<" @if ( $SearchBySign == '<') selected @endif>Moins que</option>
                  <option value=">" @if ( $SearchBySign == '>') selected @endif>Plus que</option>
                  <option value="=" @if ( $SearchBySign == '=') selected @endif>Egale à</option>
                  <option value="<=" @if ( $SearchBySign == '<=') selected @endif>Moins ou égale à</option>
                  <option value="=>" @if ( $SearchBySign == '=>') selected @endif>Plus ou égale à</option>
              
                </select>                
                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray rounded-2xl"
                  name="tauxComparateur"
                >
                  <option value="-">Taux de paiement</option>
                
                  <option value="10" @if ( $SearchByTauxComparateur =="10" ) selected @endif>10%</option>
                  <option value="20" @if ( $SearchByTauxComparateur =="20" ) selected @endif>20%</option>
                  <option value="30" @if ( $SearchByTauxComparateur =="30" ) selected @endif>30%</option>
                  <option value="40" @if ( $SearchByTauxComparateur =="40" ) selected @endif>40%</option>
                  <option value="50" @if ( $SearchByTauxComparateur =="50" ) selected @endif>50%</option>
                  <option value="60" @if ( $SearchByTauxComparateur =="60" ) selected @endif>60%</option>
                  <option value="70" @if ( $SearchByTauxComparateur =="70" ) selected @endif>70%</option>
                  <option value="80" @if ( $SearchByTauxComparateur =="80" ) selected @endif>80%</option>
                  <option value="90" @if ( $SearchByTauxComparateur =="90" ) selected @endif>90%</option>
                  <option value="100" @if ( $SearchByTauxComparateur =="100" ) selected @endif>100%</option>
             

                </select>
                <!--<select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray rounded-2xl"
                  name="etatProduit"
                >
                  <option value="-">Etat</option>
                

              
                </select>
                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray rounded-2xl"
                  name="typeLot"
                >
                  <option value="-">Type</option>
                
                  <option value="Habitat"  @if ( $SearchByType == "Habitat") selected @endif>Habitat</option>
                  <option value="Commercial" @if ( $SearchByType == "Commercial") selected @endif>Commercial</option>              
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
                />-->
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
                      <th class="px-4 py-3">N° du dossier</th>
                      <th class="px-4 py-3">Date du dossier</th>
                      <th class="px-4 py-3">Frais</th>
                      <th class="px-4 py-3">Client</th>
                      <th class="px-4 py-3">Commercial</th>
                      <th class="px-4 py-3">Total Paiements</th>
                      <th class="px-4 py-3">Total dû</th>
                      <th class="px-4 py-3">Taux</th>

                      <th class="px-4 py-3">Détail</th>
                      <th class="px-4 py-3">Actions</th>


                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >

                  @foreach ($dossiers as $dossier)
                    <tr class="text-gray-700 dark:text-gray-400">
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
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-700 dark:text-blue-100"
                        >                              
                              {{ $dossier->num }} 
                        </span>
                            </p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                          <a href="{{ $dossier->produit->constructible_type }}s/{{ $dossier->produit->constructible->id }}">
                          {{ $dossier->produit->constructible_type }} N°
                          {{ $dossier->produit->constructible->num }}
                        </a>
                            </p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{ $dossier->date }} 
                      </td>
                      <td class="px-4 py-3 text-xs">
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                        >
                          {{ number_format($dossier->frais) }} Dhs
                        </span>
                        
                      </td>

                                                                  
                      <td class="px-4 py-3 text-xs">
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                        >
                        {{$dossier->client->nom}} {{$dossier->client->prenom}}                       
                        </span>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                              CIN : {{ $dossier->client->cin }}
                            </p>                         
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{ $dossier->user->name }}
                      </td>                      
                      <td class="px-4 py-3 text-sm">
                        <span
                          class="px-2 py-1 font-semibold leading-tight rounded-full dark:bg-green-700 dark:text-green-100
                          @if ($dossier->etatProduit == 'En stock')
                            text-green-700 bg-green-100
                            @elseif ($dossier->etatProduit == 'Bloqué')
                            text-white bg-gray-900
                            @else
                            text-red-200 bg-red-900
                          @endif

                          "
                        >
                          {{number_format($dossier->paiements->sum('montant'))}} Dhs
                        </span>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        <span
                          class="px-2 py-1 font-semibold leading-tight rounded-full dark:bg-green-700 dark:text-green-100
                          @if ($dossier->etatProduit == 'En stock')
                            text-green-700 bg-green-100
                            @elseif ($dossier->etatProduit == 'Bloqué')
                            text-white bg-gray-900
                            @else
                            text-red-200 bg-red-900
                          @endif

                          "
                        >
                           {{ number_format($dossier->produit->totalDefinitif)}} Dhs
                        </span>
                      </td>     
                      <td class="px-4 py-3 text-sm">
                        <span
                          class="px-2 py-1 font-semibold leading-tight rounded-full dark:bg-green-700 dark:text-green-100
                          @if ($dossier->etatProduit == 'En stock')
                            text-green-700 bg-green-100
                            @elseif ($dossier->etatProduit == 'Bloqué')
                            text-white bg-gray-900
                            @else
                            text-red-200 bg-red-900
                          @endif

                          "
                        >
                          {{ $dossier->tauxPaiement }} %
                        </span>
                      </td>                                       
                      <td class="px-4 py-3 text-sm">
                        {{ $dossier->detail }}
                      </td>

                      <td class="px-4 py-3 text-sm">
              <div class="flex px-1 py-1">
                <div class="mr-1">
             
                <a
                  class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray"
                  aria-label="Like"
                  href="/dossiers/{{ $dossier->id }}"
                >
                  <svg
                    class="w-4 h-4"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
 <path d="M0,3.99406028 C0,2.8927712 0.895857811,2 1.9973917,2 L9,2 L11,4 L18.0026083,4 C19.1057373,4 20,4.89706013 20,6.00585866 L20,15.9941413 C20,17.1019465 19.1017876,18 18.0092049,18 L1.99079514,18 C0.891309342,18 0,17.1054862 0,16.0059397 L0,3.99406028 Z M2,6 L18,6 L18,16 L2,16 L2,6 Z"></path>
                  </svg>
                </a>
  </div>

                <div class="mr-1">
             
                <a
                  class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray"
                  aria-label="Like"
                  href="/dossiers/{{$dossier->id}}/paiements"
                >
                  <svg
                    class="w-4 h-4"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
<path d="M0,3.99406028 C0,2.8927712 0.892622799,2 1.99508929,2 L17.0066023,2 C17.5552407,2 18,2.44386482 18,3 L18,4 L2,4 L2,5 L19.0066023,5 C19.5552407,5 20,5.44748943 20,5.99850233 L20,15.9972399 C20,17.1033337 19.1017876,18 18.0092049,18 L1.99079514,18 C0.891309342,18 0,17.1054862 0,16.0059397 L0,3.99406028 Z M16.5,13 C17.3284271,13 18,12.3284271 18,11.5 C18,10.6715729 17.3284271,10 16.5,10 C15.6715729,10 15,10.6715729 15,11.5 C15,12.3284271 15.6715729,13 16.5,13 Z" id="Combined-Shape"></path>
                  </svg>
                </a>

            </div>

                <div class="mr-1">
             
                <a
                  class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray"
                  aria-label="Like"
                  href="/dossiers/{{ $dossier->id }}/edit"
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
            <div>
                        <form action="/dossiers/{{$dossier->id}}" method="POST">
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

              
                      </td>




                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div
                class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800"
              >
                {{$dossiers->links()}}
              </div>
            </div>


          </div>
        </main>
</x-master>
