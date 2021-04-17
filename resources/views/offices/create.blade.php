<x-master>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
        @if(!$errors->isEmpty())
        <p class="block h-160 px-4 py-4 rounded-lg mx-auto w-full mt-4
        bg-red-200 text-red-600 text-xl"> Attention Il y'a des erreurs dans votre formulaire</p>
        @endif
        {{--var_dump(old())--}}
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Ajouter un nouveau bureau
            </h2>
            <form action="/offices" method="POST">
              @csrf

            <div x-data="{
                      isOpen: false,

                    @if (old('type')!=null && old('type') == 'Appartement')
                      isOpenApp: true,
                      isOpen : true,
                    @else

                     isOpenApp: false,
                    @endif 
                    @if (old('type')!=null && old('type') == 'Magasin')
                      isOpenMag: true,
                      isOpen : true,
                    @else
                     isOpenMag: false
                    @endif                     
                     }" 
              class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800"
            >
            <!-- début bloc choix type bureau  -->
              <div class="inline-flex items-center text-sm mb-4">
                    @error('type')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror

                <div class="">
                      <span class="mr-4 text-gray-700 dark:text-gray-400">
                          Type de bureau
                      </span>                  
                  <label
                    class=" text-gray-600 dark:text-gray-400"
                  >

                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="type"
                      value="Magasin"
                      x-on:click="isOpenApp = false, isOpenMag = true, isOpen = true"
                      @if(old('type') == 'Magasin')
                        checked
                      @endif
                    />
                    <span class="ml-2">Magasin</span>
                  </label>
                  <label
                    class="ml-6 text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="type"
                      value="Appartement"
                      x-on:click="isOpenApp = true, isOpenMag = false, isOpen = true"

                      @if(old('type') == 'Appartement')
                        checked
                      @endif                      
                    />
                    <span class="ml-2">Appartement</span>
                  </label>
                </div>
              </div>
                <hr>

              <!-- fin bloc choix type bureau -->
              <div x-show="isOpen" class="mt-4">
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">N° du bureau</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                  type="number"
                  name="numBur"
                  value="{{old('numBur')}}"
                  required
                />
                    @error('numBur')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>

              <!-- début inputs pour type apprtement -->
              <div x-show="isOpenApp" >

              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Surface couvert en m2</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                  type="number"
                  step="0.01"
                  name="surfaceApp"
                  :required="isOpenApp"
                  :disabled="!isOpenApp"                  
                  value="{{old('surfaceApp')}}"

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
                  :required="isOpenApp"
                  :disabled="!isOpenApp"                  
                  value="{{old('surfaceTerrasse')}}"

                  required
                />
                    @error('surfaceTerrasse')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>
              </div>
              <!-- fin inputs pour type apprtement -->

              <!-- début inputs pour type Magasin -->
              <div x-show="isOpenMag" >

              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Surface Plancher en m2</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                  type="number"
                  step="0.01"
                  :required="isOpenMag"
                  :disabled="!isOpenMag"                  
                  name="surfacePlancher"
                  value="{{old('surfacePlancher')}}"

                  required
                />
                    @error('surfacePlancher')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>
              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Surface Mezzanine en m2</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                  type="number"
                  step="0.01"
                  :required="isOpenMag"
                  :disabled="!isOpenMag"                  
                  name="surfaceMezzanine"
                  value="{{old('surfaceMezzanine')}}"

                  required
                />
                    @error('surfaceMezzanine')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>
              </div>
              <!-- fin inputs pour type Magasin -->



              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                  Ce bureau est sur les voie : 
                </span>


                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  multiple
                  required
                  name="voies[]"
                >
                @foreach ($voies as $voie)
                  <option value="{{ $voie->id }}"
                    @if( old('voies') !== null )
                      @foreach (old('voies') as $v)
                        @if($v == $voie->id)
                          selected
                        @endif
                      @endforeach
                    @endif

                    >

                    {{$voie->Largeur}} m
                  </option>
                @endforeach

                </select>
              </label>

              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                  Sur quelle immeuble se trouve ce bureau ?
                </span>
                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  name="immeuble"
                >
                @foreach ($immeubles as $immeuble)
                  <option value="{{ $immeuble->id }}"
                    @if(old('immeuble') == $immeuble->id)
                      selected
                    @endif                    
                    >Immeuble {{$immeuble->id}}</option>
                @endforeach

                </select>
              </label>              

     

              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Prix au m2 indicatif</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                  type="number"
                  name="prixM2Indicatif"
                  step="0.01"
                  value="{{old('prixM2Indicatif')}}"

                  required
                />
                    @error('prixM2Indicatif')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>  

              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Prix au m2 définitif</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                  type="number"
                  name="prixM2Definitif"
                  value="{{old('prixM2Definitif')}}"

                  step="0.01"
                />
                    @error('prixM2Definitif')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>  
             
              <div class="mt-4 text-sm">

                <span class="text-gray-700 dark:text-gray-400">
                  Etat du bureau
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
                    @if(old('etatProduit') == $etiquette->id)
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


              <label class="block mt-4 text-sm" x-show="isOpenApp" >
                <span class="text-gray-700 dark:text-gray-400">
                  A quelle étage se trouve ce bureau : R + ...
                </span>
                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  name="etage"
                >
                  @for($i = 1; $i < 11; $i++)
                    <option value="{{$i}}"
                    @if(old('etage') == $i)
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


                >{{old('description')}}</textarea>
                    @error('description')
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

              </div>
            </div>
            </form>
          </div>
        </main>
</x-master>            