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
              Modifier l'appartement N°{{$appartement->num}}
            </h2>
            <form action="/appartements/{{$appartement->id}}" method="POST">
              @csrf
              @method('PATCH')
            <div x-data="{ isOpenPrix: false,
            @if($appartement->type != 'Economique')
                isOpenPrix: true,
            @endif
          }"
              class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800"
            >
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">N° de l'appartement</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                  type="number"
                  name="numApp"
                  value="{{$appartement->num}}"
                  required
                />
                    @error('numApp')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>

              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Surface couvert en m2</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                  type="number"
                  step="0.01"
                  name="surfaceApp"
                  value="{{$appartement->surfaceApp }}"

                  required
                />
                    @error('surfaceApp')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>
              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Surface Terrasse en m2</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                  type="number"
                  step="0.01"
                  name="surfaceTerrasse"
                  value="{{$appartement->surfaceTerrasse }}"

                  required
                />
                    @error('surfaceTerrasse')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>              
              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                  Cet appartement est sur les voie : 
                </span>


                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  multiple
                  required
                  name="voies[]"
                >
                @foreach ($voies as $voie)
                  <option value="{{ $voie->id }}"
                    @foreach ($appartement->produit->voies as $produit_voie)
                      @if ($voie->id == $produit_voie->id)
                      selected
                      @endif
                    @endforeach
                    >{{$voie->Largeur}} m</option>

                @endforeach


                </select>
              </label>

              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                  Sur quelle immeuble se trouve cet appartement ?
                </span>
                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  name="immeuble"
                >
                @foreach ($immeubles as $immeuble)
                  <option value="{{ $immeuble->id }}"
                    @if($appartement->immeuble->id == $immeuble->id)
                      selected
                    @endif                    
                    >Immeuble {{$immeuble->num}}</option>
                @endforeach

                </select>
              </label>              

                   <div class="mt-4 text-sm">

                    @error('type')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror

                <span class="text-gray-700 dark:text-gray-400">
                  Type de l'appartement
                </span>
                <div class="mt-2">
                  <label
                    class="inline-flex items-center text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="type"
                      value="Economique"
                      x-on:click="isOpenPrix = !isOpenPrix"

                      @if($appartement->type == 'Economique')
                        checked
                      @endif                    
                    />
                    <span class="ml-2">Economique</span>
                  </label>
                  <label
                    class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="type"
                      value="Standing"
                      x-on:click="isOpenPrix = !isOpenPrix"

                      @if($appartement->type == 'Standing')
                        checked
                      @endif                        
                    />
                    <span class="ml-2">Standing </span>
                  </label>
                </div>
              </div>
            <div x-show="!isOpenPrix"
              class="flex items-center justify-between p-3 mt-2 text-sm font-semibold text-blue-600 bg-blue-100 rounded-lg shadow-sm focus:outline-none focus:shadow-outline-blue rounded-2xl">
              Le prix pour cet apprtement est : 250.000 Dhs
              
            </div>


              <div x-show="isOpenPrix">
              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Prix au m2 indicatif</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                  type="number"
                  name="prixM2Indicatif"
                  step="0.01"
                  value="{{$appartement->produit->prixM2Indicatif}}"
                  :required="isOpenPrix"
                  :disabled="!isOpenPrix"
                  @cannot('editer prix produits')    
                    readonly
                  @endcannot                   
                />
                    @error('prixM2Indicatif')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>  

              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Prix au m2 définitif{{ $appartement->produit->prixM2Definitif }}</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                  type="number"
                  name="prixM2Definitif"
                  value="{{ $appartement->produit->prixM2Definitif }}"
                  step="0.01"
                  :required="isOpenPrix"
                  :disabled="!isOpenPrix"                    
                />
                    @error('prixM2Definitif')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>  


