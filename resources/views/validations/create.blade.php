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
              Validation du dossier N° : {{$dossier->num}}
            </h2>

            <div
              class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800"
            >   
              <div
                class="flex items-center justify-between p-2 mb-4 text-sm font-semibold text-red-600 bg-red-100 rounded-lg shadow-sm focus:outline-none focus:shadow-outline-red rounded-2xl">
            Attention : Une fois validé, l'acte de réservation de ce dossier sera générer même si le client n'as pas payé 30% du montant globale

           </div> 

              <div
                class="flex items-center justify-between p-2 mb-4 text-sm font-semibold text-blue-600 bg-blue-100 rounded-lg shadow-sm focus:outline-none focus:shadow-outline-blue rounded-2xl">
            Ce dossier concerne : {{ucfirst($dossier->produit->constructible_type)}} N° {{$dossier->produit->constructible->num}}, d'une superficie totale de {{$dossier->produit->constructible->surface}} m2. Le prix total est de : {{number_format($dossier->produit->total)}} Dhs ({{number_format($dossier->produit->prix)}} Dhs/m2). <br> Attribué au client {{$dossier->client->nom}} {{$dossier->client->prenom}} depuis le {{$dossier->date}}.

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

            <form action="/dossiers/{{$dossier->id}}/validation" method="POST">
              @csrf
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Pourquoi vous validez ce dossier</span>
                <textarea
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  rows="3"
                  placeholder="La raison de la validation"
                  name="raison"
                  required

                >{{old('raison')}}</textarea>
                    @error('raison')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror

              </label>

                <div class="block mt-4 text-sm">
                <button
                  class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                  type="submit"
                >
                  Valider
                </button>
              </div>


            </div>
            </form>
          </div>
        </main>
</x-master>            