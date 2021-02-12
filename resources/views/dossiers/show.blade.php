<x-master>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">



            <h2
              class="my-6 text-4xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Récapitulatif du dossier de vente N° {{$dossier->num}}
            </h2>

<!--md:grid-cols-1 xl:grid-cols-2-->

            <div class="grid gap-6 mb-2 md:grid-cols-1 xl:grid-cols-4">
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
              <!-- Card -->
              <div
                class="row-span-1 p-2 bg-red-50 rounded-lg shadow-md dark:bg-gray-800"
              >
                  <table class="w-full">
                  <tbody class="divide-y dark:divide-gray-700 dark:bg-gray-800">
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <div><p class="font-semibold">
                            <span
                              class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-md dark:bg-red-700 dark:text-red-100">
                              N° Réservation :
                            </span>
                            </p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                          {{$dossier->num}}
                      </td>
                    </tr>
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <div><p class="font-semibold">
                            <span
                              class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-md dark:bg-red-700 dark:text-red-100">
                              Date Réservation :                      
                            </span>
                            </p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                          {{$dossier->date}}
                      </td>
                    </tr> 
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <div><p class="font-semibold">
                            <span
                              class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-md dark:bg-red-700 dark:text-red-100">
                              Frais du dossier :                     
                            </span>
                            </p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                          {{number_format($dossier->frais)}} Dhs
                      </td>
                    </tr>  
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <div><p class="font-semibold">
                            <span
                              class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-md dark:bg-red-700 dark:text-red-100">
                              Observation :                       
                            </span>
                            </p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                          {{$dossier->detail}}
                      </td>
                    </tr>   
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3 col-span-2">
                        <div class="flex items-center text-sm">
                          <div>
                            
                                  <button
                                    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red"
                                    type="submit"
                                  >
                                    Modifier
                                  </button>                                                     
                            
                          </div>
                        </div>
                      </td>
                     
                    </tr>                                                                            
                  </tbody>
                </table>
                
              </div>

 

<!-- Card lot -->
              <div class="row-span-2 bg-blue-50 rounded-lg p-4 shadow-md dark:bg-gray-800">

<table class="w-full">
                  <tbody class="divide-y dark:divide-gray-700 dark:bg-gray-800">
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <div><p class="font-semibold">
                            <span
                              class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-md dark:bg-green-700 dark:text-green-100">
                              N° {{$dossier->produit->constructible_type}} :
                            </span>
                            </p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                          {{$dossier->produit->constructible->num}}
                      </td>
                    </tr>
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <div><p class="font-semibold">
                            <span
                              class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-md dark:bg-green-700 dark:text-green-100">
                              Surface :                      
                            </span>
                            </p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                          {{$dossier->produit->constructible->surface}} m<sup>2</sup>
                      </td>
                    </tr> 
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <div><p class="font-semibold">
                            <span
                              class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-md dark:bg-green-700 dark:text-green-100">
                              Tranche :                     
                            </span>
                            </p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                          {{$dossier->produit->constructible->tranche->num}}
                      </td>
                    </tr>  
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <div><p class="font-semibold">
                            <span
                              class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-md dark:bg-green-700 dark:text-green-100">
                              Etage :                       
                            </span>
                            </p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                          R+{{$dossier->produit->constructible->etage}}
                      </td>
                    </tr>
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <div><p class="font-semibold">
                            <span
                              class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-md dark:bg-green-700 dark:text-green-100">
                              Prix par m<sup>2</sup> définitif                      
                            </span>
                            </p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                          {{number_format($dossier->produit->prixM2Definitif)}} Dhs 
                      </td>
                    </tr>
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <div><p class="font-semibold">
                            <span
                              class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-md dark:bg-green-700 dark:text-green-100">
                              Prix par m<sup>2</sup> indicatif                      
                            </span>
                            </p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                          {{number_format($dossier->produit->prixM2Indicatif)}} Dhs 
                      </td>
                    </tr> 
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <div><p class="font-semibold">
                            <span
                              class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-md dark:bg-green-700 dark:text-green-100">
                              Prix Total définitif                      
                            </span>
                            </p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                          {{number_format($dossier->produit->totalDefinitif)}} Dhs 
                      </td>
                    </tr>
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <div><p class="font-semibold">
                            <span
                              class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-md dark:bg-green-700 dark:text-green-100">
                              Prix Total Indicatif                      
                            </span>
                            </p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                          {{number_format($dossier->produit->totalIndicatif)}} Dhs
                      </td>
                    </tr> 
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <div><p class="font-semibold">
                            <span
                              class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-md dark:bg-green-700 dark:text-green-100">
                              {{$dossier->produit->remiseNature}} 
                            </span>
                            </p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                          {{$dossier->produit->remise}} %                     
                      </td>
                    </tr>                     


                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3 col-span-2">
                        <div class="flex items-center text-sm">
                          <div>
                            
                                  <button
                                    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green"
                                    type="submit"
                                  >
                                    Modifier
                                  </button>                                                     
                            
                          </div>
                        </div>
                      </td>
                     
                    </tr>                                                                            
                  </tbody>
                </table>



              </div>

              <div class="row-span-2 col-span-2 bg-blue-50 rounded-lg p-4 shadow-md md:grid-cols-1 dark:bg-gray-800">
