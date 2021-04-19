<x-master>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
        @if(!$errors->isEmpty())
        <p class="block h-160 px-4 py-4 rounded-lg mx-auto w-full mt-4
        bg-red-200 text-red-600 text-xl"> Attention Il y'a des erreurs dans votre formulaire</p>
        <h4>{{$errors->first()}}</h4>
        @endif

            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Modification d'un dossier du vente {{$dossier->produit->constructible_type}} N° {{$dossier->produit->constructible->num}} 
            </h2>

            @isset($produit)
              <div
                class="flex items-center justify-between p-2 mb-2 text-sm font-semibold text-blue-600 bg-blue-100 rounded-lg shadow-sm focus:outline-none focus:shadow-outline-blue rounded-2xl">
                {{$dataRecap}}
              </div>
              @else
             
            <!-- la boite pour rechercher un produit avant son affectation -->

<div class="bg-blue-100 rounded-lg px-4 py-4 mb-4 text-sm">
<div x-data="produitSearch()">
                <span class="text-gray-700 dark:text-gray-400">Quelle produit voudriez vous attachez à ce dossier ?</span>

    <input
    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"    
    type="number"
    name="produitSearch"
    x-model="produitSearch">

                    <div class="mt-2">
                  <label
                    class="inline-flex items-center text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                       name="typeSearch" x-model="typeSearch" 
                      value="Lot"
                      checked
                    />
                    <span class="ml-2">Lot</span>
                  </label>
                  <label
                    class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                       name="typeSearch" x-model="typeSearch" 
                      value="Appartement"
                    />
                    <span class="ml-2">Appartement</span>
                  </label>
                  <label
                    class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                       name="typeSearch" x-model="typeSearch" 
                      value="Magasin"
                    />
                    <span class="ml-2">Magasin</span>
                  </label>
                  <label
                    class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                       name="typeSearch" x-model="typeSearch" 
                      value="Bureau"
                    />
                    <span class="ml-2">Bureau</span>
                  </label>
                  <label
                    class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                       name="typeSearch" x-model="typeSearch" 
                      value="Box"
                    />
                    <span class="ml-2">Box</span>
                  </label>
                </div>

    <button
    type="submit"
    @click="fetchProduitn()"
    class="mt-2 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
    :class="[ isLoading ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-700' ]"
    :disabled="isLoading">
      Recherche
    </button>

                      @error('produit')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror 
  <template x-if="produitData">
    <div class="flex flex-row pt-4">

      <div class="text-sm justify-center flex flex-col">
        <h3 class="text-gray-900 text-sm font-bold uppercase leading-none mb-2" x-text="produitData.name"></h3>
      </div>
    </div>
  </template>
  
</div>
            </div>
<!-- fin boite recherche produit immo  -->

            @endisset
<div x-data="{
@if ( old('isVente') != null && (old('isVente') == '0' ))
  isOpen: true,
@else
  @if (isset($dossier->isVente) && ($dossier->isVente == '0' ))
    isOpen: true,
  @else
   isOpen: false,
  @endif
@endif
 }">
            <form action="/dossiers/{{$dossier->id}}" method="POST" x-on:submit.prevent
              id="DossierForm">
              @csrf
              @method('PUT')
              <input type="hidden" id="idProduit" name="produit" value="@isset($produit->id){{$produit->id}}@endisset">

            <div
              class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800"
            >
<!--               <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">N° du dossier</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                  type="number"
                  name="num"
                  value="{{$dossier->num}}"
                  required
                />
                    @error('num')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label> -->



<div class="mt-4 text-sm">

                    @error('isVente')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror

                <span class="text-gray-700 dark:text-gray-400">
                  Nature du dossier
                </span>
                <div class="mt-2">
                  <label
                    class="inline-flex items-center text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="isVente"
                      value="1"
                      required
                      x-on:click=" isOpen = false"
                {{ old('isVente', $dossier->isVente ?? '')== "1" ? 'checked' : '' }}                      
                      />
                    
                    <span class="ml-2">Vente</span>
                  </label>
                  <label
                    class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="isVente"
                      value="0"
                      required
                      x-on:click=" isOpen = true"
                      {{ old('isVente', $dossier->isVente ?? '')== "0" ? 'checked' : '' }}
                      />
                   
                    
                    <span class="ml-2">Réservation</span>
                  </label>

                                   
                </div>
              </div>

                    @error('delai')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror

@isset($dossier->delais->last()->date)
<input type="hidden" name="delai_id" value={{ $dossier->delais->first()->id }}>

@endisset


<!-- date picker -->
<div class="antialiased sans-serif" x-show="isOpen">
  <div x-data="app()" x-init="[initDate(), getNoOfDays()]" x-cloak>
    <div class="container mx-auto">
      <div class="mt-5 w-64">

        <label for="datepicker" class="block text-sm text-red-500">Délai pour rappeler le client</label>
        <div class="relative">
          <input type="hidden" name="delai" x-ref="date" :value="datepickerDelai"
          >
          <input type="text" readonly x-model="datepickerDelai" @click="showDatepicker = !showDatepicker" @keydown.escape="showDatepicker = false"
          class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
          placeholder="Date du dossier"
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
      <hr class="mt-4">
