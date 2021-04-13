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
              Enregistrer les actes légalisés du vente {{$dossier->produit->constructible_type}} N° {{$dossier->produit->constructible->num}}
            </h2>

            <div
              class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800"
            >   

              <div
                class="flex items-center justify-between p-2 mb-4 text-sm font-semibold text-blue-600 bg-blue-100 rounded-lg shadow-sm focus:outline-none focus:shadow-outline-blue rounded-2xl">
            Ce dossier concerne : {{ucfirst($dossier->produit->constructible_type)}} N° {{$dossier->produit->constructible->num}}, d'une superficie totale de {{$dossier->produit->constructible->surface}} m2. Le prix total est de : {{number_format($dossier->produit->total)}} Dhs ({{number_format($dossier->produit->prix)}} Dhs/m2). <br> Attribué aux clients:
            @foreach($dossier->clients as $client)
            {{$client->nom}} {{$client->prenom}},
            @endforeach 
            depuis le {{$dossier->date}}.

           </div>                     
            <div class="grid gap-6 mb-6 sm:grid-cols-1 md:grid-cols-1 xl:grid-cols-4">

<div class="p-2 bg-gray-500 rounded-lg dark:bg-gray-800"> 
                    <p class="text-white font-bold">
                      Prix total {{ $dossier->produit->constructible_type }} :</p>
                            <p class="font-semibold text-2xl text-white dark:text-gray-400">
                          {{ number_format($dossier->produit->total) }} Dhs
                            </p>                             
                </div>
                <div class="p-2 bg-green-500 rounded-lg dark:bg-gray-800">              
                    <p class="text-white font-bold">
                      Total des avances :</p>
                            <p class="font-semibold text-2xl text-white dark:text-gray-400">
                          {{ number_format($dossier->totalPaiements) }} Dhs
                            </p>                   
                </div>
                <div class="p-2 bg-blue-500 rounded-lg dark:bg-gray-800">              
                    <p class="font-semibold text-white font-bold">
                      Taux des avances :</p>
                            <p class="text-2xl text-white dark:text-gray-400">
                          {{  $dossier->tauxPaiement }} %
                            </p>                   
                </div>
                <div class="p-2 bg-red-500 rounded-lg dark:bg-gray-800">              
                    <p class="text-white font-bold">
                      Reste à payer :</p>
                            <p class="font-semibold text-2xl text-white dark:text-gray-400">
                          {{ number_format($dossier->Reliquat) }} Dhs
                            </p>                    
                </div>            
</div>

            <form action="/dossiers/{{$dossier->id}}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')

<!-- début upload pièce jointe -->
              <div class="mt-4 text-sm" x-show="isOpen">
                    @error('actePj')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror

                <span class="text-gray-700 dark:text-gray-400">
                  Les actes légalisés et scanné
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
            <a href="{{ asset($dossier->actePj) }}" download="pj"
              class="text-blue-500 underline border px-4 py-4 bg-blue-100">Télécharger votre logo</a>
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
    required>



  </template>
        </section>           


   
      </section>


        @error('actePj')
        <p id="logoError" class="block h-10 px-2 py-2 rounded-md w-full mt-2
        bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
        @enderror

<!-- here was the form to delete the logo -->

    @else

        
    <input
    type="file"
    name="actePj"
    id="actePj"
    required
    >

    @error('actePj')
    <p id="logoError" class="block h-10 px-2 py-2 rounded-md w-full mt-2
    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
    @enderror
    @endif
                </div>
              </div>              

             
              <!-- fin upload pièce jointe -->



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
</x-master>            