<x-master>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
<h2
              class="flex my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
            @php
              $file = ($visite->typeContact== null) ? 'visite.png' : $visite->typeContact.'.png' ;
            @endphp
            <img class="h-12 mr-4" src="{{asset($file)}}">
              {{ucfirst($visite->typeContact)}} N°{{$visite->id}}
            </h2>
            <!-- CTA -->
            <div
              class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800"
            >
              <p class="text-sm text-gray-600 dark:text-gray-400">
                Date : {{ $visite->date }}
              </p>
            </div>



            <!-- Big section cards -->
            <h4
              class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300"
            >
              Le client est intéressé par le produit immobilier :
            </h4>
              <div class="capitalize flex items-center flex items-center justify-between p-4 mb-8 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple">
                
                <span>{{$visite->interet}}
                  @if($visite->surfaceDesired != null)
                  - surface désirée : {{$visite->surfaceDesired}} m<sup>2</sup>
                  @endif

                  @if($visite->domaine != null)
                  - domaine d'investissement : {{$visite->domaine}}
                  @endif                  

                </span>
              </div>


            <!-- Responsive cards -->
            <h4
              class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300"
            >
              Informations du client
            </h4>
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"
                    ></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Nom et prénom du client
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{ $visite->client->nom}} {{ $visite->client->prenom}}
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M11.1735916,16.8264084 C7.57463481,15.3079672 4.69203285,12.4253652 3.17359164,8.82640836 L5.29408795,6.70591205 C5.68612671,6.31387329 6,5.55641359 6,5.00922203 L6,0.990777969 C6,0.45097518 5.55237094,3.33066907e-16 5.00019251,3.33066907e-16 L1.65110039,3.33066907e-16 L1.00214643,8.96910337e-16 C0.448676237,1.13735153e-15 -1.05725384e-09,0.445916468 -7.33736e-10,1.00108627 C-7.33736e-10,1.00108627 -3.44283713e-14,1.97634814 -3.44283713e-14,3 C-3.44283713e-14,12.3888407 7.61115925,20 17,20 C18.0236519,20 18.9989137,20 18.9989137,20 C19.5517984,20 20,19.5565264 20,18.9978536 L20,18.3488996 L20,14.9998075 C20,14.4476291 19.5490248,14 19.009222,14 L14.990778,14 C14.4435864,14 13.6861267,14.3138733 13.2940879,14.7059121 L11.1735916,16.8264084 Z" id="Combined-Shape"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Tél du client
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{ $visite->client->mobile}}
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                   <path d="M4.99999861,5.00218626 C4.99999861,2.23955507 7.24419318,0 9.99999722,0 C12.7614202,0 14.9999958,2.22898489 14.9999958,5.00218626 L14.9999958,6.99781374 C14.9999958,9.76044493 12.7558013,12 9.99999722,12 C7.23857424,12 4.99999861,9.77101511 4.99999861,6.99781374 L4.99999861,5.00218626 Z M1.11022272e-16,16.6756439 C2.94172855,14.9739441 6.3571245,14 9.99999722,14 C13.6428699,14 17.0582659,14.9739441 20,16.6756471 L19.9999944,20 L0,20 L1.11022272e-16,16.6756439 Z" id="Combined-Shape"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Accueillie par :
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{$visite->user->name}}
                  </p>
                </div>
              </div>
              <!-- Card -->

            </div>

            <!-- Cards with title -->
            <h4
              class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300"
            >
              Remarques :
            </h4>
            <div class="grid gap-6 mb-8 md:grid-cols-3">
              <div
                class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                  Remarques du commercial
                </h4>
                {{ $visite->detail}}
                </p>
              </div>
              <div
                class="min-w-0 p-4 text-black bg-blue-300 rounded-lg shadow-xs"
              >
                <h4 class="mb-4 font-semibold">
                  Remarques du client
                </h4>
                <p>
                  {{ $visite->remarqueClient}}
                </p>
              </div>              
            </div>
            <h4
              class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300"
            >
              Le prospect a connu le projet via :
            </h4>
              <div class="capitalize flex items-center flex items-center justify-between p-4 mb-8 text-sm font-semibold text-black bg-blue-200 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple">
                
                <span>
                  @if($visite->source == 'Autre')
                    {{$visite->autre}}
                  @else
                    {{$visite->source}}
                  @endif                 
                </span>
              </div>            
          </div>
        </main>
      </x-master>