<x-master>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <div class="flex justify-between">
              <div>
              <h2
                class="mt-6 text-4xl font-semibold text-red-500 dark:text-gray-200"
              >
                Recouvrement des dossiers  
              </h2>
                  <p
                    class="mb-6 text-lg font-semibold text-red-700 dark:text-gray-200"
                  >
                  @if($SearchByTauxComparateur == 20)
                    de 2018 à Août 2020 avec un taux de paiement de moins de {{$SearchByTauxComparateur}}%
                  @elseif($SearchByTauxComparateur == 30)
                    de Septembre 2020 à Aujourd'hui avec un taux de paiement de moins de {{$SearchByTauxComparateur}}%
                  @endif
                  </p>              
            </div>
            <div class="flex justify-between">
              <div class="my-6 mr-2">
              <a href="/dossiers/export{{$urlWithQueryString}}">
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



            
              
            </div>

            

         

            <!-- New Table -->
            <div class="w-full overflow-hidden rounded-lg shadow-xs" id="section-to-print">
              <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border  dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="py-3">Vente</th>
                      <th class="py-3" id="section-not-to-print">Date du dossier</th>
                      @if($constructible != 'lot')
                      <th class="py-3">Frais</th>
                      @endif
                      <th class="py-3">Client</th>
                      <th class="py-3" id="section-not-to-print">Com</th>
                      <th class="py-3">Total Paiements</th>
                      <th class="py-3">Total dû</th>
                      <th class="py-3">Taux</th>

                      <th class="py-3" id="section-not-to-print">Actions</th>


                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >

                  @foreach ($dossiers as $dossier)
                    <tr class="text-gray-700
                    {{($dossier->isVente)? '' : 'bg-yellow-200'}}
                    dark:text-gray-400">
                      <td class="px-1 py-3">
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
                           
                            <p class="font-bold">
                            
                              <!-- {{ $dossier->num }}  -->
                          <a href="{{ $dossier->produit->constructible_type }}s/{{ $dossier->produit->constructible->id }}/edit">
                          {{ ucfirst($dossier->produit->constructible_type) }} N°
                          {{ $dossier->produit->constructible->num }}
                        </a>                              

                      </p>
                          @if(!$dossier->isVente)
                        <span
                          class="px-2 py-1 font-semibold leading-tight
                          text-red-100 bg-red-700 rounded-full"
                        >
                          RESERVATION
                          </span>
                          @endif
                            
                          </div>
                        </div>
                      </td>
                      <td class="px-1 py-3 text-sm" id="section-not-to-print">
                        {{ $dossier->date }}
                          @if(!$dossier->isVente)
                        <br>
                        <p class="mb-2 text-xs font-semibold text-gray-600 dark:text-gray-400">
                          Rappeler le client :
                        </p>
                      @isset($dossier->delais->last()->date)
                      @if(Carbon\Carbon::today() >= $dossier->delais->last()->date)
                <span class="px-2 py-1 font-semibold leading-tight text-red-100 bg-red-700 rounded-full"
                >
                {{$dossier->delais->last()->date->diffForHumans()}}
               </span>
                      @else
                <span class="px-2 py-1 font-semibold leading-tight text-green-100 bg-green-700 rounded-full"
                >
                {{$dossier->delais->last()->date->diffForHumans()}}
               </span>
                      @endif
                      @else
                <span class="px-2 py-1 font-semibold leading-tight text-white bg-gray-500 rounded-full"
                >
                Aucune date n'est définie
               </span>                      
                      @endisset
                          @endif                        
                      </td>
                      @if($dossier->produit->constructible_type != 'lot')
                      <td class="px-1 py-3 text-xs">
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                        >
                          {{ numberFormat($dossier->frais) }} Dhs
                        </span>
                        
                      </td>
                      @endif
                                                                  
                      <td class="px-1 py-3 text-xs">
                        @foreach ($dossier->clients as $client)
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                        >
                        {{$client->nom}} {{$client->prenom}}                       
                        </span>
                        <br> 
                            <!-- <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                              CIN : {{ $client->cin }}
                            </p>   -->
                        @endforeach                           
                      </td>
                      <td class="px-1 py-3 text-sm" id="section-not-to-print">
                        {{ substr($dossier->user->name, 0, strpos($dossier->user->name, ' ')+2) }}.
                      </td>                      
                      <td class="px-1 py-3 text-sm">
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
                          {{numberFormat($dossier->totalPaiementsV)}} Dhs
                        </span>
                      </td>
                      <td class="px-1 py-3 text-sm">
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
                           {{ numberFormat($dossier->produit->totalDefinitif)}} Dhs
                        </span>
                      </td>     
                      <td class="px-1 py-3 text-sm">
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
                          {{ $dossier->tauxPaiementV }} %
                        </span>
                      </td>                                       

                      <td class="px-1 py-3 text-sm" id="section-not-to-print">
              <div class="flex px-1 py-1">
                @if(!$dossier->isVente)
                <!-- icon prolongation délai -->
                <div class="mr-1">
                <a
                  class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-yellow-600 border border-transparent rounded-lg active:bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:shadow-outline-yellow"
                  aria-label="Like"
                  href="/dossiers/{{ $dossier->id }}/delais/create"
                >