<div class="flex flex-wrap -mx-3 mb-2 mt-4">
    <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
        Chambres
      </label>
      <div class="relative">
        <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state"
        name="chambres">
          <option value ="1"
            @if($appartement->chambres == 1)
              selected
            @endif>1</option>
          <option value ="2"
            @if($appartement->chambres == 2)
              selected
            @endif>2</option>
          <option value ="3"
            @if($appartement->chambres == 3)
              selected
            @endif>3</option>
          <option value ="4"
            @if($appartement->chambres == 4)
              selected
            @endif>4</option>                               
        </select>
      </div>
    </div>

    <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
        Cuisines
      </label>
      <div class="relative">
        <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state"
        name="cuisines">
          <option value ="1"
            @if($appartement->cuisines == 1)
              selected
            @endif>1</option>
          <option value ="2"
            @if($appartement->cuisines == 2)
              selected
            @endif>2</option>
          <option value ="3"
            @if($appartement->cuisines == 3)
              selected
            @endif>3</option>
          <option value ="4"
            @if($appartement->cuisines == 4)
              selected
            @endif>4</option>          
        </select>
      </div>
    </div>

    <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
        Salles de bain
      </label>
      <div class="relative">
        <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state"
        name="sdbs">
          <option value ="1"
            @if($appartement->sdbs == 1)
              selected
            @endif>1</option>
          <option value ="2"
            @if($appartement->sdbs == 2)
              selected
            @endif>2</option>
          <option value ="3"
            @if($appartement->sdbs == 3)
              selected
            @endif>3</option>
          <option value ="4"
            @if($appartement->sdbs == 4)
              selected
            @endif>4</option>          
        </select>
      </div>
    </div>

    <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
        Toilettes
      </label>
      <div class="relative">
        <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state"
        name="toilettes">
          <option value ="1"
            @if($appartement->toilettes == 1)
              selected
            @endif>1</option>
          <option value ="2"
            @if($appartement->toilettes == 2)
              selected
            @endif>2</option>
          <option value ="3"
            @if($appartement->toilettes == 3)
              selected
            @endif>3</option>
          <option value ="4"
            @if($appartement->toilettes == 4)
              selected
            @endif>4</option>          
        </select>
      </div>
    </div>

    <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
        Extra
      </label>
      <div class="relative">
        <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state"
        name="extra">
          <option value ="Balcon"
            @if($appartement->extra == 'Balcon')
              selected
            @endif>Balcon</option>
          <option value ="Cour"
            @if($appartement->extra == 'Cour')
              selected
            @endif>Cour</option>
          <option value ="Terrasse"
            @if($appartement->extra == 'Terrasse')
              selected
            @endif>Terrasse</option>
          <option value ="Balcon & Terrasse"
            @if($appartement->extra == 'Balcon & Terrasse')
              selected
            @endif>Balcon & Terrasse</option>  
        </select>
      </div>
    </div>
  </div>              
              <!--div end section isOpen-->
              </div>




              
             @isset($appartement->produit->dossier)
              <div
                class="flex items-center justify-between p-2 mt-4 mb-2 text-sm font-semibold text-red-600 bg-red-100 rounded-lg shadow-sm focus:outline-none focus:shadow-outline-red rounded-2xl">
                Attention : Vous ne pourrez pas modifier l'état de ce produit car déjà réservé pour le(s) client(s)
                @foreach ($appartement->produit->dossier->clients as $client)
                {{ $client->nom . ' ' . $client->prenom}} |  
                @endforeach
              </div>

              @else  

              <div class="mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                  Etat de l'appartement
                </span>
                <div class="mt-2">
                                <label class="block text-sm">
                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  required
                  name="etatProduit"
                >
                @foreach ($etiquettes as $etiquette)
                  <option value="{{ $etiquette->id }}"
                    @if($appartement->produit->etiquette_id == $etiquette->id)
                      selected
                    @endif
                    >
                    {{$etiquette->label}}
                  </option>
                @endforeach

                </select>
              </label>   
                                
                </div>
              </div>

              @endisset
              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                  A quelle étage se trouve cet appartement : R + ... 
                </span>
                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  name="etage"
                >
                  @for($i = 1; $i < 11; $i++)
                    <option value="{{$i}}"
                    @if($appartement->etage == $i)
                      selected
                    @endif

                    >{{$i}}</option>
                  @endfor
                </select>

                    @error('etage')
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
                  name="description"


                >{{ $appartement->description }}</textarea>
                    @error('description')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror

              </label>

                <div class="block mt-4 text-sm">
                <button
                  class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green"
                  type="submit"
                >
                  Modifier
                </button>
              </div>


            </div>
            </form>
          </div>
        </main>
</x-master>            