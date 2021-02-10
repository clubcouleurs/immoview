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
              Ajouter un nouveau paiement 
            </h2>
            <form action=@isset ($paiement->montant){{"/paiements/" . $paiement->id}}@else "/paiements" @endisset
            method="POST">
              @csrf
              @isset ($paiement->montant)
                @method('PATCH')
              @endisset

            <div
              class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800"
            >
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Montant</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                  type="number"
                  name="montant"
                  required
                  value="@isset ($paiement->montant){{$paiement->montant}}@endisset"
                />
                    @error('montant')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>





                <div class="block mt-4 text-sm">
                  @isset($paiement->montant)
                   <button
                    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-green-800 focus:outline-none focus:shadow-outline-purple"
                    type="submit"
                  >
                    Modifier
                  </button>
                  <a
                      class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                      href="/paiements"
                    >
                  Nouveau paiement
                </a> 

                  @else

                 <button
                    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                    type="submit"
                  >
                    Sauvegarder
                  </button>
                 
                  @endisset
              </div>


            </div>
            </form>


            <h2
              class="mt-6 text-4xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Récapitulatif des paiements du dossier N°{{$dossier->num}}
            </h2>
                            <p class="mb-6 text-xs text-gray-600 dark:text-gray-400 mt-1">
                              Client : {{ $dossier->client->nom}} {{ $dossier->client->prenom}} {{ $dossier->client->cin}}<br>
                              Produit : {{ $dossier->produit->[produit->type]->num}} {{ $dossier->client->prenom}} {{ $dossier->client->cin}}<br>                              
                            </p> 

            <!-- New Table -->
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
              <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="px-4 py-3">N° du paiement</th>
                      <th class="px-4 py-3">Montant</th>
                      <th class="px-4 py-3">Date du paiement</th>

                      <th class="px-4 py-3">Action</th>


                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >

                  @foreach ($paiements as $paiement)
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <!-- Avatar with inset shadow -->
                          <div
                            class="relative hidden w-8 h-8 mr-3 rounded-full md:block"
                          >
                            <img
                              class="object-cover w-full h-full rounded-full"
                              src="https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&ixid=eyJhcHBfaWQiOjE3Nzg0fQ"
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
                <a
                  class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                  href="/paiements/{{ $paiement->id }}"
                >
                  {{ $paiement->id }}
                </a>
                              </p>

                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{ $paiement->montant }}
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{ $paiement->date }}
                      </td>                      
                      <form action="/paiements/{{$paiement->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                      <td class="px-4 py-3 text-sm">
              <div>
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
              </div>
              
                      </td>
                      </form>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div
                class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800"
              >
                {{$paiements->links()}}
              </div>
            </div>


          </div>
        </main>
</x-master>