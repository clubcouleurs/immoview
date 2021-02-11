<x-master>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">


        @if(!$errors->isEmpty())
        <p class="block h-160 px-4 py-4 rounded-lg mx-auto w-full mt-4
        bg-red-200 text-red-600 text-xl"> Attention Il y'a des erreurs dans votre formulaire
      {{$errors}}</p>
        @endif

            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Ajouter un nouveau paiement 
            </h2>
            <form action=@isset ($paiement->montant){{"/dossiers/$dossier->id/paiements/" . $paiement->id}}@else "/dossiers/{{$dossier->id}}/paiements" @endisset
            method="POST">
              @csrf
              @isset ($paiement->montant)
                @method('PATCH')
              @endisset

            <div
              class="px-4 py-3 mb-6 bg-white rounded-lg shadow-md dark:bg-gray-800"
            >

<!-- date picker -->
<div class="antialiased sans-serif">
  <div x-data="app()" x-init="[initDate(), getNoOfDays()]" x-cloak>
    <div class="container mx-auto">
      <div class="w-64">

        <label for="datepicker" class="block text-sm text-gray-700 dark:text-gray-400">Date du paiement</label>
        <div class="relative">
          <input type="hidden" name="date" x-ref="date" :value="datepickerValue">
          <input type="text" readonly x-model="datepickerValue" @click="showDatepicker = !showDatepicker" @keydown.escape="showDatepicker = false"
          class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
          placeholder="Date du paiement">

          <div class="absolute top-0 right-0 px-3 py-2">
            <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </div>

          <!-- <div x-text="no_of_days.length"></div>
            <div x-text="32 - new Date(year, month, 32).getDate()"></div>
            <div x-text="new Date(year, month).getDay()"></div> -->

          <div class="bg-white mt-12 rounded-lg shadow p-4 absolute top-0 left-0" style="width: 17rem" x-show.transition="showDatepicker" @click.away="showDatepicker = false">

            <div class="flex justify-between items-center mb-2">
              <div>
                <span x-text="MONTH_NAMES[month]" class="text-lg font-bold text-gray-800"></span>
                <span x-text="year" class="ml-1 text-lg text-gray-600 font-normal"></span>
              </div>
              <div>
                <button type="button" class="focus:outline-none focus:shadow-outline transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full" @click="if (month == 0) {
                        year--;
                        month = 12;
                      } month--; getNoOfDays()">
                  <svg class="h-6 w-6 text-gray-500 inline-flex" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                  </svg>
                </button>
                <button type="button" class="focus:outline-none focus:shadow-outline transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full" @click="if (month == 11) {
                        month = 0; 
                        year++;
                      } else {
                        month++; 
                      } getNoOfDays()">
                  <svg class="h-6 w-6 text-gray-500 inline-flex" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                  </svg>
                </button>
              </div>
            </div>

            <div class="flex flex-wrap mb-3 -mx-1">
              <template x-for="(day, index) in DAYS" :key="index">
                <div style="width: 14.26%" class="px-1">
                  <div x-text="day" class="text-gray-800 font-medium text-center text-xs"></div>
                </div>
              </template>
            </div>

            <div class="flex flex-wrap -mx-1">
              <template x-for="blankday in blankdays">
                <div style="width: 14.28%" class="text-center border p-1 border-transparent text-sm"></div>
              </template>
              <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                <div style="width: 14.28%" class="px-1 mb-1">
                  <div @click="getDateValue(date)" x-text="date" class="cursor-pointer text-center text-sm leading-none rounded-full leading-loose transition ease-in-out duration-100" :class="{'bg-blue-500 text-white': isToday(date) == true, 'text-gray-700 hover:bg-blue-200': isToday(date) == false }"></div>
                </div>
              </template>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>  
      
</div>

      <!-- fin date picker-->
    
        
<div x-data="{
@if (isset($paiement->type) && ($paiement->type != 'Espèce' ))
  isOpen: true
@else
 isOpen: false
@endif 

 }">
