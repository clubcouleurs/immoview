<x-master>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
        @if(!$errors->isEmpty())
        <p class="block h-160 px-4 py-4 rounded-lg mx-auto w-full mt-4
        bg-red-200 text-red-600 text-xl"> Attention Il y'a des erreurs dans votre formulaire</p>
        @endif
        {{--$errors--}}
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Pas de contrat pour les {{p($type)}} pour le moment. <br>
              Voulez-vous créer un ?
            </h2>
           
      <div>
           <form action="/contrats" method="POST">
              @csrf
                <div class="block text-sm">
                <input type="hidden" value="{{$type}}" name="type">
                <button
                  class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                  type="submit"
                  @click="submit();"
                >
                  Oui, créer un !
                </button>
              </div>
            </form>
      </div>

<!--       <div class="mt-2">
           <form action="/contratsDuplicate" method="POST">
              @csrf
                <div class="block text-sm">
                <input type="hidden" value="{{$type}}" name="type">
                <button
                  class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                  type="submit"
                  @click="submit();"
                >
                  Dupliquer un contrat existant !
                </button>
              </div>
            </form>
      </div>   -->    

          </div>


<div x-data="{ 
  @if(!$errors->isEmpty())
  modelOpen: true
  @else
  modelOpen: false
  @endif
   , edit : true}">


            <!-- New Table -->
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
              <div class="w-full overflow-x-auto">
              
              </div>

            </div>
            
            <!-- modal pour ajouter un compte bancaire -->
    <button @click="modelOpen =!modelOpen"
    onclick="resetFunction()"
    class="mt-4 flex items-center justify-center py-2 space-x-2 tracking-wide transform px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple
    focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
        </svg>
        <span>Dupliquer un contrat existant</span>
    </button>
    <div x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
            <div x-cloak @click="modelOpen = false" x-show="modelOpen" 
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0" 
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100" 
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"
            ></div>

            <div x-cloak x-show="modelOpen" 
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block w-full max-w-xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl"
            >
                <div class="flex items-center justify-between space-x-4">
                    <h1 class="text-xl font-medium text-gray-800 ">Dupliquer un contrat existant</h1>

                    <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                </div>

        @if(!$errors->isEmpty())
        <p class="block h-160 px-4 py-4 rounded-lg mx-auto w-full mt-4 mb-2
        bg-red-200 text-red-600 text-xl"> Attention Il y'a des erreurs dans votre formulaire</p>
        <h4>{{$errors->first()}}</h4>
        @endif

                <form class="mt-5" action="/contratsDuplicate" method="POST" id="edit-form">
                  @csrf
                <input type="hidden" value="{{$type}}" name="type">
                  
              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                  Projets : 
                </span>


                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  required
                  name="projet"
                >
                @foreach ($projets as $projet)
                  <option value="{{ $projet->id }}"
                    @if( old('projet') == $projet )
                          selected
                    @endif
                    >
                    {{$projet->nom}} 
                  </option>
                @endforeach

                </select>
              </label>                                   
                    
                    <div class="flex justify-end mt-6">
                        <button type="submit" id="edit-button" class="px-3 py-2 text-sm tracking-wide text-white transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                            Dupliquer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>            
            <!-- modal pour ajouter un compte bancaire -->
          </div>
<script>

  function myFunction(id){
    var array = <?php  ?>;
    document.getElementById("num").value = array[id]['num'];
    document.getElementById("nom").value = array[id]['nom'];
    document.getElementById("abreviation").value = array[id]['abreviation'];
    document.getElementById("edit-form").action = "/banques/"+id;
    document.getElementById("edit-button").innerText = "Modifier";

      var input = document.createElement("input");
      input.setAttribute("type", "hidden");
      input.setAttribute("name", "_method");
      input.setAttribute("value", "PATCH");
      document.getElementById("edit-form").appendChild(input);
  }

  function resetFunction(){
    document.getElementById("num").value = "";
    document.getElementById("nom").value = "";
    document.getElementById("abreviation").value = "";
    document.getElementById("edit-form").action = "/banques" ;
    document.getElementById("edit-button").innerText = "Ajouter";

  }  
</script>
        </main>
</x-master>

