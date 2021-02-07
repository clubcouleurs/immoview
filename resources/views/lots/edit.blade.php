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
              Ajouter un nouveau lot
            </h2>
            <form action="/lots/{{$lot->id}}" method="POST">
              @csrf
              @method('PATCH')

            <div
              class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800"
            >
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">N° du lot</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                  type="number"
                  name="numLot"
                  required
                  value="{{$lot->numLot}}"
                />
                    @error('numLot')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>

              <label class="block   mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Surface du lot en m2</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                  type="number"
                  step="0.1"
                  name="surfaceLot"
                  required
                  value="{{$lot->surfaceLot}}"
                />
                    @error('surfaceLot')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>
              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                  Ce lot est sur les voie : 
                </span>
                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  multiple
                  required
                  name="voies[]"
                >
                @foreach ($voies as $voie)
                  <option value="{{ $voie->id }}"
                    @foreach ($lot->produit->voies as $produit_voie)
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
                  Sur quelle tranche se trouve ce lot ?
                </span>
                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  name="tranche"
                >
                @foreach ($tranches as $tranche)
                  <option value="{{ $tranche->id }}"
                      @if ($lot->tranche_id == $tranche->id)
                        selected
                      @endif                    
                    >Tranche {{$tranche->id}}</option>
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
                  value="{{$lot->produit->prixM2Indicatif}}"
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
                  value="{{$lot->produit->prixM2Definitif}}"

                  step="0.01"
                />
                    @error('prixM2Definitif')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>  

              <div class="mt-4 text-sm">

                    @error('typeLot')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror

                <span class="text-gray-700 dark:text-gray-400">
                  Type du lot
                </span>
                <div class="mt-2">
                  <label
                    class="inline-flex items-center text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="typeLot"
                      value="Commercial"
                      @if ($lot->typeLot == "Commercial")
                        checked
                      @endif                       
                    />
                    <span class="ml-2">Commercial</span>
                  </label>
                  <label
                    class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="typeLot"
                      value="Habitat"
                      @if ($lot->typeLot == "Habitat")
                        checked
                      @endif                       
                    />
                    <span class="ml-2">Habitat</span>
                  </label>
                </div>
              </div>
              
              <div class="mt-4 text-sm">

                <span class="text-gray-700 dark:text-gray-400">
                  Etat du lot
                </span>
                <div class="mt-2">
                                <label class="block text-sm">

                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  multiple
                  required
                  name="etatProduit"
                >
                @foreach ($etiquettes as $etiquette)
                  <option value="{{ $etiquette->id }}"
                    @if($etiquette->id == $lot->produit->etiquette_id)
                    selected
                    @endif
                    >{{$etiquette->label}}</option>
                @endforeach

                </select>
              </label>   
                                
                </div>
              </div>

              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                  Nombre d'Etages : R + ...
                </span>
                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  name="nombreEtagesLot"
                >
                  @for($i = 0; $i < 10; $i++)
                    <option @if(($i+1) == $lot->nombreEtagesLot) selected @endif>{{$i + 1}}</option>
                  @endfor
                </select>

                    @error('nombreEtagesLot')
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
                  name="descriptionLot"

                >{{ $lot->descriptionLot }}</textarea>
                    @error('descriptionLot')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror

              </label>

                <div class="block mt-4 text-sm">
                <button
                  class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
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