<svg class="w-4 h-4" aria-hidden="true" fill="none" viewBox="0 0 20 20">
                    <g id="Page-1" stroke="none" stroke-width="1" fill="currentColor" fill-rule="evenodd">
                            <g id="icon-shape">
                                <path d="M14.9056439,5.68014258 C13.7991209,4.81998894 12.4607085,4.24404153 11,4.06189375 L11,2 L9,2 L9,4.06189375 C5.05368842,4.55399184 2,7.92038235 2,12 C2,16.418278 5.581722,20 10,20 C14.418278,20 18,16.418278 18,12 C18,10.1512885 17.3729184,8.44903985 16.3198574,7.09435615 L17.7781746,5.63603897 L16.363961,4.22182541 L14.9056439,5.68014258 Z M10,18 C13.3137085,18 16,15.3137085 16,12 C16,8.6862915 13.3137085,6 10,6 C6.6862915,6 4,8.6862915 4,12 C4,15.3137085 6.6862915,18 10,18 Z M7,0 L13,0 L13,2 L7,2 L7,0 Z M12.1213203,8.46446609 L13.5355339,9.87867966 L10,13.4142136 L8.58578644,12 L12.1213203,8.46446609 Z" id="Combined-Shape"></path>                         
                            </g>
                        </g>
                    </svg>
                </a>
                </div>
                <!-- fin icon prolongation -->
                @endif


                @canany(['voir actes', 'voir actes ses dossiers'])
                  {!!$dossier->acte!!}
                @endcan
            @canany(['voir dossiers appartements',
                     'voir dossiers lots',
                     'voir dossiers boxes',
                     'voir dossiers magasins',
                     'voir dossiers bureaux',
                     'voir ses propres dossiers'])

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

                @endcanany

            @canany(['voir paiements',
                     'voir ses paiements'])                
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
                  href="/dossiers/{{$dossier->id}}/bordereaux"
                >
                  <svg
                    class="w-4 h-4"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
<path d="M0,6 L10,0 L20,6 L20,8 L0,8 L0,6 Z M0,18 L20,18 L20,20 L0,20 L0,18 Z M2,16 L18,16 L18,18 L2,18 L2,16 Z M2,8 L6,8 L6,16 L2,16 L2,8 Z M8,8 L12,8 L12,16 L8,16 L8,8 Z M14,8 L18,8 L18,16 L14,16 L14,8 Z" id="Combined-Shape"></path>
                  </svg>
                </a>

            </div>
      @endcanany




            @canany(['editer dossiers appartements',
                     'editer dossiers lots',
                     'editer dossiers boxes',
                     'editer dossiers magasins',
                     'editer dossiers bureaux',
                     'editer ses propres dossiers'])              
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
            @endcanany
            @canany(['supprimer dossiers appartements',
                     'supprimer dossiers lots',
                     'supprimer dossiers boxes',
                     'supprimer dossiers magasins',
                     'supprimer dossiers bureaux',
                     'supprimer ses propres dossiers'])
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
                {{$dossiers->links()}}
              </div>
            </div>


          </div>
        </main>

<script type="text/javascript">
  const MONTH_NAMES = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Decembre'];
    const DAYS = ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'];

    function app() {
      return {
        showDatepicker: false,
        datepickerValue: '',
        month: '',
        year: '',
        no_of_days: [],
        blankdays: [],
        days: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
        initDate() {
          let today = new Date();
          this.month = today.getMonth();
          this.year = today.getFullYear();

          this.datepickerStart = '@isset($dateStart){{ $dateStart }}@else' + '@endisset';

          this.datepickerEnd = '@isset($dateEnd){{ $dateEnd }}@else' + '@endisset';
        },
        isToday(date) {
          const today = new Date();
          const d = new Date(this.year, this.month, date);
          return today.toDateString() === d.toDateString() ? true : false;
        },
        getDateValue(date) {
          let selectedDate = new Date(this.year, this.month, date,0,0,0);
          this.datepickerStart = selectedDate.toLocaleDateString().slice(0, 10);
          this.datepickerEnd = selectedDate.toLocaleDateString().slice(0, 10);
          //alert(selectedDate);

          this.$refs.date.value = selectedDate.getFullYear() + "-" + ('0' + selectedDate.getMonth()).slice(-2) + "-" + ('0' + selectedDate.getDate()).slice(-2);
          console.log(this.$refs.date.value);
          this.showDatepicker = false;
        },
        getNoOfDays() {
          let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
          // find where to start calendar day of week
          let dayOfWeek = new Date(this.year, this.month).getDay();
          let blankdaysArray = [];
          for (var i = 1; i <= dayOfWeek; i++) {
            blankdaysArray.push(i);
          }
          let daysArray = [];
          for (var i = 1; i <= daysInMonth; i++) {
            daysArray.push(i);
          }
          this.blankdays = blankdaysArray;
          this.no_of_days = daysArray;
        }
      }
    }

</script>    

</x-master>
