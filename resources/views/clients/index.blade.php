<x-master>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <div class="flex justify-between">
              <div>
              <h2
                class="my-6 text-4xl font-semibold text-black dark:text-gray-200"
              >
              Récapitulatif des @if($activer==1) clients @else prospects @endif
              </h2>
            </div>
            <div class="flex justify-between">
              <div class="my-6 mr-2">
              <a href="/clients/export{{$urlWithQueryString}}">
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
            <div class="grid gap-6 mb-2 md:grid-cols-2 xl:grid-cols-5">
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
                    Total @if($activer==1) Clients @else Prospects @endif 
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{$totalClients}}
                  </p>
                </div>
              </div>
            </div>
            <!-- filtre -->
              <p class="text-sm text-gray-600 dark:text-gray-400 ml-2 mb-2">Filtres</p>   

                <form action="/clients/">
              @csrf
            <div
              class="flex items-center justify-between p-2 mb-2 text-sm font-semibold text-blue-600 bg-blue-100 rounded-lg shadow-sm focus:outline-none focus:shadow-outline-blue rounded-2xl"
              
            >
              <div class="flex items-center gap-2">
                <a
                  class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-2xl active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue"
                  href="@if($activer==1) /clients/ @else /prospects/0 @endif "
                >Tout</a>
                <input type="hidden" name="activer" value="{{$activer}}">

                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded-2xl"
                  placeholder="Numéro CIN, nom ou prénom"
                  type="text"
                  name="client"
                  value="{{$SearchByClient}}"
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
            <div class="w-full overflow-hidden rounded-lg shadow-xs" id="section-to-print">
              <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="px-4 py-3">@if($activer==1) Clients @else Prospects @endif</th>
                      
                      @if($activer==1) <th class="px-4 py-3">N° CIN</th> @endif
                      @if($activer==1) <th class="px-4 py-3">CIN SCAN</th> @endif

                      @if($activer==1) <th class="px-4 py-3">Adresse</th> @endif
                      <th class="px-4 py-3">Mobile</th>
                      
                      <th class="px-4 py-3">Il est @if($activer==1) client @else prospect @endif ...</th>
                      <th class="px-4 py-3">Actions</th>


                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >

                  @foreach ($clients as $client)
                    <tr class="">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">

                          <!-- Avatar with inset shadow -->
                          <div
                            class="relative hidden w-8 h-8 mr-3 rounded-full md:block"
                          >
                            <img
                              class="object-cover w-full h-full rounded-full"
                              src="{{asset('user.png')}}"
                              alt=""
                              loading="lazy"
                            />
                          </div>
                          
                          <div>
                            <p class="font-semibold">
                             
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-700 dark:text-blue-100"
                        >                              
                              {{$client->nom }} {{$client->prenom }}
                        </span>
                            </p>
                            <p class="px-2  text-xs text-gray-600 dark:text-gray-400">
                              N° {{$client->id }} 
                            </p>
                          </div>
                        </div>
                      </td>
                      @if($activer==1)
                      <td class="px-4 py-3 text-sm">
                        {{ $client->cin }} 
                      </td>
                      <td class="px-4 py-3 text-sm">
                        @isset($client->cinPj)
                        <a href="{{asset($client->cinPj)}}" target="_blank">
                            @if(substr($client->cinPj,-3) == 'pdf')
                            <img class="h-8" src="{{asset('pdf.png')}}">
                            @else
                            <img class="h-8" src="{{asset('id-card-icon.png')}}">
                            @endif
                        </a>
                        @else
                        Aucune pièce jointe
                        @endisset
                      </td> 
                      <td class="px-4 py-3 text-xs">
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                        >
                          {{ $client->adresse }}
                        </span>
                      </td>
                      @endif
                      <td class="px-4 py-3 text-xs">
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                        >
                          {{ $client->mobile }}
                        </span>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                            </p>                         
                      </td>                                                                  
                    
                      <td class="px-4 py-3 text-sm">
                        <span
                          class="px-2 py-1 font-semibold leading-tight rounded-full dark:bg-green-700 dark:text-green-100"
                        >
                          {{ $client->created_at->diffForHumans()}}
                        </span>
                      </td>
 

                      <td class="px-4 py-3 text-sm">
  
              <div class="flex px-1 py-1">
                
                      @if($activer==1)
                <div class="mr-1">
                <a
                  class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray"
                  aria-label="Like"
                  href="/clients/{{ $client->id }}/dossiers/create"
                >
                  <svg
                    class="w-4 h-4"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
<path d="M15,9 L12,9 L12,11 L15,11 L15,14 L17,14 L17,11 L20,11 L20,9 L17,9 L17,6 L15,6 L15,9 Z M0,3 L10,3 L10,5 L0,5 L0,3 Z M0,11 L10,11 L10,13 L0,13 L0,11 Z M0,7 L10,7 L10,9 L0,9 L0,7 Z M0,15 L10,15 L10,17 L0,17 L0,15 Z" id="Combined-Shape"></path>
                  </svg>
                </a>
              </div>
              @can('editer clients')
                <div class="mr-1">
                <a
                  class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray"
                  aria-label="Like"
                  href="/clients/{{ $client->id }}/edit"
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
            @else
                <div class="mr-1">
                <a
                  class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray"
                  aria-label="Like"
                  href="/clients/{{ $client->id }}/edit"
                >
                  <svg
                    class="w-4 h-4"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
<path d="M10,12 C13.3137085,12 16,9.3137085 16,6 C16,2.6862915 13.3137085,0 10,0 C6.6862915,0 4,2.6862915 4,6 C4,9.3137085 6.6862915,12 10,12 Z M10,9 C11.6568542,9 13,7.65685425 13,6 C13,4.34314575 11.6568542,3 10,3 C8.34314575,3 7,4.34314575 7,6 C7,7.65685425 8.34314575,9 10,9 Z M14,11.7453107 L14,20 L10,16 L6,20 L6,11.7453107 C7.13383348,12.5361852 8.51275186,13 10,13 C11.4872481,13 12.8661665,12.5361852 14,11.7453107 L14,11.7453107 Z" id="Combined-Shape"></path>
                  </svg>
                </a>
            </div>            
            @endif
            @can('supprimer clients')
            <div>
                        <form action="/clients/{{$client->id}}" method="POST">
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
                {{$clients->links()}}
              </div>
            </div>


          </div>
        </main>
</x-master>
