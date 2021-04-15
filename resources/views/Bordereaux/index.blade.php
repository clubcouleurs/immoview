<x-master>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">


        @if(!$errors->isEmpty())
        <p class="block h-160 px-4 py-4 rounded-lg mx-auto w-full mt-4
        bg-red-200 text-red-600 text-xl"> Attention Il y'a des erreurs dans votre formulaire
      {{$errors}}</p>
        @endif

            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Générer un nouveau bordereau

            </h2>


            <form enctype="multipart/form-data"
            action=@isset ($bordereau->montant){{"/dossiers/$dossier->id/bordereaux/" . $bordereau->id}}@else "/dossiers/{{$dossier->id}}/bordereaux" @endisset
            method="POST">
              @csrf
              @isset ($bordereau->montant)
                @method('PATCH')
              @endisset

            <div
              class="px-4 py-3 mb-6 bg-white rounded-lg shadow-md dark:bg-gray-800"
            >

              <label class="block text-sm ">
                <span class="text-gray-700 dark:text-gray-400">Montant</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Le montant du versement"
                  type="number"
                  name="montant"
                  required
                  value="{{ old('montant') ?? $bordereau->montant ?? '' }}"

                />
                    @error('montant')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>

              <div class="mt-4 text-sm">
                    @error('banque')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror

                <span class="text-gray-700 dark:text-gray-400">
                  Destination du versement
                </span>
                <div class="mt-2">
                @foreach ($banques as $banque)
                  <label
                    class="inline-flex items-center mr-6 text-gray-600 dark:text-gray-400"
                  >
                    <input
                      type="radio"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="banque"
                      required 
                      value="{{$banque->id}}"
                      {{ old('banque', $bordereau->banque->id ?? '')== $banque->id ? 'checked' : '' }}
                      />
                    
                    <span class="ml-2">{{$banque->abreviation}}</span>
                  </label>
                @endforeach
                </div>
              </div>

              

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
                      href="/dossiers/{{ $dossier->id }}/bordereaux"
                    >
                  Nouveau paiement
                </a> 

                  @else

                 <button
                    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                    type="submit"
                  >
                    Sauvegarder & générer
                  </button>
                 
                  @endisset
              </div>


            </div>
            </form>


            <h2
              class="mb-2 text-4xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Récapitulatif des bordereaux du dossier N°{{$dossier->num}}
            </h2>
                            <div
                              class="flex items-center justify-between p-3 mb-2 text-sm font-bold text-blue-600 bg-blue-100 rounded-lg shadow-sm focus:outline-none focus:shadow-outline-blue rounded-2xl"
                              
                            >
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                            @foreach($dossier->clients as $client)
                              Client : {{ $client->nom}} {{ $client->prenom}} {{ $client->cin}} - 
                            @endforeach 

                              Produit : {{ $dossier->produit->constructible_type}} N°{{ $dossier->produit->constructible->num}}
                            </p> 
                          </div>

            <div class="grid gap-6 mb-2 sm:grid-cols-1 md:grid-cols-1 xl:grid-cols-6">
                <div class="p-2 bg-gray-500 rounded-lg dark:bg-gray-800"> 
                    <p class="text-white font-bold">
                      Prix total {{ $dossier->produit->constructible_type }} :</p>
                            <p class="font-semibold text-2xl text-white dark:text-gray-400">
                          {{ number_format($dossier->produit->total) }} Dhs
                            </p>                             
                </div>
                <div class="p-2 bg-green-500 rounded-lg dark:bg-gray-800">              
                    <p class="text-white font-bold">
                      Total avances Encaissées :</p>
                            <p class="font-semibold text-2xl text-white dark:text-gray-400">
                          {{ number_format($dossier->totalbordereauxV) }} Dhs
                            </p>                   
                </div>
                <div class="p-2 bg-red-500 rounded-lg dark:bg-gray-800">              
                    <p class="text-white font-bold">
                      Total bordereaux non-validés :</p>
                            <p class="font-semibold text-2xl text-white dark:text-gray-400">
                          {{ number_format($dossier->totalbordereaux - $dossier->totalbordereauxV) }} Dhs
                            </p>                   
                </div>  
                <div class="p-2 bg-red-500 rounded-lg dark:bg-gray-800">              
                    <p class="text-white font-bold">
                      Avance non-encaissées :</p>
                            <p class="font-semibold text-2xl text-white dark:text-gray-400">
                          {{ number_format(
                            ( $dossier->produit->total * 30 / 100 ) - $dossier->totalbordereaux) }} Dhs
                            </p>                   
                </div>                               
                <div class="p-2 bg-blue-500 rounded-lg dark:bg-gray-800">              
                    <p class="font-semibold text-white font-bold">
                      Taux des avances :</p>
                            <p class="text-2xl text-white dark:text-gray-400">
                          {{  $dossier->tauxPaiementV }} %
                            </p>                   
                </div>
                <div class="p-2 bg-red-500 rounded-lg dark:bg-gray-800">              
                    <p class="text-white font-bold">
                      Reste à payer :</p>
                            <p class="font-semibold text-2xl text-white dark:text-gray-400">
                          {{ number_format($dossier->Reliquat) }} Dhs
                            </p>                    
                </div>                              
              <!-- Card -->
            </div>
                                    
            <!-- New Table -->
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
              <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="px-4 py-3">N° du Bordereau</th>
                      <th class="px-4 py-3">Montant</th>
                      <th class="px-4 py-3">Date du bordereau</th>
                      <th class="px-4 py-3">Destination du versement</th>
                      <th class="px-4 py-3">Action</th>


                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >
                  @foreach($bordereaux as $p)
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <!-- Avatar with inset shadow -->
                          <div
                            class="relative hidden w-8 h-8 mr-3 rounded-full md:block"
                          >
                            <img
                              class="object-cover w-full h-full rounded-full"
                              src="{{asset('dollar.png')}}"
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
                  href="/dossiers/{{ $dossier->id }}/bordereaux/{{ $p->id }}"
                >
                  {{ $p->id }}
                </a>
                              </p>

                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{ number_format($p->montant) }}
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{ $p->created_at->diffForHumans() }}
                      </td>    


                      <td class="px-4 py-3 text-sm">
                        {{ $p->banque->abreviation }}
                      </td>

                      
                      <td class="px-4 py-3 text-sm">
                        <form action="/dossiers/{{$dossier->id}}/bordereaux/{{$p->id}}" method="POST">
                          @csrf
                          @method('PATCH')
                    {!!$p->validate!!}
                    </form>
                  </td>
                      <td class="px-4 py-3 text-sm">
                         <div class="flex px-1 py-1">             
      <div class="mr-1">
                <a
                  class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red"
                  aria-label="Like"
                  target="_blank"
                  href="/dossiers/{{$dossier->id}}/bordereaux/{{$p->id}}/generate"
                >
                    <svg
                    class="w-4 h-4"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                        <path d="M14,14 L18,14 L18,2 L2,2 L2,14 L6,14 L6,14.0020869 C6,15.1017394 6.89458045,16 7.99810135,16 L12.0018986,16 C13.1132936,16 14,15.1055038 14,14.0020869 L14,14 L14,14 Z M0,1.99079514 C0,0.891309342 0.898212381,0 1.99079514,0 L18.0092049,0 C19.1086907,0 20,0.898212381 20,1.99079514 L20,18.0092049 C20,19.1086907 19.1017876,20 18.0092049,20 L1.99079514,20 C0.891309342,20 0,19.1017876 0,18.0092049 L0,1.99079514 L0,1.99079514 Z M4,4 L16,4 L16,6 L4,6 L4,4 L4,4 Z M4,7 L16,7 L16,9 L4,9 L4,7 L4,7 Z M4,10 L16,10 L16,12 L4,12 L4,10 L4,10 Z" id="Combined-Shape"></path>
                    </svg>
                </a>
             </div>
                      
              <div>
                      <form action="/dossiers/{{$dossier->id}}/bordereaux/{{$p->id}}" method="POST">
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
                </div>

                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div
                class="grid py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t"
              >
                {{$bordereaux->links()}}
              </div>
            </div>


          </div>
        </main>
</x-master>
