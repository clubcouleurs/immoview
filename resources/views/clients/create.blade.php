<x-master>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
        @if(!$errors->isEmpty())
        <p class="block h-160 px-4 py-4 rounded-lg mx-auto w-full mt-4
        bg-red-200 text-red-600 text-xl"> Attention Il y'a des erreurs dans votre formulaire</p>
        {{--$errors--}}
        @endif

            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Voudrez vous affecter un produit immobilier à ce client ?
            </h2>

            <!-- la boite pour rechercher un produit avant son affectation -->

<div class="bg-blue-100 rounded-lg px-4 py-4 mb-4 text-sm">
<div x-data="pokeSearch()">

    <input
    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"    
    type="number"
    name="pokemonSearch"
    x-model="pokemonSearch">

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
    @click="fetchPokemon()"
    class="mt-2 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
    :class="[ isLoading ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-700' ]"
    :disabled="isLoading">
      Recherche
    </button>

  
  <template x-if="pokemon">
    <div class="flex flex-row pt-4">

      <div class="text-sm justify-center flex flex-col">
        <h3 class="text-gray-900 text-sm font-bold uppercase leading-none mb-2" x-text="pokemon.name"></h3>
      </div>
    </div>
  </template>
  
</div>
            </div>
<!-- fin boite recherche produit immo  -->


            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Ajouter une nouvelle fiche client
            </h2>

            <div
              class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800"
            >
            <form action="/clients" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="date" value="{{date_format(now(), 'Y-m-d H:i:s')}}">
              <input type="hidden" id="idProduit" name="idProduit" value="">

              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Nom client</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="El Mourabit"
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
              <label class="block text-sm mt-4">
                <span class="text-gray-700 dark:text-gray-400">Nom client en Arabe</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="المرابط"
                  type="text"
                  name="nomAr"
                  value="{{old('nomAr')}}"
                />
                    @error('nomAr')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>
              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Prénom client</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Sarah"
                  type="text"
                  name="prenom"
                  value="{{old('prenom')}}"
                  required
                />
                    @error('prenom')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>
              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Prénom client en Arabe</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="سارة"
                  type="text"
                  name="prenomAr"
                  value="{{old('prenomAr')}}"
                />
                    @error('prenomAr')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>

              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">N°CIN client</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="JB385698"
                  type="text"
                  name="cin"
                  value="{{old('cin')}}"
                  required
                />
                    @error('cin')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>           

<!-- début upload pièce jointe -->
              <div class="mt-4 text-sm" x-show="isOpen">
                <span class="text-gray-700 dark:text-gray-400">
                  La CIN scannée
                </span>
                <div class="mt-2">

@if (isset($client->cinPj) && ($client->cinPj !== Null))
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

            <img src="{{asset($client->cinPj)}}" width="250" class="px-2 py-2 w-48 border border-blue-400 shadow-lg rounded-lg mb-2">
   
        </section>
          <section x-show="logos.length">
  <template x-for="logo in logos" :key="logo.id">

    <input
    type="file"
    name="cinPj"
    id="cinPj"
    :required="logoDb"
    :disabled="logoDb"    
    >



  </template>
        </section>           


   
      </section>


        @error('cinPj')
        <p id="logoError" class="block h-10 px-2 py-2 rounded-md w-full mt-2
        bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
        @enderror

<!-- here was the form to delete the logo -->

    @else

        
    <input
    type="file"
    name="cinPj"
    id="cinPj"
    required
    >

    @error('cinPj')
    <p id="logoError" class="block h-10 px-2 py-2 rounded-md w-full mt-2
    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
    @enderror
    @endif
                </div>
              </div>              

             
              <!-- fin upload pièce jointe -->
     

              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Mobile</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="0661381545"
                  type="text"
                  name="mobile"
                  maxlength="10"
                  value="{{old('mobile')}}"
                />

                    @error('mobile')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>  


              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Adresse</span>
                <textarea
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  rows="3"
                  placeholder="Adresse du client"
                  name="adresse"
                  required

                >{{old('adresse')}}</textarea>
                    @error('adresse')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror

              </label>
            

              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Adresse en Arabe</span>
                <textarea
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  rows="3"
                  placeholder="العنوان"
                  name="adresseAr"
                >{{old('adresseAr')}}</textarea>
                    @error('adresseAr')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror

              </label>

                <div class="block mt-4 text-sm">
                <button
                  class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                  type="submit"
                >
                  Sauvegarder
                </button>
              </div>

</form>
            </div>
            
          </div>
        </main>

  <script type="text/javascript">
    function pokeSearch() {
      return {
        pokemonSearch: 0,
        typeSearch: 'Lot',
        pokemon: null,
        isLoading: false,
        fetchPokemon() {
          this.isLoading = true;
          fetch(`{{ url('/produits_data/') }}/${this.pokemonSearch}/${this.typeSearch}`)
            .then((res) => res.json())
            .then((data) => {
              this.isLoading = false;
              this.pokemon = data;
              document.getElementById('idProduit').value = data.id ;
            });
        },
      };
    }
  </script>

</x-master>            