</div>
<!-- fin date picker-->



              @isset($clients)

              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                  Pour quel client ?
                </span>


                @foreach ($dossier->clients as $c)
<div class="mb-2" id="{{ $c->id }}">
      <div class="flex -mx-2">

 <div class="w-1/3 px-2 w-full ">

 <div
 class="relative focus-within:text-purple-600"
 >


                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  name="client[]"
                >
                  @foreach ($clients as $client)
                    <option value="{{ $client->id }}"
                      @if($c->id === $client->id)
                        selected
                      @endif
                      >{{$client->nom}} {{$client->prenom}} - {{$client->cin}}
                    </option>
                  @endforeach
                </select>
@if (!$loop->first)
 <button
 class="absolute inset-y-0 right-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-r-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
 @click="supprimer({{ $c->id }});">
 Supprimer
</button>
@endif
</div>    

</div>
</div>
<hr class="mt-4">
</div>

  @endforeach


<!-- 

                @foreach ($dossier->clients as $c)


                <div id="{{ $c->id }}">
                  <select
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                    name="client[]"
                    
                  >
                  @foreach ($clients as $client)
                    <option value="{{ $client->id }}"
                      @if($c->id === $client->id)
                        selected
                      @endif
                      >{{$client->nom}} {{$client->prenom}} - {{$client->cin}}
                    </option>
                  @endforeach
                  </select>
 <button
 class="absolute inset-y-0 mb-2 mt-2 right-2 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-r-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
 @click="supprimer({{ $c->id }});">
 Supprimer
</button>

</div>

                @endforeach -->
              </label>  





<!-- ajouter un autre client au dossier de vente -->
<section
x-data="{
client:[],
todos:[


      @php
      $i = 0 ;
      @endphp

   @while (null !== old('client.'.$i) )
    {
      id: {{$i}} ,
      name : 'client{{$i}}' , 
      client : '{{old('client.'.$i)}}',
    },
      @php
      $i++;
      @endphp
    @endwhile
],

newTodo:'',
addTodo(){
this.todos.push({
id: this.todos.length +1,
name : this.client.push(this.todos.length) ,

});
},

deleteTodo(todo){

this.todos.splice(this.todos.indexOf(todo), 1 );
}

}"
>




  

  <button type="button" class="px-4 py-2 mt-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple mb-2" @click="addTodo">
    + Ajouter un client

  </button>
  <hr class="mt-2">



<section x-show="todos.length">
  <template x-for="todo in todos" :key="todo.id">
    <div class="mb-2">
      <div class="flex -mx-2">

 <div class="w-1/3 px-2 w-full ">

 <div
 class="relative focus-within:text-purple-600"
 >


                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  name="client[]"
                 :key="todo.id"
                  :value="todo.client"
                 :id="todo.name"
                >
                @foreach ($clients as $client)
                  <option value="{{ $client->id }}">{{$client->nom}} {{$client->prenom}} - {{$client->cin}}</option>
                @endforeach
                </select>


     @error('p.*')
        <p class="block px-2 py-2 rounded-md w-full mt-2
    bg-red-600 text-white text-xs"> Attention :{{ $message }}</p>
    @enderror
 <button
 class="absolute inset-y-0 right-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-r-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
 @click="deleteTodo(todo)">
 Supprimer
</button>
</div>    

</div>
</div>
<hr class="mt-4">
</div>
</template>
</section>


</section>

<!-- fin d'ajout d'un autre client au dossier de vente -->

              @else
              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                  Ce dossier sera affecté au client
                </span>
                <input type="hidden" name="client" value="{{$client->id}}">
            <div
              class="flex items-center justify-between p-2 mb-2 text-sm font-semibold text-blue-600 bg-blue-100 shadow-sm focus:outline-none focus:shadow-outline-blue rounded-lg">
              {{$client->nom}} {{$client->prenom}} | CIN N° : {{$client->cin}} | Mobile : {{$client->mobile}}
            </div>
              </label>                 
              @endisset

<!-- date picker -->
<div class="antialiased sans-serif">
  <div x-data="app()" x-init="[initDate(), getNoOfDays()]" x-cloak>
    <div class="container mx-auto">
      <div class="mt-5 w-64">

        <label for="datepicker" class="block text-sm text-gray-700 dark:text-gray-400">Date du dossier</label>
        <div class="relative">
          <input type="hidden" name="date" x-ref="date" :value="datepickerValue">
          <input type="text" readonly x-model="datepickerValue" @click="showDatepicker = !showDatepicker" @keydown.escape="showDatepicker = false"
          class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
          placeholder="Date du dossier">

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
              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Frais du dossier</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                  type="number"
                  step="0.1"
                  name="frais"
                  value="{{$dossier->frais}}"

                  required
                />
                    @error('frais')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>
              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Description & Observations</span>
                <textarea
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  rows="3"
                  placeholder="Si vous avez une description et une observation à saisir"
                  name="detail"
                >{{$dossier->detail}}</textarea>
                    @error('detail')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror

              </label>

