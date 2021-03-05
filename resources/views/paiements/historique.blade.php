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

                      <th class="px-4 py-3">Action</th>


                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >
                  @foreach($paiements as $p)
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
                <a
                  class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                  href="/dossiers/{{ $p->dossier->id }}/paiements/{{ $p->id }}"
                >
                  {{ $p->id }}
                </a>
                              </p>

                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{ number_format($p->montant) }}
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{ $p->date }}
                      </td>    
                      <td class="px-4 py-3 text-sm">
                        {{ $p->dossier->produit->constructible_type }} N° {{ $p->dossier->produit->constructible->num }}
                      </td> 
                      <td class="px-4 py-3 text-sm">
                        {{ $p->dossier->client->nom }} {{ $p->dossier->client->prenom }}
                      </td>                                                               
                      <form action="/dossiers/{{$p->dossier->id}}/paiements/{{$p->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                      <td class="px-4 py-3 text-sm">
              <div>
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
              </div>
              
                      </td>
                      </form>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div
                class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800"
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
