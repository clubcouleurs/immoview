<x-master>
      <main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
        @if(!$errors->isEmpty())
        <p class="block h-160 px-4 py-4 rounded-lg mx-auto w-full mt-4
        bg-red-200 text-red-600 text-xl"> Attention Il y'a des erreurs dans votre formulaire</p>
        @endif
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Ajouter un nouveau projet
            </h2>
            <form action="/projets" method="POST">
              @csrf

            <div
              class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800"
            >
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Nom du projet</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                  type="text"
                  name="nom"
                  value="{{old('nom')}}"
                  required
                />
                    @error('nom')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>

<!-- date picker -->
<div class="antialiased sans-serif" >
  <div x-data="app()" x-init="[initDate(), getNoOfDays()]" x-cloak>
    <div class="container mx-auto">
      <div>

        <label for="datepicker" class="block mt-4 text-sm text-gray-700 dark:text-gray-400">
        Date lancement du projet</label>
        <div class="relative">
          <input type="hidden" name="date" x-ref="date" :value="datepickerValue"
          >
          <input type="text" readonly x-model="datepickerValue" @click="showDatepicker = !showDatepicker" @keydown.escape="showDatepicker = false"
          class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
          placeholder="Date lancement du projet"
          >

          <div class="absolute top-0 right-0 px-3 py-2">
            <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </div>

          <!-- <div x-text="no_of_days.length"></div>
            <div x-text="32 - new Date(year, month, 32).getDate()"></div>
            <div x-text="new Date(year, month).getDay()"></div> -->

          <div class="z-10 bg-white mt-12 rounded-lg shadow p-4 absolute top-0 left-0" style="width: 17rem" x-show.transition="showDatepicker" @click.away="showDatepicker = false">

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

              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Titre foncier</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                  type="text"
                  name="titre"
                  value="{{old('titre')}}"
                  required
                />
                    @error('titre')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>
              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                  Entreprise : 
                </span>


                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  required
                  name="entreprise"
                >
                @foreach ($entreprises as $entreprise)
                  <option value="{{ $entreprise->id }}"
                    @if( old('entreprise') == $entreprise )
                          selected
                    @endif
                    >
                    {{$entreprise->nom}} 
                  </option>
                @endforeach

                </select>
              </label>

              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                  Ville du projet : 
                </span>


                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  required
                  name="ville"
                >
                @foreach ($villes as $ville)
                  <option value="{{ $ville }}"
                    @if( old('ville') == $ville )
                          selected
                    @endif
                    >
                    {{$ville }} 
                  </option>
                @endforeach

                </select>
              </label>

            <div class="mt-4 text-sm">

                    @error('default')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror

                <span class="text-gray-700 dark:text-gray-400">
                  Afficher le projet par défaut sur le dashboard
                </span>
                <div class="mt-2">
                  <label
                    class="inline-flex items-center text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="checkbox"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="default"
                      value="1"
                      @if(old('default') == '1')
                        checked
                      @endif
                     
                    />
                    <span class="ml-2">Oui</span>
                  </label>

                </div>
              </div>
              
              <div class="mt-4 text-sm">

                    @error('type_constructible')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror

                <span class="text-gray-700 dark:text-gray-400">
                  Les types des biens dans ce projet
                </span>
                <div class="mt-2">
                    @foreach($types_constructibles as $type)
                  <label
                    class="inline-flex items-center text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="checkbox"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="type_constructible[]"
                      value="{{getSingular($type)}}"
                    @if( old('type_constructible') !== null )
                      @foreach (old('type_constructible') as $t)
                        @if($t == $type)
                          checked
                        @endif
                      @endforeach
                    @endif
                    />
                    <span class="ml-2">{{ucfirst(getSingular($type))}}</span>
                  </label>
                  @endforeach

                </div>
              </div>              




                <div class="block mt-4 text-sm">
                <button
                  class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                  type="submit"
                >
                  Sauvegarder
                </button>
              </div>


            </div>
            </form>
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
            var str = new Date(this.year, this.month, today.getDate()).toLocaleDateString().slice(0, 10) 
            var an = str.substring(str.length - 4, str.length);
            var mois = str.substring(3,5);
            var jour = str.substring(0,2);
            this.datepickerValue = an + '-' + mois + '-' + jour;
          ;

        },
        isToday(date) {
          const today = new Date();
          const d = new Date(this.year, this.month, date);
          return today.toDateString() === d.toDateString() ? true : false;
        },
        getDateValue(date) {
            //let selectedDate = new Date(this.year, this.month, date );
             var str = new Date(this.year, this.month, date).toLocaleDateString().slice(0, 10) 
             var an = str.substring(str.length - 4, str.length);
             var mois = str.substring(3,5);
             var jour = str.substring(0,2);

             this.datepickerValue = '@if(old("date") != null ){{ old("date") }}@else' + 
            an + '-' + mois + '-' + jour; 
          + '@endif';
             

          //this.datepickerValue = selectedDate.toLocaleDateString().slice(0, 10);
          // this.$refs.date.value = selectedDate.getFullYear() + "-" + ('0' + selectedDate.getMonth()).slice(-2) + "-" + ('0' + selectedDate.getDate()).slice(-2);
          // console.log(this.$refs.date.value);
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