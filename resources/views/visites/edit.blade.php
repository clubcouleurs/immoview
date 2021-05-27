<x-master>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
        @if(!$errors->isEmpty())
        <p class="block h-160 px-4 py-4 rounded-lg mx-auto w-full mt-4
        bg-red-200 text-red-600 text-xl"> Attention Il y'a des erreurs dans votre formulaire</p>
        {{$errors}}
        @endif

            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Modification de la visite N° {{$visite->id}}
            </h2>
            <form action="/visites/{{$visite->id}}" method="POST">
              @csrf
              @method('PATCH')
              <input type="hidden" name="date" value="{{date_format(now(), 'Y-m-d H:i:s')}}">
            <div
              class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800"
            >

              <div class="mb-4 text-sm">

                    @error('typeContact')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror

                <span class="text-gray-700 dark:text-gray-400">
                  Type de contact
                </span>
                <div class="mt-2">
                  <label
                    class="inline-flex items-center text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="typeContact"
                      value="appel"
                      required
                      @if ($visite->typeContact == "appel")
                        checked
                      @endif 
                    />
                    <span class="ml-2">Appel téléphonique</span>
                  </label>
                  <label
                    class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="typeContact"
                      value="visite"
                      required
                      @if ($visite->typeContact == "visite")
                        checked
                      @endif                       
                    />
                    <span class="ml-2">Visite</span>
                  </label>                                           
                </div>
              </div>


              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Nom prospect</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                  type="text"
                  name="nom"
                  value="{{ $visite->client->nom }}"
                />
                    @error('nom')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>

              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Prénom prospect</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                  type="text"
                  name="prenom"
                  value="{{ $visite->client->prenom }}"
                />
                    @error('prenom')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>


 <div class="flex flex-wrap -mx-3 mb-2 mt-4">
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
             <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Pays</span>
              </label>
      <div class="relative">
        <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="pays">            
                  <option value="Maroc(+212)"
                  @if ($visite->client->pays == "Maroc(+212)")
                    selected
                  @endif
                      >Maroc(+212)</option>
                  <option value="France(+33)"
                  @if ($visite->client->pays == "France(+33)")
                    selected
                  @endif                  
                  >France(+33)</option>
                  <option value="Espagne(+34)"
                  @if ($visite->client->pays == "Espagne(+34)")
                    selected
                  @endif                  
                  >Espagne(+34)</option>    
                  <option value="Pays-bas(+31)"
                  @if ($visite->client->pays == "Pays-bas(+31)")
                    selected
                  @endif                  
                  >Pays-bas(+31)</option>
                  <option value="Belgique(+32)"
                  @if ($visite->client->pays == "Belgique(+32)" )
                    selected
                  @endif                  
                  >Belgique(+32)</option>
                  <option value="Allemagne(+49)"
                  @if ($visite->client->pays == "Allemagne(+49)")
                    selected
                  @endif                  
                  >Allemagne(+49)</option>
                  <option value="Italie(+39)"
                  @if ($visite->client->pays == "Italie(+39)")
                    selected
                  @endif                  
                  >Italie(+39)</option>   
        </select>
      </div>
    </div>
    <div class="w-full md:w-2/3 px-3 mb-6 md:mb-0">
             <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Mobile</span>
              </label>
    <input
                  class="w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                  type="text"
                  name="mobile"
                  maxlength="10"
                  value="{{ $visite->client->mobile }}"
                  required
                />
      </div>
      </div>

                    @error('mobile')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror

         

<div 
 x-data="{
                    isOpen: false,
                    @if ($visite->interet!=null && in_array($visite->interet, ['box','magasin','bureau']))
                      isOpen : true,
                      @else
                      isOpen : false,
                    @endif 
                     }" 
>

              <div class="mt-4 text-sm">

                    @error('type')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror

                <span class="text-gray-700 dark:text-gray-400">
                  Quel produit interesse le client ?
                </span>
                <div class="mt-2">
                  <label
                    class="inline-flex items-center text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="interet"
                      value="lot"
                      @if ($visite->interet == "lot")
                        checked
                      @endif     
                      x-on:click="isOpen = false"                                            

                    />
                    <span class="ml-2">Lot</span>
                  </label>
                  <label
                    class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="interet"
                      value="appartement"
                      @if ($visite->interet == "appartement")
                        checked
                      @endif              
                      x-on:click="isOpen = false"
                    />
                    <span class="ml-2">Appartement</span>
                  </label>
                  <label
                    class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="interet"
                      value="magasin"
                      @if ($visite->interet == "magasin")
                        checked
                      @endif       
                      x-on:click="isOpen = true"
                    />
                    <span class="ml-2">Magasin</span>
                  </label>
                  <label
                    class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="interet"
                      value="bureau"
                      @if ($visite->interet == "bureau")
                        checked
                      @endif   
                      x-on:click="isOpen = true"
                    />
                    <span class="ml-2">Bureau</span>
                  </label>
                  <label
                    class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="interet"
                      value="box"
                      @if ($visite->interet == "box")
                        checked
                      @endif      
                      x-on:click="isOpen = true"
                    />
                    <span class="ml-2">Box</span>
                  </label>                                                      
                </div>
              </div>
                <div x-show="isOpen" >

              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Surface Désirée</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                  name="surfaceDesired"
                  type="text"
                  value="{{$visite->surfaceDesired}}"
                  :disabled="!isOpen"
                />
                    @error('surfaceDesired')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>  

              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Domaine d'investissement</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                  name="domaine"
                  type="text"
                  value="{{$visite->domaine}}"
                  :disabled="!isOpen"
                />
                    @error('domaine')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>  