<!-- début upload pièce jointe >
<div  x-data="{

  @if (isset($dossier->actePj))
    isOpen: true
  @else
   isOpen: false
  @endif

 }"
              <div class="mt-4 text-sm" x-show="isOpen">
                    @error('actePj')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror

                <span class="text-gray-700 dark:text-gray-400">
                  La pièce scanné
                </span>
                <div class="mt-2">

@if (isset($dossier->actePj) && ($dossier->actePj !== Null))
<section
x-data="{
logoToDelete:false,
logos:[],
logoDb:true,
addLogo(){
this.logos.push({
id: this.logos.length +1,
});
//this.logoToDelete = true;
},

}"
>
<input type="hidden" name="logoToDelete" :value="logoToDelete">

<section x-show="logoDb">
            <button
            class="relative align-middle rounded-md focus:outline-none focus:shadow-outline-purple"
            @click="addLogo(), logoDb = ! logoDb"
            :aria-expanded="logoDb ? 'true' : 'false'" :class="{ 'active': logoDb }"
            type="button"
            >
            <span
            aria-hidden="true"
            class="inline-block align-middle absolute text-md shadow-xs font-bold text-white top-0 right-0
            bg-red-600 w-6 h-6 transform translate-x-2 -translate-y-2 rounded-full"
            >X</span></button>

            @if (substr($dossier->actePj, -3) == 'pdf' )
            <a href="{{ asset($dossier->actePj) }}" download="actePj"
              class="text-blue-500 underline border px-4 py-4 bg-blue-100">Télécharger L'acte</a>
            @else
            <img src="{{asset($dossier->actePj)}}" width="250" class="px-2 py-2 w-48 border border-blue-400 shadow-lg rounded-lg mb-2">
            @endif         
        </section>
          <section x-show="logos.length">
  <template x-for="logo in logos" :key="logo.id">

    <input
    type="file"
    name="actePj"
    id="actePj"
    :required="logoDb"
    :disabled="logoDb"    
    >
  </template>
        </section>
      </section>


        @error('actePj')
        <p id="logoError" class="block h-10 px-2 py-2 rounded-md w-full mt-2
        bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
        @enderror

here was the form to delete the logo

    @else

        
    <input
    type="file"
    name="actePj"
    id="actePj"
    :required="logoDb"
    :disabled="logoDb"
    >

    @error('actePj')
    <p id="logoError" class="block h-10 px-2 py-2 rounded-md w-full mt-2
    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
    @enderror
    @endif
                </div>
              </div>              
</div>
             
             fin upload pièce jointe -->

                <div class="block mt-4 text-sm">
                <button
                  class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green"
                  type="submit"
                  @click="submit();"
                >
                  Modifier
                </button>
              </div>


            </div>
            </form>

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

            var str = new Date(this.year, this.month, today.getDate()).toLocaleDateString().slice(0, 10) 
            var an = str.substring(str.length - 4, str.length);
            var mois = str.substring(3,5);
            var jour = str.substring(0,2);

          this.datepickerValue = '@isset($dossier->date){{ $dossier->date }}@else' + 
            an + '-' + mois + '-' + jour; 
          + '@endisset';

            var str = new Date(this.year, this.month, today.getDate()).toLocaleDateString().slice(0, 10)
            var an = str.substring(str.length - 4, str.length);
            var mois = str.substring(3,5);
            var jour = str.substring(0,2);
          this.datepickerDelai = '@isset($dossier->delais->first()->date){{ $dossier->delais->first()->date->format('Y-m-d') }}@else'
          +
            an + '-' + mois + '-' + jour; 
          + '@endisset';


        },
        isToday(date) {
          const today = new Date();
          const d = new Date(this.year, this.month, date);
          return today.toDateString() === d.toDateString() ? true : false;
        },
        getDateValue(date) {
          // let selectedDate = new Date(this.year, this.month, date );
          //this.datepickerValue = selectedDate.toLocaleDateString().slice(0, 10);
          //this.datepickerDelai = selectedDate.toLocaleDateString().slice(0, 10);

             var str = new Date(this.year, this.month, date).toLocaleDateString().slice(0, 10) 
             var an = str.substring(str.length - 4, str.length);
             var mois = str.substring(3,5);
             var jour = str.substring(0,2);

            this.datepickerValue = an + '-' + mois + '-' + jour;
            this.datepickerDelai = an + '-' + mois + '-' + jour;

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
  <script type="text/javascript">
function removeElement(element) {
    element && element.parentNode && element.parentNode.removeChild(element);
}

function supprimer(id) {
  removeElement( document.getElementById(id) );
}

function submit() {
  document.getElementById("DossierForm").submit();
}

    function produitSearch() {
      return {
        produitSearch: 0,
        typeSearch: 'Lot',
        produitData: null,
        isLoading: false,
        fetchProduitn() {
          this.isLoading = true;
          fetch(`{{ url('/produits_data/') }}/${this.produitSearch}/${this.typeSearch}`)
            .then((res) => res.json())
            .then((data) => {
              this.isLoading = false;
              this.produitData = data;
              document.getElementById('idProduit').value = data.id ;
            });
        },
      };
    }
  </script>

</x-master>            