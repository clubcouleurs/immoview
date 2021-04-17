<x-master>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">


<div

x-data="{
    value: {{$toatalPaiements}},
    total: {{$ca}}
}"

class="w-full rounded-lg bg-red-100 p-6 mt-6"
role="progressbar" :aria-valuenow="value" aria-valuemin="0" :aria-valuemax="total"
>
  L'objectif atteint du chiffre d'affaire
    <!-- Progress bar -->
    <div class="flex flex-col items-end">
        <span class="text-xs text-gray-600 mb-1" x-text="`${Math.round(value/total * 100)}% complete`"></span>
        <span class="p-3 w-full rounded-md bg-red-200 overflow-hidden relative flex items-center">
            <span class="absolute h-full w-full bg-red-500 left-0 transition-all duration-300" :style="`width: ${ value/total * 100 }%`"></span>
        </span>
    </div>
 
</div>


            <h2
              class="my-6 text-4xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Historique des paiements
            </h2>

              <div
              class="flex items-center justify-between p-2 mb-2 text-sm font-semibold text-blue-600 bg-yellow-100 rounded-lg shadow-sm focus:outline-none focus:shadow-outline-blue rounded-2xl"
              
            >
              <div class="flex items-center gap-2">
                <a
                  class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 
                  {{($constructible == '' )? 'bg-yellow-500' : 'bg-gray-400'}}
                  border border-transparent rounded-2xl active:bg-yellow-600 hover:bg-yellow-600 focus:outline-none focus:shadow-outline-yellow"
                  href="/paiements"
                >Tout</a>

                @foreach ($constructibles as $c)
                <a
                  class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 
                  {{($c == $constructible)? 'bg-yellow-500' : 'bg-gray-400'}}
                  border border-transparent rounded-2xl active:bg-yellow-600 hover:bg-yellow-600 focus:outline-none focus:shadow-outline-yellow"
                  href="/paiements?constructible={{$c}}"
                >{{ucfirst($c)}}</a>
                @endforeach
              </div>
            </div>

                <form action="/paiements">
                <input type="hidden" name="constructible" value="{{$constructible}}"/>

            <div
              class="flex items-center justify-between p-2 mb-2 text-sm font-semibold text-blue-600 bg-blue-100 rounded-lg shadow-sm focus:outline-none focus:shadow-outline-blue rounded-2xl"
              
            >
              <div class="flex items-center gap-2">

                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray rounded-2xl"
                  name="status"
                >
                  <option value="" @if ( $status == '') selected @endif>Tout</option>
                
                  <option value="1"     @if ( $status == '1') selected @endif>Validé</option>
                  <option value="0"     @if ( $status == '0') selected @endif>Non validé</option>
              
                </select>  
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
                      <th class="px-4 py-3">N° du paiement</th>

                      <th class="px-4 py-3">Montant</th>
                      <th class="px-4 py-3">Date du paiement</th>
                      <th class="px-4 py-3">Moyen de paiement</th>
                      <th class="px-4 py-3">Client</th>
                      <th class="px-4 py-3">Status</th>

                      <th class="px-4 py-3">Action</th>


                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >
                  @foreach($paiements as $p)
                  <!-- @ foreach($produit->paiements as $p) -->
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <!-- Avatar with inset shadow -->
                          <div
                            class="relative hidden w-8 h-8 mr-3 rounded-full md:block"
                          >
                            <img
                              class="object-cover w-full h-full rounded-full"
                              src="{{asset('land.png')}}"
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

                  {{ $p->id }}
       
                              </p>

                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{ numberFormat($p->montant) }}
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{ $p->date }}
                      </td>    
                      <td class="px-4 py-3 text-sm">
                        {{ $p->dossier->produit->constructible_type }} N° {{ $p->dossier->produit->constructible->num }}
                      </td> 
                      <td class="px-4 py-3 text-sm">
                            @foreach($p->dossier->clients as $client)
                              Client : {{ $client->nom}} {{ $client->prenom}} 
                            @endforeach  
                      </td> 
                      <td class="px-4 py-3 text-sm">
                        <form action="/dossiers/{{$p->dossier->id}}/paiements/{{$p->id}}" method="POST">
                          @csrf
                          @method('PATCH')
                    {!!$p->validate!!}
                    </form>
                  </td>
                      <td class="flex px-4 py-3 text-sm">
            @can('editer paiements')
                <div class="mr-1">
                <a
                  class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray"
                  aria-label="Like"
                  href="/dossiers/{{ $p->dossier->id }}/paiements/{{ $p->id }}"
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


                        @can('supprimer paiements')
                      <div>
                      <form action="/dossiers/{{$p->dossier->id}}/paiements/{{$p->id}}" method="POST">
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
              <div
                class="grid py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t"
              >
                {{$paiements->links()}}
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
          //this.datepickerValue = new Date(this.year, this.month, today.getDate()).toDateString();
          //this.datepickerValue = new Date(this.year, this.month, today.getDate()).toISOString().slice(0, 10);
          this.datepickerValue = '@isset($paiement->date){{ $paiement->date }}@else' + new Date(this.year, this.month, today.getDate()).toISOString().slice(0, 10) + '@endisset';

        },
        isToday(date) {
          const today = new Date();
          const d = new Date(this.year, this.month, date);
          return today.toDateString() === d.toDateString() ? true : false;
        },
        getDateValue(date) {
          let selectedDate = new Date(this.year, this.month, date + 1 );
          this.datepickerValue = selectedDate.toISOString().slice(0, 10);
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
