<x-master>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">


            <div class="flex justify-between">
              <div>
              <h2
                class="my-6 text-4xl font-semibold text-black dark:text-gray-200"
              >
              Entreprises
              </h2>
            </div>
            <div class="flex justify-between">
              <div class="my-6 mr-2">
                <img class="h-6" src="{{asset('storage/'.'excel.png')}}">
              </a>
            </div>
            </div>          
          </div>
  

                                    
            <!-- New Table -->
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
              <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="px-4 py-3">Entreprise</th>
                      <th class="px-4 py-3">RC</th>
                      <th class="px-4 py-3">Ville</th>
                      <th class="px-4 py-3">Patent</th>
                      <th class="px-4 py-3">IF</th>
                      <th class="px-4 py-3">Capital</th>
                      <th class="px-4 py-3">Siège Social</th>


                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >
                  @foreach($entreprises as $p)
                    <tr class="@if ($p->default == 1)
                      bg-indigo-100
                      @endif text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <div
                            class="relative hidden w-6 h-6 mr-3 rounded-full md:block"
                          >
                            <img
                              class="object-cover w-full h-full rounded-full"
                              src="{{asset('storage/'.'land.png')}}"
                              alt=""
                              loading="lazy"
                            />
                            <div
                              class="absolute inset-0 rounded-full shadow-inner"
                              aria-hidden="true"
                            ></div>
                          </div>
                          <div>
                        {{ $p->nom }}
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{ $p->rc}}
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{ $p->ville }}
                      </td>    

                      <td class="px-4 py-3 text-sm">
                          {{$p->patente }}
                      </td> 
                      <td class="px-4 py-3 text-sm">
                          {{ $p->if }}
                      </td>                       
                      <td class="px-4 py-3 text-sm">
                          {{ $p->capital }}
                  </td>
                      <td class="px-4 py-3 text-sm">
                          {{ $p->siege }}
                  </td>                  
                      <td class="flex px-4 py-6 text-sm">
            @can('editer entreprises')
                <div class="mr-1">
                <a
                  class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray"
                  aria-label="Like"
                  href="/entreprises/{{ $p->id }}/edit"
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


                        @can('supprimer entreprises')
                      <div>
                      <form action="/entreprises/{{$p->id}}" method="POST">
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
                      </td>
                    </tr>
                    @endforeach
                    <!--@ endforeach -->
                  </tbody>
                </table>
              </div>
                    <div class="flex justify-end mt-6">
                        <a href="entreprises/create" type="submit" id="edit-button" class="px-3 py-2 text-sm tracking-wide text-white transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                            Ajouter une entreprise
                        </a>
                    </div>
            </div>


          </div>
        </main>        
</x-master>