<!-- Doughnut/Pie chart -->
              <div
                class="min-w-0 p-4 rounded-lg shadow-xs dark:bg-gray-800"
              >
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                  Etat des avances
                </h4>
                <canvas id="pie"></canvas>
                <div
                  class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400"
                >
                  <!-- Chart legend -->
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-red-500 rounded-full"
                    ></span>
                    <span>Avance</span>
                  </div>
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-gray-400 rounded-full"
                    ></span>
                    <span>Restant à payer</span>
                  </div>

                </div>
              </div>
              
              </div>   

             <div
                class="row-span-1 p-2 bg-green-50 rounded-lg shadow-md dark:bg-gray-800"
              >
                  <table class="w-full">
                  <tbody class="divide-y dark:divide-gray-700 dark:bg-gray-800">
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <div><p class="font-semibold">
                            <span
                              class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-md dark:bg-green-700 dark:text-green-100">
                              Nom Client :
                            </span>
                            </p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                          {{$dossier->client->nom}}
                      </td>
                    </tr>
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <div><p class="font-semibold">
                            <span
                              class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-md dark:bg-green-700 dark:text-green-100">
                              Prénom Client :                      
                            </span>
                            </p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                          {{$dossier->client->prenom}}
                      </td>
                    </tr> 
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <div><p class="font-semibold">
                            <span
                              class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-md dark:bg-green-700 dark:text-green-100">
                              CIN :                     
                            </span>
                            </p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                          {{$dossier->client->cin }}
                      </td>
                    </tr>  
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <div><p class="font-semibold">
                            <span
                              class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-md dark:bg-green-700 dark:text-green-100">
                              Mobile :                       
                            </span>
                            </p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                          {{$dossier->client->mobile}}
                      </td>
                    </tr>   
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3 col-span-2">
                        <div class="flex items-center text-sm">
                          <div>
                            
                                  <button
                                    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green"
                                    type="submit"
                                  >
                                    Modifier
                                  </button>                                                     
                            
                          </div>
                        </div>
                      </td>
                     
                    </tr>                                                                            
                  </tbody>
                </table>
                
              </div>


<!-- fin des cartes -->
            </div>
            

         

<div class="grid gap-6 mb-8 md:grid-cols-2">




          </div>
        </main>

<script>
var v1={{ $dossier->tauxPaiement }};
var v2={{ 100 - $dossier->tauxPaiement }};

</script>

    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"
      defer
    ></script>        
    <script src="{{config('app.url')}}/js/charts-pie-paiement.js" defer></script>


</x-master>