</div>
</div>

              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Remarques du prospect</span>
                <textarea
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  rows="3"
                  placeholder="Si vous avez une description et une observation à saisir"
                  name="remarqueClient"


                >{{ $visite->remarqueClient }}</textarea>
                    @error('remarqueClient')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror

              </label>
              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Description & Observations du commercial</span>
                <textarea
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  rows="3"
                  placeholder="Si vous avez une description et une observation à saisir"
                  name="detail"


                >{{ $visite->detail }}</textarea>
                    @error('detail')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>       

<div 
 x-data="{        isOpenAutre: false,
                    @if ($visite->source != null && $visite->source =='Autre'  )
                      isOpenAutre : true,
                    @endif 
                     }" 
>
             <div class="mt-4 text-sm">

                    @error('source')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror

                <span class="text-gray-700 dark:text-gray-400">
                  Comment le prospect a connu Tigumi Lkhir ?
                </span>
                <div class="mt-2">
                  <label
                    class="inline-flex items-center text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="source"
                      value="Site Web"
                      @if ($visite->source == "Site Web")
                        checked
                      @endif
                      x-on:click="isOpenAutre = false"
                      required
                    />
                    <span class="ml-2">Site Web</span>
                  </label>
                  <label
                    class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="source"
                      value="Facebook"
                      @if ($visite->source == "Facebook")
                        checked
                      @endif
                      x-on:click="isOpenAutre = false"  
                      required                    

                    />
                    <span class="ml-2">Facebook</span>
                  </label>
                  <label
                    class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="source"
                      value="Instagram"
                      @if ($visite->source == "Instagram")
                        checked
                      @endif
                      x-on:click="isOpenAutre = false"                      
                    />
                    <span class="ml-2">Instagram</span>
                  </label>
                  <label
                    class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="source"
                      value="Bouche à oreille"
                      @if ($visite->source == "Bouche à oreille")
                        checked
                      @endif
                      x-on:click="isOpenAutre = false"  
                      required                    

                    />
                    <span class="ml-2">Bouche à oreille</span>
                  </label>
                  <label
                    class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="source"
                      value="Kakemonos"
                      @if ($visite->source == "Kakemonos")
                        checked
                      @endif
                      x-on:click="isOpenAutre = false"   
                      required                                         
                    />
                    <span class="ml-2">Kakemonos</span>
                  </label>     
                  <label
                    class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="source"
                      value="Flyers & Dépliants"
                      @if ($visite->source == "Flyers & Dépliants")
                        checked
                      @endif
                      x-on:click="isOpenAutre = false"  
                      required                                          
                    />
                    <span class="ml-2">Flyers & Dépliants</span>
                  </label>    
                  <label
                    class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="source"
                      value="Autre"
                      @if ($visite->source == "Autre")
                        checked
                      @endif
                      x-on:click="isOpenAutre = true"   
                      required                                         
                    />
                    <span class="ml-2">Autre</span>
                  </label>                                                                                     
                </div>
              </div>


                <div x-show="isOpenAutre" >
              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Autre source d'information</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                  name="autre"
                  type="text"
                  value="{{$visite->autre}}"
                  :disabled="!isOpenAutre"
                />
                    @error('autre')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>  
          </div>

           <!--   <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                  Comment le prospect a connu Tigumi Lkhir ?
                </span>
                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  name="source"
                >
                  <option value="Site Web"
                    @if($visite->source == "Site Web")
                      selected
                    @endif                    
                    >Site Web</option>
                  <option value="Facebook"
                    @if($visite->source == "Facebook")
                      selected
                    @endif                    
                    >Facebook</option>                    
                  <option value="Instagram"
                    @if($visite->source == "Instagram")
                      selected
                    @endif                    
                    >Instagram</option>
                  <option value="Bouche à oreille"
                    @if($visite->source == "Bouche à oreille")
                      selected
                    @endif                    
                    >Bouche à oreille</option>
                  <option value="Kakemonos"
                    @if($visite->source == "Kakemonos")
                      selected
                    @endif                    
                    >Kakemonos</option>     
                  <option value="Flyers & Dépliant"
                    @if($visite->source == "Flyers & Dépliant")
                      selected
                    @endif                    
                    >Flyers & Dépliant</option>                                                    
                </select>
                    @error('source')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror                
              </label>     
              -->
              </div>                   
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