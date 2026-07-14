<x-master>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <div class="flex justify-between">
              <div>
              <h2
                class="my-6 text-4xl font-semibold text-black dark:text-gray-200"
              >
                Comptes Bancaires
              </h2>
            </div>
            <div class="flex justify-between">

              <div class="my-6">
                <img class="h-6" src="{{asset('storage/'.'printer.png')}}" onclick="window.print()">
            </div>  
            </div>          
          </div>
<hr>  
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
                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="px-4 py-3">N° du compte</th>
                      <th class="px-4 py-3">Abréviation</th>


                      <th class="px-4 py-3">Nom de la banque</th>

                      <th class="px-4 py-3">Actions</th>


                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >

                  @foreach ($banques as $banque)
            
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">

                          <!-- Avatar with inset shadow -->
                          <div
                            class="relative hidden w-8 h-8 mr-3 rounded-full md:block"
                          >
                            <img
                              class="object-cover w-full h-full rounded-full"
                              src="{{asset('storage/'.'floor-plan.png')}}"
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
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-700 dark:text-blue-100"
                        >                              
                              {{$banque->num }} 
                        </span>
                      <!-- </a> -->
                            </p>

                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">

                        {{ $banque->abreviation }} 
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{ $banque->nom }}
                      </td>


                      <td class="px-4 py-3 text-sm">
                        
              <div class="flex px-1 py-1">
              @can('editer banques')
                <div class="mr-1">
             
                <button
                  class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray"
                  aria-label="Like"
                  @click="modelOpen =!modelOpen, edit =! edit"
                   onclick="myFunction({{ $banque->id }})"
                >
                  <svg
                    class="w-4 h-4"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                  <path d="M12.2928932,3.70710678 L0,16 L0,20 L4,20 L16.2928932,7.70710678 L12.2928932,3.70710678 Z M13.7071068,2.29289322 L16,0 L20,4 L17.7071068,6.29289322 L13.7071068,2.29289322 Z" id="Combined-Shape"></path>
                  </svg>
                </button>

            </div>
            <div>
                        <form action="/banques/{{$banque->id}}" method="POST">
                        @csrf
                        @method('DELETE')
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
                      </form>
                      </div>   
                      @endcan             
              </div>

              
                      </td>




                    </tr>
                    @endforeach
                  </tbody>
                </table>
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
        <span>Ajouter un compte bancaire</span>        
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
                    <h1 class="text-xl font-medium text-gray-800 ">Ajouter un compte</h1>

                    <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                </div>

                <p class="mt-2 text-sm text-gray-500">
                    Ajouter un compte bancaire sur lequel se feront les versements des clients
                </p>
        @if(!$errors->isEmpty())
        <p class="block h-160 px-4 py-4 rounded-lg mx-auto w-full mt-4 mb-2
        bg-red-200 text-red-600 text-xl"> Attention Il y'a des erreurs dans votre formulaire</p>
        <h4>{{$errors->first()}}</h4>
        @endif

                <form class="mt-5" action="/banques" method="POST" id="edit-form">
                  @csrf
                    <div>
                        <label for="num" class="block text-sm text-gray-700 dark:text-gray-200">
                        Numéro du compte (*)</label>
                        <input placeholder="999 999 99 999 99999999999 99" type="text" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40"
                        id="num"
                        required
                        x-mask="999 999 99 999 99999999999 99"  
                        value="{{old('num')}}"
                        name="num">
                    @error('num')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror                        
                    </div>

                    <div class="mt-4">
                        <label for="nom" class="block text-sm text-gray-700 dark:text-gray-200">
                        Nom de la banque (*)</label>
                        <input placeholder="Nom de la banque" type="text" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40"
                        required
                        id="nom"
                        value="{{old('nom')}}"                            
                        name="nom">
                    @error('nom')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror                          
                    </div>
                    
                    <div class="mt-4">
                        <label for="abreviation" class="block text-sm text-gray-700 dark:text-gray-200">Abréviation (*)</label>
                        <input placeholder="Abréviation" type="text" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40"
                        id="abreviation" 
                        required
                        value="{{old('abreviation')}}"                            
                        name="abreviation">
                    @error('abreviation')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror                          
                    </div>                    
                    
                    <div class="flex justify-end mt-6">
                        <button type="submit" id="edit-button" class="px-3 py-2 text-sm tracking-wide text-white transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                            Ajouter
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
    var array = <?php echo $arrBanques; ?>;
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