<div class="mt-4 text-sm">

                    @error('type')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror

                <span class="text-gray-700 dark:text-gray-400">
                  Nature du paiement
                </span>
                <div class="mt-2">
                  <label
                    class="inline-flex items-center text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="type"
                      value="Espèce"
                      x-on:click=" isOpen = false"
                      @if (!isset($paiement->type))
                          checked
                      @endif                      
                      @if (isset($paiement->type) && ($paiement->type == 'Espèce' ))
                      checked
                      @endif
                    />
                    <span class="ml-2">Espèce</span>
                  </label>
                  <label
                    class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="type"
                      value="Chèque"
                      x-on:click=" isOpen = true"
                        @if (isset($paiement->type) && ($paiement->type == 'Chèque' ))
                          checked
                        @endif                      
                    />
                    <span class="ml-2">Chèque</span>
                  </label>
                  <label
                    class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="type"
                      value="Effet"
                      x-on:click=" isOpen = true"
                      @if (isset($paiement->type) && ($paiement->type == 'Effet' ))
                      checked
                      @endif                        
                    />
                    <span class="ml-2">Effet</span>
                  </label>
                  <label
                    class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="type"
                      value="Virement"
                      x-on:click="isOpen = true"
                      @if (isset($paiement->type) && ($paiement->type == 'Virement' ))
                      checked
                      @endif                        
                    />
                    <span class="ml-2">Virement</span>
                  </label>                                    
                </div>
              </div>
             <label class="block text-sm mt-4" x-show="isOpen">
                <span class="text-gray-700 dark:text-gray-400">Numéro de la pièce</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                  type="text"
                  name="num"
                  :required="isOpen"
                  :disabled="!isOpen"
                  value="@isset ($paiement->num){{$paiement->num}}@endisset"
                />
                    @error('num')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>

</div>

              <label class="block text-sm mt-4">
                <span class="text-gray-700 dark:text-gray-400">Montant</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                  type="number"
                  name="montant"
                  required
                  value="@isset ($paiement->montant){{$paiement->montant}}@endisset"
                />
                    @error('montant')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>

                <div class="block mt-4 text-sm">
                  @isset($paiement->montant)
                   <button
                    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-green-800 focus:outline-none focus:shadow-outline-purple"
                    type="submit"
                  >
                    Modifier
                  </button>
                  <a
                      class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                      href="/dossiers/{{ $dossier->id }}/paiements"
                    >
                  Nouveau paiement
                </a> 

                  @else

                 <button
                    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                    type="submit"
                  >
                    Sauvegarder
                  </button>
                 
                  @endisset
              </div>


            </div>
            </form>


            <h2
              class="mb-2 text-4xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Récapitulatif des paiements du dossier N°{{$dossier->num}}
            </h2>
                            <div
                              class="flex items-center justify-between p-3 mb-2 text-sm font-bold text-blue-600 bg-blue-100 rounded-lg shadow-sm focus:outline-none focus:shadow-outline-blue rounded-2xl"
                              
                            >
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                              Client : {{ $dossier->client->nom}} {{ $dossier->client->prenom}} {{ $dossier->client->cin}} - 
                              Produit : {{ $dossier->produit->constructible_type}} N°{{ $dossier->produit->constructible->num}}
                            </p> 
                          </div>

                            <div
                              class="flex items-center justify-between p-3 mb-4 text-sm font-bold text-red-600 bg-red-100 rounded-lg shadow-sm focus:outline-none focus:shadow-outline-red rounded-2xl"
                              
                            >
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                              Prix total du produit :
                              {{ number_format($dossier->produit->prixM2Definitif * $dossier->produit->constructible->surfaceLot) }}
                              | Total des avances :
                              {{ number_format($dossier->paiements()->sum('montant')) }}
                              | Taux de paiements :
                              {{ round($dossier->paiements()->sum('montant')*100/
                              ($dossier->produit->prixM2Definitif * $dossier->produit->constructible->surfaceLot), 2 ) }} %
                              | Reliquat :
                              {{ number_format(($dossier->produit->prixM2Definitif * $dossier->produit->constructible->surfaceLot) - $dossier->paiements()->sum('montant'))
                               }} Dhs                          
                            </p> 
                          </div>                          
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
                      <th class="px-4 py-3">Numéro de la pièce</th>

                      <th class="px-4 py-3">Action</th>


                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >

                  @foreach ($paiements as $p)
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <!-- Avatar with inset shadow -->
                          <div
                            class="relative hidden w-8 h-8 mr-3 rounded-full md:block"
                          >
                            <img
                              class="object-cover w-full h-full rounded-full"
                              src="https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&ixid=eyJhcHBfaWQiOjE3Nzg0fQ"
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
                  href="/dossiers/{{ $dossier->id }}/paiements/{{ $p->id }}"
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
                        {{ $p->type }}
                      </td> 
                      <td class="px-4 py-3 text-sm">
                        {{ $p->num }}
                      </td>                                                               
                      <form action="/dossiers/{{$dossier->id}}/paiements/{{$p->id}}" method="POST">
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
