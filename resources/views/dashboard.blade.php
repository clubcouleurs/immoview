<x-master>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            @can('voir finance')
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Finance 
            </h2>

            <!-- Cards -->
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-5">

            <!-- Card -->
            
              <div
                class="flex items-center p-4 bg-green-500 rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      fill-rule="evenodd"
                      d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-white dark:text-gray-400"
                  >
                    Avances encaissées
                  </p>
                  <p
                    class="text-lg font-semibold text-white dark:text-gray-200"
                  >
                    {{$paiementsV}} Dhs
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-red-500 rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-red-500 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      fill-rule="evenodd"
                      d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-white dark:text-gray-400"
                  >
                    Avances non-encaissées
                  </p>
                  <p
                    class="text-lg font-semibold text-white dark:text-gray-200"
                  >
                    {{$paiementsN}} Dhs
                  </p>
                </div>
              </div>              
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      fill-rule="evenodd"
                      d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Total avances
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{$paiements}} Dhs
                  </p>
                </div>
              </div>              
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      fill-rule="evenodd"
                      d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Total CA
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{$CA}} Dhs
                  </p>
                </div>
              </div> 
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      fill-rule="evenodd"
                      d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Total Reliquat
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{$reliquat}} Dhs
                  </p>
                </div>
              </div> 

            </div>
            @endcan


            @can('voir prospection')
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Prospection 
            </h2>
            <!-- Cards -->
            <div class="grid gap-6 mb-2 md:grid-cols-2 xl:grid-cols-6">
              <!-- Card -->
              @can('voir taux conversion')
              <div
                class="flex items-center p-4 bg-yellow-200 rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M2.92893219,17.0710678 C6.83417511,20.9763107 13.1658249,20.9763107 17.0710678,17.0710678 C20.9763107,13.1658249 20.9763107,6.83417511 17.0710678,2.92893219 C13.1658249,-0.976310729 6.83417511,-0.976310729 2.92893219,2.92893219 C-0.976310729,6.83417511 -0.976310729,13.1658249 2.92893219,17.0710678 Z M9,5 L11,5 L11,11 L9,11 L9,5 Z M9,13 L11,13 L11,15 L9,15 L9,13 Z" id="Combined-Shape"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Taux de conversion
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{$tauxConversion}}
                  </p>
                </div>
              </div>
              @endcan
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M2.92893219,17.0710678 C6.83417511,20.9763107 13.1658249,20.9763107 17.0710678,17.0710678 C20.9763107,13.1658249 20.9763107,6.83417511 17.0710678,2.92893219 C13.1658249,-0.976310729 6.83417511,-0.976310729 2.92893219,2.92893219 C-0.976310729,6.83417511 -0.976310729,13.1658249 2.92893219,17.0710678 Z M9,5 L11,5 L11,11 L9,11 L9,5 Z M9,13 L11,13 L11,15 L9,15 L9,13 Z" id="Combined-Shape"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Visites d'aujroud'hui
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{$visitesDay}}
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M2.92893219,17.0710678 C6.83417511,20.9763107 13.1658249,20.9763107 17.0710678,17.0710678 C20.9763107,13.1658249 20.9763107,6.83417511 17.0710678,2.92893219 C13.1658249,-0.976310729 6.83417511,-0.976310729 2.92893219,2.92893219 C-0.976310729,6.83417511 -0.976310729,13.1658249 2.92893219,17.0710678 Z M9,5 L11,5 L11,11 L9,11 L9,5 Z M9,13 L11,13 L11,15 L9,15 L9,13 Z" id="Combined-Shape"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Visites de cette semaine
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                  {{$visitesWeek}}
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-red-500 bg-red-100 rounded-full dark:text-blue-100 dark:bg-blue-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M2.92893219,17.0710678 C6.83417511,20.9763107 13.1658249,20.9763107 17.0710678,17.0710678 C20.9763107,13.1658249 20.9763107,6.83417511 17.0710678,2.92893219 C13.1658249,-0.976310729 6.83417511,-0.976310729 2.92893219,2.92893219 C-0.976310729,6.83417511 -0.976310729,13.1658249 2.92893219,17.0710678 Z M9,5 L11,5 L11,11 L9,11 L9,5 Z M9,13 L11,13 L11,15 L9,15 L9,13 Z" id="Combined-Shape"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Visites de ce mois
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{ $visitesMonth }}
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-green-700 bg-green-100 rounded-full dark:text-teal-100 dark:bg-teal-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M2.92893219,17.0710678 C6.83417511,20.9763107 13.1658249,20.9763107 17.0710678,17.0710678 C20.9763107,13.1658249 20.9763107,6.83417511 17.0710678,2.92893219 C13.1658249,-0.976310729 6.83417511,-0.976310729 2.92893219,2.92893219 C-0.976310729,6.83417511 -0.976310729,13.1658249 2.92893219,17.0710678 Z M9,5 L11,5 L11,11 L9,11 L9,5 Z M9,13 L11,13 L11,15 L9,15 L9,13 Z" id="Combined-Shape"></path>

                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Visites de cette année {{date_format(now(), 'Y')}}
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{ $visitesYear }}
                  </p>
                </div>
              </div>

              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-teal-500 rounded-full dark:text-teal-100 dark:bg-teal-500"
                >

                  <svg class="w-5 h-5" viewBox="0 0 20 20">

<path d="M8.02739671,2.33180314 C5.68271203,3.14769073 4,5.37733614 4,8 L4,14 L1,16 L1,17 L19,17 L19,16 L16,14 L16,8 C16,5.37733614 14.317288,3.14769073 11.9726033,2.33180314 C11.9906226,2.22388264 12,2.11303643 12,2 C12,0.8954305 11.1045695,0 10,0 C8.8954305,0 8,0.8954305 8,2 C8,2.11303643 8.0093774,2.22388264 8.02739671,2.33180314 L8.02739671,2.33180314 Z M12,18 C12,19.1045695 11.1045695,20 10,20 C8.8954305,20 8,19.1045695 8,18 L12,18 L12,18 Z" id="Combined-Shape"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Total de visites
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{count($totalVisites)}}
                  </p>
                </div>
              </div>              

            </div>
            @endcan
            <!--  fin prospection -->
            <!--  début relance -->
            @can('voir relance')
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Relance Clients 
            </h2>
            <!-- Cards -->
            <div class="grid gap-6 mb-2 md:grid-cols-2 xl:grid-cols-3">
              <!-- Card -->
              
              <div
                class="flex items-center p-4
                {{ ($dossiersToday > 0) ? 'bg-red-600' : 'bg-gray-300' }}
                rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-white
                  {{ ($dossiersToday > 0) ? 'bg-red-600' : 'bg-gray-200' }}
                  rounded-full dark:text-orange-100 dark:bg-orange-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M8.02739671,2.33180314 C5.68271203,3.14769073 4,5.37733614 4,8 L4,14 L1,16 L1,17 L19,17 L19,16 L16,14 L16,8 C16,5.37733614 14.317288,3.14769073 11.9726033,2.33180314 C11.9906226,2.22388264 12,2.11303643 12,2 C12,0.8954305 11.1045695,0 10,0 C8.8954305,0 8,0.8954305 8,2 C8,2.11303643 8.0093774,2.22388264 8.02739671,2.33180314 L8.02739671,2.33180314 Z M12,18 C12,19.1045695 11.1045695,20 10,20 C8.8954305,20 8,19.1045695 8,18 L12,18 L12,18 Z" id="Combined-Shape"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-white dark:text-gray-400"
                  >
                    Dossiers à relancer Aujourd'hui :
                  </p>
                  <p
                    class="text-lg font-semibold text-white dark:text-gray-200"
                  >
                  <a href="">
                   {{$dossiersToday}} Dossiers
                 </a>
                  </p>
                </div>
              </div>

              <!-- Card -->
              <!-- Card -->
              
              <div
                class="flex items-center p-4
                {{ ($dossiersTomorrow > 0) ? 'bg-yellow-600' : 'bg-gray-300' }}
                 rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-white
                {{ ($dossiersTomorrow > 0) ? 'bg-yellow-400' : 'bg-gray-200' }}

                  rounded-full dark:text-orange-100 dark:bg-orange-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M8.02739671,2.33180314 C5.68271203,3.14769073 4,5.37733614 4,8 L4,14 L1,16 L1,17 L19,17 L19,16 L16,14 L16,8 C16,5.37733614 14.317288,3.14769073 11.9726033,2.33180314 C11.9906226,2.22388264 12,2.11303643 12,2 C12,0.8954305 11.1045695,0 10,0 C8.8954305,0 8,0.8954305 8,2 C8,2.11303643 8.0093774,2.22388264 8.02739671,2.33180314 L8.02739671,2.33180314 Z M12,18 C12,19.1045695 11.1045695,20 10,20 C8.8954305,20 8,19.1045695 8,18 L12,18 L12,18 Z" id="Combined-Shape"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-white dark:text-gray-400"
                  >
                    Dossiers à relancer Demain :
                  </p>
                  <p
                    class="text-lg font-semibold text-white dark:text-gray-200"
                  >
                  <a href="">
                    {{$dossiersTomorrow}} Dossiers
                  </a>
                  </p>
                </div>
              </div>
                <!-- Card -->
              
              <div
                class="flex items-center p-4
                {{ ($dossiersAfterTomorrow > 0) ? 'bg-yellow-500' : 'bg-gray-300' }}

                rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-white
                {{ ($dossiersAfterTomorrow > 0) ? 'bg-yellow-400' : 'bg-gray-200' }}

                  rounded-full dark:text-orange-100 dark:bg-orange-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M2.92893219,17.0710678 C6.83417511,20.9763107 13.1658249,20.9763107 17.0710678,17.0710678 C20.9763107,13.1658249 20.9763107,6.83417511 17.0710678,2.92893219 C13.1658249,-0.976310729 6.83417511,-0.976310729 2.92893219,2.92893219 C-0.976310729,6.83417511 -0.976310729,13.1658249 2.92893219,17.0710678 Z M9,5 L11,5 L11,11 L9,11 L9,5 Z M9,13 L11,13 L11,15 L9,15 L9,13 Z" id="Combined-Shape"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-white dark:text-gray-400"
                  >
                    Dossiers à relancer Après-Demain
                  </p>
                  <p
                    class="text-lg font-semibold text-white dark:text-gray-200"
                  >
                  <a href="">
                    {{$dossiersAfterTomorrow}} Dossiers
                    </a>
                  </p>
                </div>
              </div>

            </div>
            @endcan

            <!-- fin relance -->
            @can('editer lots')
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-purple-200"
            >
              Lots 
            </h2>


            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-5">


              <!-- Card -->
              <div
                class="flex items-center p-4 bg-red-100 rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-red-500 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M16.803,18.615h-4.535c-1,0-1.814-0.812-1.814-1.812v-4.535c0-1.002,0.814-1.814,1.814-1.814h4.535c1.001,0,1.813,0.812,1.813,1.814v4.535C18.616,17.803,17.804,18.615,16.803,18.615zM17.71,12.268c0-0.502-0.405-0.906-0.907-0.906h-4.535c-0.501,0-0.906,0.404-0.906,0.906v4.535c0,0.502,0.405,0.906,0.906,0.906h4.535c0.502,0,0.907-0.404,0.907-0.906V12.268z M16.803,9.546h-4.535c-1,0-1.814-0.812-1.814-1.814V3.198c0-1.002,0.814-1.814,1.814-1.814h4.535c1.001,0,1.813,0.812,1.813,1.814v4.534C18.616,8.734,17.804,9.546,16.803,9.546zM17.71,3.198c0-0.501-0.405-0.907-0.907-0.907h-4.535c-0.501,0-0.906,0.406-0.906,0.907v4.534c0,0.501,0.405,0.908,0.906,0.908h4.535c0.502,0,0.907-0.406,0.907-0.908V3.198z M7.733,18.615H3.198c-1.002,0-1.814-0.812-1.814-1.812v-4.535c0-1.002,0.812-1.814,1.814-1.814h4.535c1.002,0,1.814,0.812,1.814,1.814v4.535C9.547,17.803,8.735,18.615,7.733,18.615zM8.64,12.268c0-0.502-0.406-0.906-0.907-0.906H3.198c-0.501,0-0.907,0.404-0.907,0.906v4.535c0,0.502,0.406,0.906,0.907,0.906h4.535c0.501,0,0.907-0.404,0.907-0.906V12.268z M7.733,9.546H3.198c-1.002,0-1.814-0.812-1.814-1.814V3.198c0-1.002,0.812-1.814,1.814-1.814h4.535c1.002,0,1.814,0.812,1.814,1.814v4.534C9.547,8.734,8.735,9.546,7.733,9.546z M8.64,3.198c0-0.501-0.406-0.907-0.907-0.907H3.198c-0.501,0-0.907,0.406-0.907,0.907v4.534c0,0.501,0.406,0.908,0.907,0.908h4.535c0.501,0,0.907-0.406,0.907-0.908V3.198z"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-red-600 dark:text-red-400"
                  >
                    Total Lots
                  </p>
                  <p
                    class="text-lg font-semibold text-red-700 dark:text-red-200"
                  >
                    @isset($lots){{$lots}}@else 0 @endisset

                  </p>
                </div>
              </div>
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-red-200 rounded-lg shadow-md dark:bg-red-800"
              >
                <div
                  class="p-3 mr-4 text-red-500 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M16.803,18.615h-4.535c-1,0-1.814-0.812-1.814-1.812v-4.535c0-1.002,0.814-1.814,1.814-1.814h4.535c1.001,0,1.813,0.812,1.813,1.814v4.535C18.616,17.803,17.804,18.615,16.803,18.615zM17.71,12.268c0-0.502-0.405-0.906-0.907-0.906h-4.535c-0.501,0-0.906,0.404-0.906,0.906v4.535c0,0.502,0.405,0.906,0.906,0.906h4.535c0.502,0,0.907-0.404,0.907-0.906V12.268z M16.803,9.546h-4.535c-1,0-1.814-0.812-1.814-1.814V3.198c0-1.002,0.814-1.814,1.814-1.814h4.535c1.001,0,1.813,0.812,1.813,1.814v4.534C18.616,8.734,17.804,9.546,16.803,9.546zM17.71,3.198c0-0.501-0.405-0.907-0.907-0.907h-4.535c-0.501,0-0.906,0.406-0.906,0.907v4.534c0,0.501,0.405,0.908,0.906,0.908h4.535c0.502,0,0.907-0.406,0.907-0.908V3.198z M7.733,18.615H3.198c-1.002,0-1.814-0.812-1.814-1.812v-4.535c0-1.002,0.812-1.814,1.814-1.814h4.535c1.002,0,1.814,0.812,1.814,1.814v4.535C9.547,17.803,8.735,18.615,7.733,18.615zM8.64,12.268c0-0.502-0.406-0.906-0.907-0.906H3.198c-0.501,0-0.907,0.404-0.907,0.906v4.535c0,0.502,0.406,0.906,0.907,0.906h4.535c0.501,0,0.907-0.404,0.907-0.906V12.268z M7.733,9.546H3.198c-1.002,0-1.814-0.812-1.814-1.814V3.198c0-1.002,0.812-1.814,1.814-1.814h4.535c1.002,0,1.814,0.812,1.814,1.814v4.534C9.547,8.734,8.735,9.546,7.733,9.546z M8.64,3.198c0-0.501-0.406-0.907-0.907-0.907H3.198c-0.501,0-0.907,0.406-0.907,0.907v4.534c0,0.501,0.406,0.908,0.907,0.908h4.535c0.501,0,0.907-0.406,0.907-0.908V3.198z"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-red-600 dark:text-red-400"
                  >
                    Lots vendus
                  </p>
                  <p
                    class="text-lg font-semibold text-red-700 dark:text-red-200"
                  >
                    @isset($reserved){{$reserved}}@else 0 @endisset

                  </p>
                </div>
              </div>              
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-red-300 rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-red-500 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M16.803,18.615h-4.535c-1,0-1.814-0.812-1.814-1.812v-4.535c0-1.002,0.814-1.814,1.814-1.814h4.535c1.001,0,1.813,0.812,1.813,1.814v4.535C18.616,17.803,17.804,18.615,16.803,18.615zM17.71,12.268c0-0.502-0.405-0.906-0.907-0.906h-4.535c-0.501,0-0.906,0.404-0.906,0.906v4.535c0,0.502,0.405,0.906,0.906,0.906h4.535c0.502,0,0.907-0.404,0.907-0.906V12.268z M16.803,9.546h-4.535c-1,0-1.814-0.812-1.814-1.814V3.198c0-1.002,0.814-1.814,1.814-1.814h4.535c1.001,0,1.813,0.812,1.813,1.814v4.534C18.616,8.734,17.804,9.546,16.803,9.546zM17.71,3.198c0-0.501-0.405-0.907-0.907-0.907h-4.535c-0.501,0-0.906,0.406-0.906,0.907v4.534c0,0.501,0.405,0.908,0.906,0.908h4.535c0.502,0,0.907-0.406,0.907-0.908V3.198z M7.733,18.615H3.198c-1.002,0-1.814-0.812-1.814-1.812v-4.535c0-1.002,0.812-1.814,1.814-1.814h4.535c1.002,0,1.814,0.812,1.814,1.814v4.535C9.547,17.803,8.735,18.615,7.733,18.615zM8.64,12.268c0-0.502-0.406-0.906-0.907-0.906H3.198c-0.501,0-0.907,0.404-0.907,0.906v4.535c0,0.502,0.406,0.906,0.907,0.906h4.535c0.501,0,0.907-0.404,0.907-0.906V12.268z M7.733,9.546H3.198c-1.002,0-1.814-0.812-1.814-1.814V3.198c0-1.002,0.812-1.814,1.814-1.814h4.535c1.002,0,1.814,0.812,1.814,1.814v4.534C9.547,8.734,8.735,9.546,7.733,9.546z M8.64,3.198c0-0.501-0.406-0.907-0.907-0.907H3.198c-0.501,0-0.907,0.406-0.907,0.907v4.534c0,0.501,0.406,0.908,0.907,0.908h4.535c0.501,0,0.907-0.406,0.907-0.908V3.198z"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-red-700 dark:text-red-400"
                  >
                    Lots bloqués
                  </p>
                  <p
                    class="text-lg font-semibold text-red-700 dark:text-red-200"
                  >
                    {{$blocked}}

                  </p>
                </div>
              </div>       
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-red-400 rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-red-500 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M16.803,18.615h-4.535c-1,0-1.814-0.812-1.814-1.812v-4.535c0-1.002,0.814-1.814,1.814-1.814h4.535c1.001,0,1.813,0.812,1.813,1.814v4.535C18.616,17.803,17.804,18.615,16.803,18.615zM17.71,12.268c0-0.502-0.405-0.906-0.907-0.906h-4.535c-0.501,0-0.906,0.404-0.906,0.906v4.535c0,0.502,0.405,0.906,0.906,0.906h4.535c0.502,0,0.907-0.404,0.907-0.906V12.268z M16.803,9.546h-4.535c-1,0-1.814-0.812-1.814-1.814V3.198c0-1.002,0.814-1.814,1.814-1.814h4.535c1.001,0,1.813,0.812,1.813,1.814v4.534C18.616,8.734,17.804,9.546,16.803,9.546zM17.71,3.198c0-0.501-0.405-0.907-0.907-0.907h-4.535c-0.501,0-0.906,0.406-0.906,0.907v4.534c0,0.501,0.405,0.908,0.906,0.908h4.535c0.502,0,0.907-0.406,0.907-0.908V3.198z M7.733,18.615H3.198c-1.002,0-1.814-0.812-1.814-1.812v-4.535c0-1.002,0.812-1.814,1.814-1.814h4.535c1.002,0,1.814,0.812,1.814,1.814v4.535C9.547,17.803,8.735,18.615,7.733,18.615zM8.64,12.268c0-0.502-0.406-0.906-0.907-0.906H3.198c-0.501,0-0.907,0.404-0.907,0.906v4.535c0,0.502,0.406,0.906,0.907,0.906h4.535c0.501,0,0.907-0.404,0.907-0.906V12.268z M7.733,9.546H3.198c-1.002,0-1.814-0.812-1.814-1.814V3.198c0-1.002,0.812-1.814,1.814-1.814h4.535c1.002,0,1.814,0.812,1.814,1.814v4.534C9.547,8.734,8.735,9.546,7.733,9.546z M8.64,3.198c0-0.501-0.406-0.907-0.907-0.907H3.198c-0.501,0-0.907,0.406-0.907,0.907v4.534c0,0.501,0.406,0.908,0.907,0.908h4.535c0.501,0,0.907-0.406,0.907-0.908V3.198z"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-white dark:text-red-400"
                  >
                    Lots réservés
                  </p>
                  <p
                    class="text-lg font-semibold text-white dark:text-red-200"
                  >
                    {{$promised}}

                  </p>
                </div>
              </div>  

              <!-- Card -->
              <div
                class="flex items-center p-4 bg-red-500 rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-red-500 bg-red-50 rounded-full dark:text-red-100 dark:bg-red-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M16.803,18.615h-4.535c-1,0-1.814-0.812-1.814-1.812v-4.535c0-1.002,0.814-1.814,1.814-1.814h4.535c1.001,0,1.813,0.812,1.813,1.814v4.535C18.616,17.803,17.804,18.615,16.803,18.615zM17.71,12.268c0-0.502-0.405-0.906-0.907-0.906h-4.535c-0.501,0-0.906,0.404-0.906,0.906v4.535c0,0.502,0.405,0.906,0.906,0.906h4.535c0.502,0,0.907-0.404,0.907-0.906V12.268z M16.803,9.546h-4.535c-1,0-1.814-0.812-1.814-1.814V3.198c0-1.002,0.814-1.814,1.814-1.814h4.535c1.001,0,1.813,0.812,1.813,1.814v4.534C18.616,8.734,17.804,9.546,16.803,9.546zM17.71,3.198c0-0.501-0.405-0.907-0.907-0.907h-4.535c-0.501,0-0.906,0.406-0.906,0.907v4.534c0,0.501,0.405,0.908,0.906,0.908h4.535c0.502,0,0.907-0.406,0.907-0.908V3.198z M7.733,18.615H3.198c-1.002,0-1.814-0.812-1.814-1.812v-4.535c0-1.002,0.812-1.814,1.814-1.814h4.535c1.002,0,1.814,0.812,1.814,1.814v4.535C9.547,17.803,8.735,18.615,7.733,18.615zM8.64,12.268c0-0.502-0.406-0.906-0.907-0.906H3.198c-0.501,0-0.907,0.404-0.907,0.906v4.535c0,0.502,0.406,0.906,0.907,0.906h4.535c0.501,0,0.907-0.404,0.907-0.906V12.268z M7.733,9.546H3.198c-1.002,0-1.814-0.812-1.814-1.814V3.198c0-1.002,0.812-1.814,1.814-1.814h4.535c1.002,0,1.814,0.812,1.814,1.814v4.534C9.547,8.734,8.735,9.546,7.733,9.546z M8.64,3.198c0-0.501-0.406-0.907-0.907-0.907H3.198c-0.501,0-0.907,0.406-0.907,0.907v4.534c0,0.501,0.406,0.908,0.907,0.908h4.535c0.501,0,0.907-0.406,0.907-0.908V3.198z"></path>
                  </svg>  
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-white dark:text-gray-400"
                  >
                    Lots en stock
                  </p>
                  <p
                    class="text-lg font-semibold text-white dark:text-gray-200"
                  >
                    {{$stocked}}

                  </p>
                </div>
              </div> 


              </div>
              @endcan


            @can('editer appartements')
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Appartements 
            </h2>


            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-5">


              <!-- Card -->
              <div
                class="flex items-center p-4 bg-purple-100 rounded-lg shadow-md dark:bg-purple-800"
              >
                <div
                  class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full dark:text-purple-100 dark:bg-purple-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M16.382,15.015h0.455h0.457V4.985h-0.457h-0.455V15.015z M16.837,4.985c1.008,0,1.824-0.816,1.824-1.822c0-1.008-0.816-1.824-1.824-1.824c-1.006,0-1.822,0.816-1.822,1.824C15.015,4.169,15.831,4.985,16.837,4.985z M16.837,2.25c0.504,0,0.913,0.409,0.913,0.913c0,0.502-0.409,0.911-0.913,0.911c-0.502,0-0.911-0.409-0.911-0.911C15.926,2.659,16.335,2.25,16.837,2.25z M15.015,3.618V3.163V2.706H4.986v0.457v0.455H15.015z M3.162,15.01c-1.007,0-1.823,0.816-1.823,1.822c0,1.008,0.816,1.824,1.823,1.824s1.824-0.816,1.824-1.824C4.986,15.831,4.169,15.015,3.162,15.015z M3.162,17.75c-0.503,0-0.911-0.409-0.911-0.913c0-0.502,0.408-0.911,0.911-0.911c0.504,0,0.912,0.409,0.912,0.911C4.074,17.341,3.666,17.75,3.162,17.75z M4.986,16.382v0.455v0.457h10.029v-0.457v-0.455H4.986zM16.837,15.015c-1.006,0-1.822,0.816-1.822,1.822c0,1.008,0.816,1.824,1.822,1.824c1.008,0,1.824-0.816,1.824-1.824C18.661,15.831,17.845,15.015,16.837,15.015z M16.837,17.75c-0.502,0-0.911-0.409-0.911-0.913c0-0.502,0.409-0.911,0.911-0.911c0.504,0,0.913,0.409,0.913,0.911C17.75,17.341,17.341,17.75,16.837,17.75z M3.618,4.985H3.162H2.707v10.029h0.456h0.456V4.985zM4.986,3.163c0-1.008-0.817-1.824-1.824-1.824S1.339,2.155,1.339,3.163c0,1.006,0.816,1.822,1.823,1.822S4.986,4.169,4.986,3.163zM3.162,4.074c-0.503,0-0.911-0.409-0.911-0.911c0-0.504,0.408-0.913,0.911-0.913c0.504,0,0.912,0.409,0.912,0.913C4.074,3.665,3.666,4.074,3.162,4.074z"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-purple-600 dark:text-purple-400"
                  >
                    Total Appartements
                  </p>
                  <p
                    class="text-lg font-semibold text-purple-700 dark:text-purple-200"
                  >
                    @isset($appartements){{$appartements}}@else 0 @endisset

                  </p>
                </div>
              </div>
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-purple-200 rounded-lg shadow-md dark:bg-purple-800"
              >
                <div
                  class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full dark:text-purple-100 dark:bg-purple-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M16.382,15.015h0.455h0.457V4.985h-0.457h-0.455V15.015z M16.837,4.985c1.008,0,1.824-0.816,1.824-1.822c0-1.008-0.816-1.824-1.824-1.824c-1.006,0-1.822,0.816-1.822,1.824C15.015,4.169,15.831,4.985,16.837,4.985z M16.837,2.25c0.504,0,0.913,0.409,0.913,0.913c0,0.502-0.409,0.911-0.913,0.911c-0.502,0-0.911-0.409-0.911-0.911C15.926,2.659,16.335,2.25,16.837,2.25z M15.015,3.618V3.163V2.706H4.986v0.457v0.455H15.015z M3.162,15.01c-1.007,0-1.823,0.816-1.823,1.822c0,1.008,0.816,1.824,1.823,1.824s1.824-0.816,1.824-1.824C4.986,15.831,4.169,15.015,3.162,15.015z M3.162,17.75c-0.503,0-0.911-0.409-0.911-0.913c0-0.502,0.408-0.911,0.911-0.911c0.504,0,0.912,0.409,0.912,0.911C4.074,17.341,3.666,17.75,3.162,17.75z M4.986,16.382v0.455v0.457h10.029v-0.457v-0.455H4.986zM16.837,15.015c-1.006,0-1.822,0.816-1.822,1.822c0,1.008,0.816,1.824,1.822,1.824c1.008,0,1.824-0.816,1.824-1.824C18.661,15.831,17.845,15.015,16.837,15.015z M16.837,17.75c-0.502,0-0.911-0.409-0.911-0.913c0-0.502,0.409-0.911,0.911-0.911c0.504,0,0.913,0.409,0.913,0.911C17.75,17.341,17.341,17.75,16.837,17.75z M3.618,4.985H3.162H2.707v10.029h0.456h0.456V4.985zM4.986,3.163c0-1.008-0.817-1.824-1.824-1.824S1.339,2.155,1.339,3.163c0,1.006,0.816,1.822,1.823,1.822S4.986,4.169,4.986,3.163zM3.162,4.074c-0.503,0-0.911-0.409-0.911-0.911c0-0.504,0.408-0.913,0.911-0.913c0.504,0,0.912,0.409,0.912,0.913C4.074,3.665,3.666,4.074,3.162,4.074z"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-purple-600 dark:text-purple-400"
                  >
                    Appartements vendus
                  </p>
                  <p
                    class="text-lg font-semibold text-purple-700 dark:text-purple-200"
                  >
                    @isset($appartement){{$appartement}}@else 0 @endisset

                  </p>
                </div>
              </div>              
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-purple-300 rounded-lg shadow-md dark:bg-purple-800"
              >
                <div
                  class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full dark:text-purple-100 dark:bg-purple-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M16.382,15.015h0.455h0.457V4.985h-0.457h-0.455V15.015z M16.837,4.985c1.008,0,1.824-0.816,1.824-1.822c0-1.008-0.816-1.824-1.824-1.824c-1.006,0-1.822,0.816-1.822,1.824C15.015,4.169,15.831,4.985,16.837,4.985z M16.837,2.25c0.504,0,0.913,0.409,0.913,0.913c0,0.502-0.409,0.911-0.913,0.911c-0.502,0-0.911-0.409-0.911-0.911C15.926,2.659,16.335,2.25,16.837,2.25z M15.015,3.618V3.163V2.706H4.986v0.457v0.455H15.015z M3.162,15.01c-1.007,0-1.823,0.816-1.823,1.822c0,1.008,0.816,1.824,1.823,1.824s1.824-0.816,1.824-1.824C4.986,15.831,4.169,15.015,3.162,15.015z M3.162,17.75c-0.503,0-0.911-0.409-0.911-0.913c0-0.502,0.408-0.911,0.911-0.911c0.504,0,0.912,0.409,0.912,0.911C4.074,17.341,3.666,17.75,3.162,17.75z M4.986,16.382v0.455v0.457h10.029v-0.457v-0.455H4.986zM16.837,15.015c-1.006,0-1.822,0.816-1.822,1.822c0,1.008,0.816,1.824,1.822,1.824c1.008,0,1.824-0.816,1.824-1.824C18.661,15.831,17.845,15.015,16.837,15.015z M16.837,17.75c-0.502,0-0.911-0.409-0.911-0.913c0-0.502,0.409-0.911,0.911-0.911c0.504,0,0.913,0.409,0.913,0.911C17.75,17.341,17.341,17.75,16.837,17.75z M3.618,4.985H3.162H2.707v10.029h0.456h0.456V4.985zM4.986,3.163c0-1.008-0.817-1.824-1.824-1.824S1.339,2.155,1.339,3.163c0,1.006,0.816,1.822,1.823,1.822S4.986,4.169,4.986,3.163zM3.162,4.074c-0.503,0-0.911-0.409-0.911-0.911c0-0.504,0.408-0.913,0.911-0.913c0.504,0,0.912,0.409,0.912,0.913C4.074,3.665,3.666,4.074,3.162,4.074z"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-purple-700 dark:text-purple-400"
                  >
                    Appartements bloqués
                  </p>
                  <p
                    class="text-lg font-semibold text-purple-700 dark:text-purple-200"
                  >
                    {{$appartementsBlocked}}

                  </p>
                </div>
              </div>       

              <!-- Card -->
              <div
                class="flex items-center p-4 bg-purple-400 rounded-lg shadow-md dark:bg-purple-800"
              >
                <div
                  class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full dark:text-purple-100 dark:bg-purple-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M16.382,15.015h0.455h0.457V4.985h-0.457h-0.455V15.015z M16.837,4.985c1.008,0,1.824-0.816,1.824-1.822c0-1.008-0.816-1.824-1.824-1.824c-1.006,0-1.822,0.816-1.822,1.824C15.015,4.169,15.831,4.985,16.837,4.985z M16.837,2.25c0.504,0,0.913,0.409,0.913,0.913c0,0.502-0.409,0.911-0.913,0.911c-0.502,0-0.911-0.409-0.911-0.911C15.926,2.659,16.335,2.25,16.837,2.25z M15.015,3.618V3.163V2.706H4.986v0.457v0.455H15.015z M3.162,15.01c-1.007,0-1.823,0.816-1.823,1.822c0,1.008,0.816,1.824,1.823,1.824s1.824-0.816,1.824-1.824C4.986,15.831,4.169,15.015,3.162,15.015z M3.162,17.75c-0.503,0-0.911-0.409-0.911-0.913c0-0.502,0.408-0.911,0.911-0.911c0.504,0,0.912,0.409,0.912,0.911C4.074,17.341,3.666,17.75,3.162,17.75z M4.986,16.382v0.455v0.457h10.029v-0.457v-0.455H4.986zM16.837,15.015c-1.006,0-1.822,0.816-1.822,1.822c0,1.008,0.816,1.824,1.822,1.824c1.008,0,1.824-0.816,1.824-1.824C18.661,15.831,17.845,15.015,16.837,15.015z M16.837,17.75c-0.502,0-0.911-0.409-0.911-0.913c0-0.502,0.409-0.911,0.911-0.911c0.504,0,0.913,0.409,0.913,0.911C17.75,17.341,17.341,17.75,16.837,17.75z M3.618,4.985H3.162H2.707v10.029h0.456h0.456V4.985zM4.986,3.163c0-1.008-0.817-1.824-1.824-1.824S1.339,2.155,1.339,3.163c0,1.006,0.816,1.822,1.823,1.822S4.986,4.169,4.986,3.163zM3.162,4.074c-0.503,0-0.911-0.409-0.911-0.911c0-0.504,0.408-0.913,0.911-0.913c0.504,0,0.912,0.409,0.912,0.913C4.074,3.665,3.666,4.074,3.162,4.074z"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-purple-700 dark:text-purple-400"
                  >
                    Appartements réservés
                  </p>
                  <p
                    class="text-lg font-semibold text-purple-700 dark:text-purple-200"
                  >
                    {{$appartementsPromised}}

                  </p>
                </div>
              </div>   
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-purple-400 rounded-lg shadow-md dark:bg-purple-800"
              >
                <div
                  class="p-3 mr-4 text-purple-500 bg-purple-50 rounded-full dark:text-purple-100 dark:bg-purple-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M16.382,15.015h0.455h0.457V4.985h-0.457h-0.455V15.015z M16.837,4.985c1.008,0,1.824-0.816,1.824-1.822c0-1.008-0.816-1.824-1.824-1.824c-1.006,0-1.822,0.816-1.822,1.824C15.015,4.169,15.831,4.985,16.837,4.985z M16.837,2.25c0.504,0,0.913,0.409,0.913,0.913c0,0.502-0.409,0.911-0.913,0.911c-0.502,0-0.911-0.409-0.911-0.911C15.926,2.659,16.335,2.25,16.837,2.25z M15.015,3.618V3.163V2.706H4.986v0.457v0.455H15.015z M3.162,15.01c-1.007,0-1.823,0.816-1.823,1.822c0,1.008,0.816,1.824,1.823,1.824s1.824-0.816,1.824-1.824C4.986,15.831,4.169,15.015,3.162,15.015z M3.162,17.75c-0.503,0-0.911-0.409-0.911-0.913c0-0.502,0.408-0.911,0.911-0.911c0.504,0,0.912,0.409,0.912,0.911C4.074,17.341,3.666,17.75,3.162,17.75z M4.986,16.382v0.455v0.457h10.029v-0.457v-0.455H4.986zM16.837,15.015c-1.006,0-1.822,0.816-1.822,1.822c0,1.008,0.816,1.824,1.822,1.824c1.008,0,1.824-0.816,1.824-1.824C18.661,15.831,17.845,15.015,16.837,15.015z M16.837,17.75c-0.502,0-0.911-0.409-0.911-0.913c0-0.502,0.409-0.911,0.911-0.911c0.504,0,0.913,0.409,0.913,0.911C17.75,17.341,17.341,17.75,16.837,17.75z M3.618,4.985H3.162H2.707v10.029h0.456h0.456V4.985zM4.986,3.163c0-1.008-0.817-1.824-1.824-1.824S1.339,2.155,1.339,3.163c0,1.006,0.816,1.822,1.823,1.822S4.986,4.169,4.986,3.163zM3.162,4.074c-0.503,0-0.911-0.409-0.911-0.911c0-0.504,0.408-0.913,0.911-0.913c0.504,0,0.912,0.409,0.912,0.913C4.074,3.665,3.666,4.074,3.162,4.074z"></path>
                  </svg>  
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-white dark:text-purple-400"
                  >
                    Appartements en stock
                  </p>
                  <p
                    class="text-lg font-semibold text-white dark:text-purple-200"
                  >
                    {{$appartementsStocked}}

                  </p>
                </div>
              </div> 
              <!-- Card -->
              
              </div>
              @endcan

        @can('editer magasins')
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Magasins 
            </h2>


            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-5">


              <!-- Card -->
              <div
                class="flex items-center p-4 bg-blue-100 rounded-lg shadow-md dark:bg-blue-800"
              >
                <div
                  class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M17.283,5.549h-5.26V4.335c0-0.222-0.183-0.404-0.404-0.404H8.381c-0.222,0-0.404,0.182-0.404,0.404v1.214h-5.26c-0.223,0-0.405,0.182-0.405,0.405v9.71c0,0.223,0.182,0.405,0.405,0.405h14.566c0.223,0,0.404-0.183,0.404-0.405v-9.71C17.688,5.731,17.506,5.549,17.283,5.549 M8.786,4.74h2.428v0.809H8.786V4.74z M16.879,15.26H3.122v-4.046h5.665v1.201c0,0.223,0.182,0.404,0.405,0.404h1.618c0.222,0,0.405-0.182,0.405-0.404v-1.201h5.665V15.26z M9.595,9.583h0.81v2.428h-0.81V9.583zM16.879,10.405h-5.665V9.19c0-0.222-0.183-0.405-0.405-0.405H9.191c-0.223,0-0.405,0.183-0.405,0.405v1.215H3.122V6.358h13.757V10.405z"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-blue-600 dark:text-blue-400"
                  >
                    Total Magasins
                  </p>
                  <p
                    class="text-lg font-semibold text-blue-700 dark:text-blue-200"
                  >
                    @isset($magasins){{$magasins}}@else 0 @endisset

                  </p>
                </div>
              </div>
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-blue-200 rounded-lg shadow-md dark:bg-blue-800"
              >
                <div
                  class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M17.283,5.549h-5.26V4.335c0-0.222-0.183-0.404-0.404-0.404H8.381c-0.222,0-0.404,0.182-0.404,0.404v1.214h-5.26c-0.223,0-0.405,0.182-0.405,0.405v9.71c0,0.223,0.182,0.405,0.405,0.405h14.566c0.223,0,0.404-0.183,0.404-0.405v-9.71C17.688,5.731,17.506,5.549,17.283,5.549 M8.786,4.74h2.428v0.809H8.786V4.74z M16.879,15.26H3.122v-4.046h5.665v1.201c0,0.223,0.182,0.404,0.405,0.404h1.618c0.222,0,0.405-0.182,0.405-0.404v-1.201h5.665V15.26z M9.595,9.583h0.81v2.428h-0.81V9.583zM16.879,10.405h-5.665V9.19c0-0.222-0.183-0.405-0.405-0.405H9.191c-0.223,0-0.405,0.183-0.405,0.405v1.215H3.122V6.358h13.757V10.405z"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-blue-600 dark:text-blue-400"
                  >
                    Magasins vendus
                  </p>
                  <p
                    class="text-lg font-semibold text-blue-700 dark:text-blue-200"
                  >
                    @isset($magasin){{$magasin}}@else 0 @endisset

                  </p>
                </div>
              </div>              
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-blue-300 rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M17.283,5.549h-5.26V4.335c0-0.222-0.183-0.404-0.404-0.404H8.381c-0.222,0-0.404,0.182-0.404,0.404v1.214h-5.26c-0.223,0-0.405,0.182-0.405,0.405v9.71c0,0.223,0.182,0.405,0.405,0.405h14.566c0.223,0,0.404-0.183,0.404-0.405v-9.71C17.688,5.731,17.506,5.549,17.283,5.549 M8.786,4.74h2.428v0.809H8.786V4.74z M16.879,15.26H3.122v-4.046h5.665v1.201c0,0.223,0.182,0.404,0.405,0.404h1.618c0.222,0,0.405-0.182,0.405-0.404v-1.201h5.665V15.26z M9.595,9.583h0.81v2.428h-0.81V9.583zM16.879,10.405h-5.665V9.19c0-0.222-0.183-0.405-0.405-0.405H9.191c-0.223,0-0.405,0.183-0.405,0.405v1.215H3.122V6.358h13.757V10.405z"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-blue-700 dark:text-gray-400"
                  >
                    Magasins bloqués
                  </p>
                  <p
                    class="text-lg font-semibold text-blue-700 dark:text-gray-200"
                  >
                    {{$magasinsBlocked}}

                  </p>
                </div>
              </div>       
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-blue-400 rounded-lg shadow-md dark:bg-purple-800"
              >
                <div
                  class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full dark:text-purple-100 dark:bg-purple-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M16.382,15.015h0.455h0.457V4.985h-0.457h-0.455V15.015z M16.837,4.985c1.008,0,1.824-0.816,1.824-1.822c0-1.008-0.816-1.824-1.824-1.824c-1.006,0-1.822,0.816-1.822,1.824C15.015,4.169,15.831,4.985,16.837,4.985z M16.837,2.25c0.504,0,0.913,0.409,0.913,0.913c0,0.502-0.409,0.911-0.913,0.911c-0.502,0-0.911-0.409-0.911-0.911C15.926,2.659,16.335,2.25,16.837,2.25z M15.015,3.618V3.163V2.706H4.986v0.457v0.455H15.015z M3.162,15.01c-1.007,0-1.823,0.816-1.823,1.822c0,1.008,0.816,1.824,1.823,1.824s1.824-0.816,1.824-1.824C4.986,15.831,4.169,15.015,3.162,15.015z M3.162,17.75c-0.503,0-0.911-0.409-0.911-0.913c0-0.502,0.408-0.911,0.911-0.911c0.504,0,0.912,0.409,0.912,0.911C4.074,17.341,3.666,17.75,3.162,17.75z M4.986,16.382v0.455v0.457h10.029v-0.457v-0.455H4.986zM16.837,15.015c-1.006,0-1.822,0.816-1.822,1.822c0,1.008,0.816,1.824,1.822,1.824c1.008,0,1.824-0.816,1.824-1.824C18.661,15.831,17.845,15.015,16.837,15.015z M16.837,17.75c-0.502,0-0.911-0.409-0.911-0.913c0-0.502,0.409-0.911,0.911-0.911c0.504,0,0.913,0.409,0.913,0.911C17.75,17.341,17.341,17.75,16.837,17.75z M3.618,4.985H3.162H2.707v10.029h0.456h0.456V4.985zM4.986,3.163c0-1.008-0.817-1.824-1.824-1.824S1.339,2.155,1.339,3.163c0,1.006,0.816,1.822,1.823,1.822S4.986,4.169,4.986,3.163zM3.162,4.074c-0.503,0-0.911-0.409-0.911-0.911c0-0.504,0.408-0.913,0.911-0.913c0.504,0,0.912,0.409,0.912,0.913C4.074,3.665,3.666,4.074,3.162,4.074z"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-purple-700 dark:text-purple-400"
                  >
                    Magasins réservés
                  </p>
                  <p
                    class="text-lg font-semibold text-purple-700 dark:text-purple-200"
                  >
                    {{$magasinsPromised}}

                  </p>
                </div>
              </div> 

              <!-- Card -->
              <div
                class="flex items-center p-4 bg-blue-400 rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-blue-500 bg-blue-50 rounded-full dark:text-blue-100 dark:bg-blue-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M17.283,5.549h-5.26V4.335c0-0.222-0.183-0.404-0.404-0.404H8.381c-0.222,0-0.404,0.182-0.404,0.404v1.214h-5.26c-0.223,0-0.405,0.182-0.405,0.405v9.71c0,0.223,0.182,0.405,0.405,0.405h14.566c0.223,0,0.404-0.183,0.404-0.405v-9.71C17.688,5.731,17.506,5.549,17.283,5.549 M8.786,4.74h2.428v0.809H8.786V4.74z M16.879,15.26H3.122v-4.046h5.665v1.201c0,0.223,0.182,0.404,0.405,0.404h1.618c0.222,0,0.405-0.182,0.405-0.404v-1.201h5.665V15.26z M9.595,9.583h0.81v2.428h-0.81V9.583zM16.879,10.405h-5.665V9.19c0-0.222-0.183-0.405-0.405-0.405H9.191c-0.223,0-0.405,0.183-0.405,0.405v1.215H3.122V6.358h13.757V10.405z"></path>
                  </svg>  
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-white dark:text-gray-400"
                  >
                    Magasins en stock
                  </p>
                  <p
                    class="text-lg font-semibold text-white dark:text-gray-200"
                  >
                    {{$magasinsStocked}}

                  </p>
                </div>
              </div> 
              <!-- Card -->
              </div>
              @endcan

        @can('editer bureaux')
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Bureaux 
            </h2>


            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-5">


              <!-- Card -->
              <div
                class="flex items-center p-4 bg-green-100 rounded-lg shadow-md dark:bg-green-800"
              >
                <div
                  class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M17.638,6.181h-3.844C13.581,4.273,11.963,2.786,10,2.786c-1.962,0-3.581,1.487-3.793,3.395H2.362c-0.233,0-0.424,0.191-0.424,0.424v10.184c0,0.232,0.191,0.424,0.424,0.424h15.276c0.234,0,0.425-0.191,0.425-0.424V6.605C18.062,6.372,17.872,6.181,17.638,6.181 M13.395,9.151c0.234,0,0.425,0.191,0.425,0.424S13.629,10,13.395,10c-0.232,0-0.424-0.191-0.424-0.424S13.162,9.151,13.395,9.151 M10,3.635c1.493,0,2.729,1.109,2.936,2.546H7.064C7.271,4.744,8.506,3.635,10,3.635 M6.605,9.151c0.233,0,0.424,0.191,0.424,0.424S6.838,10,6.605,10c-0.233,0-0.424-0.191-0.424-0.424S6.372,9.151,6.605,9.151 M17.214,16.365H2.786V7.029h3.395v1.347C5.687,8.552,5.332,9.021,5.332,9.575c0,0.703,0.571,1.273,1.273,1.273c0.702,0,1.273-0.57,1.273-1.273c0-0.554-0.354-1.023-0.849-1.199V7.029h5.941v1.347c-0.495,0.176-0.849,0.645-0.849,1.199c0,0.703,0.57,1.273,1.272,1.273s1.273-0.57,1.273-1.273c0-0.554-0.354-1.023-0.849-1.199V7.029h3.395V16.365z"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-green-600 dark:text-green-400"
                  >
                    Total Bureaux
                  </p>
                  <p
                    class="text-lg font-semibold text-green-700 dark:text-green-200"
                  >
                    @isset($bureaus){{$bureaus}}@else 0 @endisset

                  </p>
                </div>
              </div>
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-green-200 rounded-lg shadow-md dark:bg-green-800"
              >
                <div
                  class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M17.638,6.181h-3.844C13.581,4.273,11.963,2.786,10,2.786c-1.962,0-3.581,1.487-3.793,3.395H2.362c-0.233,0-0.424,0.191-0.424,0.424v10.184c0,0.232,0.191,0.424,0.424,0.424h15.276c0.234,0,0.425-0.191,0.425-0.424V6.605C18.062,6.372,17.872,6.181,17.638,6.181 M13.395,9.151c0.234,0,0.425,0.191,0.425,0.424S13.629,10,13.395,10c-0.232,0-0.424-0.191-0.424-0.424S13.162,9.151,13.395,9.151 M10,3.635c1.493,0,2.729,1.109,2.936,2.546H7.064C7.271,4.744,8.506,3.635,10,3.635 M6.605,9.151c0.233,0,0.424,0.191,0.424,0.424S6.838,10,6.605,10c-0.233,0-0.424-0.191-0.424-0.424S6.372,9.151,6.605,9.151 M17.214,16.365H2.786V7.029h3.395v1.347C5.687,8.552,5.332,9.021,5.332,9.575c0,0.703,0.571,1.273,1.273,1.273c0.702,0,1.273-0.57,1.273-1.273c0-0.554-0.354-1.023-0.849-1.199V7.029h5.941v1.347c-0.495,0.176-0.849,0.645-0.849,1.199c0,0.703,0.57,1.273,1.272,1.273s1.273-0.57,1.273-1.273c0-0.554-0.354-1.023-0.849-1.199V7.029h3.395V16.365z"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-green-600 dark:text-green-400"
                  >
                    Bureaux vendus
                  </p>
                  <p
                    class="text-lg font-semibold text-green-700 dark:text-green-200"
                  >
                    @isset($bureau){{$bureau}}@else 0 @endisset

                  </p>
                </div>
              </div>              
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-green-300 rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M17.638,6.181h-3.844C13.581,4.273,11.963,2.786,10,2.786c-1.962,0-3.581,1.487-3.793,3.395H2.362c-0.233,0-0.424,0.191-0.424,0.424v10.184c0,0.232,0.191,0.424,0.424,0.424h15.276c0.234,0,0.425-0.191,0.425-0.424V6.605C18.062,6.372,17.872,6.181,17.638,6.181 M13.395,9.151c0.234,0,0.425,0.191,0.425,0.424S13.629,10,13.395,10c-0.232,0-0.424-0.191-0.424-0.424S13.162,9.151,13.395,9.151 M10,3.635c1.493,0,2.729,1.109,2.936,2.546H7.064C7.271,4.744,8.506,3.635,10,3.635 M6.605,9.151c0.233,0,0.424,0.191,0.424,0.424S6.838,10,6.605,10c-0.233,0-0.424-0.191-0.424-0.424S6.372,9.151,6.605,9.151 M17.214,16.365H2.786V7.029h3.395v1.347C5.687,8.552,5.332,9.021,5.332,9.575c0,0.703,0.571,1.273,1.273,1.273c0.702,0,1.273-0.57,1.273-1.273c0-0.554-0.354-1.023-0.849-1.199V7.029h5.941v1.347c-0.495,0.176-0.849,0.645-0.849,1.199c0,0.703,0.57,1.273,1.272,1.273s1.273-0.57,1.273-1.273c0-0.554-0.354-1.023-0.849-1.199V7.029h3.395V16.365z"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-green-700 dark:text-green-400"
                  >
                    Bureaux bloqués
                  </p>
                  <p
                    class="text-lg font-semibold text-green-700 dark:text-green-200"
                  >
                    {{$bureauxBlocked}}

                  </p>
                </div>
              </div>       
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-green-400 rounded-lg shadow-md dark:bg-green-800"
              >
                <div
                  class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M16.382,15.015h0.455h0.457V4.985h-0.457h-0.455V15.015z M16.837,4.985c1.008,0,1.824-0.816,1.824-1.822c0-1.008-0.816-1.824-1.824-1.824c-1.006,0-1.822,0.816-1.822,1.824C15.015,4.169,15.831,4.985,16.837,4.985z M16.837,2.25c0.504,0,0.913,0.409,0.913,0.913c0,0.502-0.409,0.911-0.913,0.911c-0.502,0-0.911-0.409-0.911-0.911C15.926,2.659,16.335,2.25,16.837,2.25z M15.015,3.618V3.163V2.706H4.986v0.457v0.455H15.015z M3.162,15.01c-1.007,0-1.823,0.816-1.823,1.822c0,1.008,0.816,1.824,1.823,1.824s1.824-0.816,1.824-1.824C4.986,15.831,4.169,15.015,3.162,15.015z M3.162,17.75c-0.503,0-0.911-0.409-0.911-0.913c0-0.502,0.408-0.911,0.911-0.911c0.504,0,0.912,0.409,0.912,0.911C4.074,17.341,3.666,17.75,3.162,17.75z M4.986,16.382v0.455v0.457h10.029v-0.457v-0.455H4.986zM16.837,15.015c-1.006,0-1.822,0.816-1.822,1.822c0,1.008,0.816,1.824,1.822,1.824c1.008,0,1.824-0.816,1.824-1.824C18.661,15.831,17.845,15.015,16.837,15.015z M16.837,17.75c-0.502,0-0.911-0.409-0.911-0.913c0-0.502,0.409-0.911,0.911-0.911c0.504,0,0.913,0.409,0.913,0.911C17.75,17.341,17.341,17.75,16.837,17.75z M3.618,4.985H3.162H2.707v10.029h0.456h0.456V4.985zM4.986,3.163c0-1.008-0.817-1.824-1.824-1.824S1.339,2.155,1.339,3.163c0,1.006,0.816,1.822,1.823,1.822S4.986,4.169,4.986,3.163zM3.162,4.074c-0.503,0-0.911-0.409-0.911-0.911c0-0.504,0.408-0.913,0.911-0.913c0.504,0,0.912,0.409,0.912,0.913C4.074,3.665,3.666,4.074,3.162,4.074z"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-green-700 dark:text-green-400"
                  >
                    Bureaux réservés
                  </p>
                  <p
                    class="text-lg font-semibold text-green-700 dark:text-green-200"
                  >
                    {{$bureauxPromised}}

                  </p>
                </div>
              </div> 

              <!-- Card -->
              <div
                class="flex items-center p-4 bg-green-400 rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-green-500 bg-green-50 rounded-full dark:text-green-100 dark:bg-green-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M17.638,6.181h-3.844C13.581,4.273,11.963,2.786,10,2.786c-1.962,0-3.581,1.487-3.793,3.395H2.362c-0.233,0-0.424,0.191-0.424,0.424v10.184c0,0.232,0.191,0.424,0.424,0.424h15.276c0.234,0,0.425-0.191,0.425-0.424V6.605C18.062,6.372,17.872,6.181,17.638,6.181 M13.395,9.151c0.234,0,0.425,0.191,0.425,0.424S13.629,10,13.395,10c-0.232,0-0.424-0.191-0.424-0.424S13.162,9.151,13.395,9.151 M10,3.635c1.493,0,2.729,1.109,2.936,2.546H7.064C7.271,4.744,8.506,3.635,10,3.635 M6.605,9.151c0.233,0,0.424,0.191,0.424,0.424S6.838,10,6.605,10c-0.233,0-0.424-0.191-0.424-0.424S6.372,9.151,6.605,9.151 M17.214,16.365H2.786V7.029h3.395v1.347C5.687,8.552,5.332,9.021,5.332,9.575c0,0.703,0.571,1.273,1.273,1.273c0.702,0,1.273-0.57,1.273-1.273c0-0.554-0.354-1.023-0.849-1.199V7.029h5.941v1.347c-0.495,0.176-0.849,0.645-0.849,1.199c0,0.703,0.57,1.273,1.272,1.273s1.273-0.57,1.273-1.273c0-0.554-0.354-1.023-0.849-1.199V7.029h3.395V16.365z"></path>
                  </svg>  
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-white dark:text-gray-400"
                  >
                    Bureaux en stock
                  </p>
                  <p
                    class="text-lg font-semibold text-white dark:text-gray-200"
                  >
                    {{$bureauxStocked}}

                  </p>
                </div>
              </div> 
              <!-- Card -->
              
              </div>
              @endcan

        @can('editer boxes')
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Boxes 
            </h2>


            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-5">


              <!-- Card -->
              <div
                class="flex items-center p-4 bg-yellow-100 rounded-lg shadow-md dark:bg-yellow-800"
              >
                <div
                  class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full dark:text-yellow-100 dark:bg-yellow-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M16.227,16.672c0,0.49-0.396,0.889-0.889,0.889H2.883c-0.491,0-0.889-0.398-0.889-0.889V5.107c0-0.491,0.398-0.89,0.889-0.89h7.562V3.328H2.883c-0.982,0-1.779,0.796-1.779,1.779v11.565c0,0.982,0.796,1.779,1.779,1.779h12.455c0.982,0,1.779-0.797,1.779-1.779V10h-0.891V16.672z M15.338,1.549c-1.965,0-3.559,1.593-3.559,3.558c0,1.966,1.594,3.558,3.559,3.558s3.559-1.592,3.559-3.558C18.896,3.142,17.303,1.549,15.338,1.549z M15.338,7.776c-1.475,0-2.668-1.195-2.668-2.669c0-1.474,1.193-2.669,2.668-2.669s2.668,1.195,2.668,2.669C18.006,6.581,16.812,7.776,15.338,7.776z"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-yellow-600 dark:text-yellow-400"
                  >
                    Total Boxes
                  </p>
                  <p
                    class="text-lg font-semibold text-yellow-700 dark:text-yellow-200"
                  >
                    @isset($boxs){{$boxs}}@else 0 @endisset

                  </p>
                </div>
              </div>
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-yellow-200 rounded-lg shadow-md dark:bg-yellow-800"
              >
                <div
                  class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full dark:text-yellow-100 dark:bg-yellow-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M16.227,16.672c0,0.49-0.396,0.889-0.889,0.889H2.883c-0.491,0-0.889-0.398-0.889-0.889V5.107c0-0.491,0.398-0.89,0.889-0.89h7.562V3.328H2.883c-0.982,0-1.779,0.796-1.779,1.779v11.565c0,0.982,0.796,1.779,1.779,1.779h12.455c0.982,0,1.779-0.797,1.779-1.779V10h-0.891V16.672z M15.338,1.549c-1.965,0-3.559,1.593-3.559,3.558c0,1.966,1.594,3.558,3.559,3.558s3.559-1.592,3.559-3.558C18.896,3.142,17.303,1.549,15.338,1.549z M15.338,7.776c-1.475,0-2.668-1.195-2.668-2.669c0-1.474,1.193-2.669,2.668-2.669s2.668,1.195,2.668,2.669C18.006,6.581,16.812,7.776,15.338,7.776z"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-yellow-600 dark:text-yellow-400"
                  >
                    Boxes vendus
                  </p>
                  <p
                    class="text-lg font-semibold text-yellow-700 dark:text-yellow-200"
                  >
                    @isset($boxs){{$boxs}}@else 0 @endisset

                  </p>
                </div>
              </div>              
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-yellow-300 rounded-lg shadow-md dark:bg-yellow-800"
              >
                <div
                  class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full dark:text-yellow-100 dark:bg-yellow-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M16.227,16.672c0,0.49-0.396,0.889-0.889,0.889H2.883c-0.491,0-0.889-0.398-0.889-0.889V5.107c0-0.491,0.398-0.89,0.889-0.89h7.562V3.328H2.883c-0.982,0-1.779,0.796-1.779,1.779v11.565c0,0.982,0.796,1.779,1.779,1.779h12.455c0.982,0,1.779-0.797,1.779-1.779V10h-0.891V16.672z M15.338,1.549c-1.965,0-3.559,1.593-3.559,3.558c0,1.966,1.594,3.558,3.559,3.558s3.559-1.592,3.559-3.558C18.896,3.142,17.303,1.549,15.338,1.549z M15.338,7.776c-1.475,0-2.668-1.195-2.668-2.669c0-1.474,1.193-2.669,2.668-2.669s2.668,1.195,2.668,2.669C18.006,6.581,16.812,7.776,15.338,7.776z"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-yellow-700 dark:text-gray-400"
                  >
                    Boxes bloqués
                  </p>
                  <p
                    class="text-lg font-semibold text-yellow-700 dark:text-gray-200"
                  >
                    {{$boxesBlocked}}

                  </p>
                </div>
              </div>       
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-yellow-400 rounded-lg shadow-md dark:bg-yellow-800"
              >
                <div
                  class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full dark:text-yellow-100 dark:bg-yellow-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M16.382,15.015h0.455h0.457V4.985h-0.457h-0.455V15.015z M16.837,4.985c1.008,0,1.824-0.816,1.824-1.822c0-1.008-0.816-1.824-1.824-1.824c-1.006,0-1.822,0.816-1.822,1.824C15.015,4.169,15.831,4.985,16.837,4.985z M16.837,2.25c0.504,0,0.913,0.409,0.913,0.913c0,0.502-0.409,0.911-0.913,0.911c-0.502,0-0.911-0.409-0.911-0.911C15.926,2.659,16.335,2.25,16.837,2.25z M15.015,3.618V3.163V2.706H4.986v0.457v0.455H15.015z M3.162,15.01c-1.007,0-1.823,0.816-1.823,1.822c0,1.008,0.816,1.824,1.823,1.824s1.824-0.816,1.824-1.824C4.986,15.831,4.169,15.015,3.162,15.015z M3.162,17.75c-0.503,0-0.911-0.409-0.911-0.913c0-0.502,0.408-0.911,0.911-0.911c0.504,0,0.912,0.409,0.912,0.911C4.074,17.341,3.666,17.75,3.162,17.75z M4.986,16.382v0.455v0.457h10.029v-0.457v-0.455H4.986zM16.837,15.015c-1.006,0-1.822,0.816-1.822,1.822c0,1.008,0.816,1.824,1.822,1.824c1.008,0,1.824-0.816,1.824-1.824C18.661,15.831,17.845,15.015,16.837,15.015z M16.837,17.75c-0.502,0-0.911-0.409-0.911-0.913c0-0.502,0.409-0.911,0.911-0.911c0.504,0,0.913,0.409,0.913,0.911C17.75,17.341,17.341,17.75,16.837,17.75z M3.618,4.985H3.162H2.707v10.029h0.456h0.456V4.985zM4.986,3.163c0-1.008-0.817-1.824-1.824-1.824S1.339,2.155,1.339,3.163c0,1.006,0.816,1.822,1.823,1.822S4.986,4.169,4.986,3.163zM3.162,4.074c-0.503,0-0.911-0.409-0.911-0.911c0-0.504,0.408-0.913,0.911-0.913c0.504,0,0.912,0.409,0.912,0.913C4.074,3.665,3.666,4.074,3.162,4.074z"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-yellow-700 dark:text-yellow-400"
                  >
                    Boxes réservés
                  </p>
                  <p
                    class="text-lg font-semibold text-yellow-700 dark:text-yellow-200"
                  >
                    {{$boxesPromised}}

                  </p>
                </div>
              </div> 

              <!-- Card -->
              <div
                class="flex items-center p-4 bg-yellow-400 rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-yellow-500 bg-yellow-50 rounded-full dark:text-yellow-100 dark:bg-yellow-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M16.227,16.672c0,0.49-0.396,0.889-0.889,0.889H2.883c-0.491,0-0.889-0.398-0.889-0.889V5.107c0-0.491,0.398-0.89,0.889-0.89h7.562V3.328H2.883c-0.982,0-1.779,0.796-1.779,1.779v11.565c0,0.982,0.796,1.779,1.779,1.779h12.455c0.982,0,1.779-0.797,1.779-1.779V10h-0.891V16.672z M15.338,1.549c-1.965,0-3.559,1.593-3.559,3.558c0,1.966,1.594,3.558,3.559,3.558s3.559-1.592,3.559-3.558C18.896,3.142,17.303,1.549,15.338,1.549z M15.338,7.776c-1.475,0-2.668-1.195-2.668-2.669c0-1.474,1.193-2.669,2.668-2.669s2.668,1.195,2.668,2.669C18.006,6.581,16.812,7.776,15.338,7.776z"></path>
                  </svg>  
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-white dark:text-yellow-400"
                  >
                    Boxes en stock
                  </p>
                  <p
                    class="text-lg font-semibold text-white dark:text-yellow-200"
                  >
                    {{$boxesStocked}}

                  </p>
                </div>
              </div> 
              <!-- Card -->
              
              </div>
              @endcan

              @can('editer dossiers')
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Dossiers 
            </h2>

              <!-- Card -->
 
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-5">
                       
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"
                    ></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Dossiers validés
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{$dossiersOver30}}
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-red-500 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"
                    ></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Dossiers non-validés
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{$dossiersUnder30}}
                  </p>
                </div>
              </div>              
              <!-- Card -->
              
            </div>
            @endcan

<div class="grid gap-6 mb-8 md:grid-cols-2">
              @can('voir lots')
              <!-- Doughnut/Pie chart -->
              <div
                class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                  Etats des lots
                </h4>
                <canvas id="pie"></canvas>
                <div
                  class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400"
                >
                  <!-- Chart legend -->
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"
                    ></span>
                    <span>Réservé</span>
                  </div>
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-green-600 rounded-full"
                    ></span>
                    <span>En Stock</span>
                  </div>
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-blue-600 rounded-full"
                    ></span>
                    <span>Bloqué</span>
                  </div>
                </div>
              </div>
              @endcan
              @can('voir appartements')
              <!-- Doughnut/Pie chart -->
              <div
                class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                  Etats des appartements
                </h4>
                <canvas id="pieAppartement"></canvas>
                <div
                  class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400"
                >
                  <!-- Chart legend -->
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"
                    ></span>
                    <span>Réservé</span>
                  </div>
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-green-600 rounded-full"
                    ></span>
                    <span>En Stock</span>
                  </div>
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-blue-600 rounded-full"
                    ></span>
                    <span>Bloqué</span>
                  </div>
                </div>
              </div>
              @endcan              
              @can('voir prospection')
              <!-- Lines chart -->
              <div
                class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                  Nombre de visites par mois
                </h4>
                <canvas id="line"></canvas>
                <div
                  class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400"
                >
                  <!-- Chart legend -->
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-green-600 rounded-full"
                    ></span>
                    <span>Evolution des visites et de la prospection</span>
                  </div>

                </div>
              </div>
              @endcan
              @can('voir dossiers')
              <!-- Bars chart -->
              <div
                class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                  Ventes par mois et par type
                </h4>
                <canvas id="bars"></canvas>
                <div
                  class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400"
                >
                  <!-- Chart legend -->
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-purple-500 rounded-full"
                    ></span>
                    <span>Appartements</span>
                  </div>
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-red-600 rounded-full"
                    ></span>
                    <span>Lots</span>
                  </div>
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-blue-600 rounded-full"
                    ></span>
                    <span>Magasins</span>
                  </div>
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-green-600 rounded-full"
                    ></span>
                    <span>Bureaux</span>
                  </div>
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-yellow-600 rounded-full"
                    ></span>
                    <span>Box</span>
                  </div> 
                                                      
                </div>
              </div>
              @endcan
@can('voir dossiers')
              <!-- Bars chart -->
              <div
                class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                  Ventes par mois et par type
                </h4>
                <canvas id="barsPerformance"></canvas>
                <div
                  class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400"
                >
 
                  <!-- Chart legend -->
                  <div class="flex items-center">
                      <span>Performances des commerciaux</span>
                  </div>
                </div>
              </div>
              @endcan              
              <!-- Lines chart -->
              @can('voir dossiers')
              <div
                class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                  Etat des ventes par mois
                </h4>
                <canvas id="lineV"></canvas>
                <div
                  class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400"
                >
                  <!-- Chart legend -->
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-green-600 rounded-full"
                    ></span>
                    <span>Evolution des ventes mensuellement</span>
                  </div>

                </div>
              </div> 
              @endcan
            </div>
<div class="grid gap-6 mb-8 md:grid-cols-2">
@can('voir prospection')
<!-- Doughnut/Pie chart -->
              <div
                class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                  Interêts des visiteurs
                </h4>
                <canvas id="pieInteret"></canvas>
                <div
                  class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400"
                >
                  <!-- Chart legend -->
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-red-600 rounded-full"
                    ></span>
                    <span>Lots</span>
                  </div>
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-pink-400 rounded-full"
                    ></span>
                    <span>Bureaux</span>
                  </div>
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-blue-800 rounded-full"
                    ></span>
                    <span>Appartements</span>
                  </div>
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-blue-300 rounded-full"
                    ></span>
                    <span>Magasins</span>
                  </div>
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-indigo-200 rounded-full"
                    ></span>
                    <span>Boxes</span>
                  </div>                                    
                </div>
              </div>
</div>
@endcan




            <!-- New Table -->
            @can('voir dossiers')
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
              <div class="w-full overflow-x-auto">
             <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                  Les dernières ventes
                </h4>                
                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="px-4 py-3">N° du dossier</th>
                      <th class="px-4 py-3">Date du dossier</th>
                      <th class="px-4 py-3">Frais</th>
                      <th class="px-4 py-3">Client</th>
                      <th class="px-4 py-3">Commercial</th>
                      <th class="px-4 py-3">Total Avances</th>




                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >

                  @foreach ($dossiers as $dossier)
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">

                          <!-- Avatar with inset shadow -->
                          <div
                            class="relative hidden w-8 h-8 mr-3 rounded-full md:block"
                          >
                            <img
                              class="object-cover w-full h-full rounded-full"
                              src="{{asset('floor-plan.png')}}"
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
                             <a href="/dossiers/{{ $dossier->id }}">
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-700 dark:text-blue-100"
                        >                              
                              {{ $dossier->num }} 
                        </span></a>
                            </p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                          <a href="{{ $dossier->produit->constructible_type }}s/{{ $dossier->produit->constructible->id }}">
                          {{ $dossier->produit->constructible_type }} N°
                          {{ $dossier->produit->constructible->num }}
                        </a>
                            </p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{ $dossier->date }} 
                      </td>
                      <td class="px-4 py-3 text-xs">
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                        >
                          {{ number_format($dossier->frais) }} Dhs
                        </span>
                        
                      </td>

                                                                  
                      <td class="px-4 py-3 text-xs">
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                        >
                        {{$dossier->client->nom}} {{$dossier->client->prenom}}                       
                        </span>
                       
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{ $dossier->user->name }}
                      </td>                      
                      <td class="px-4 py-3 text-sm">
                        <span
                          class="px-2 py-1 font-semibold leading-tight rounded-full dark:bg-green-700 dark:text-green-100
                          @if ($dossier->etatProduit == 'En stock')
                            text-green-700 bg-green-100
                            @elseif ($dossier->etatProduit == 'Bloqué')
                            text-white bg-gray-900
                            @else
                            text-red-200 bg-red-900
                          @endif

                          "
                        >
                          {{number_format($dossier->paiements->sum('montant'))}} Dhs
                        </span>
                      </td>
                      
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div
                class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800"
              >
                {{$dossiers->links()}}
              </div>
            </div>
            @endcan
          </div>
        </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>


<script>


// déclarer les types constructibles avant affectation de % interets au cas ou 
// y'a pas d'interêt pour un type de constructible donné
var lot = 0 ;
var bureau = 0 ;
var appartement = 0 ;
var magasin = 0 ;
var box = 0 ;

// affecter un % pour les types constructibles
@foreach ($interets as $interet)
  var {{$interet->interet}}={{$interet->nombre}}
@endforeach

{{$i = 0 }}
{{$k = 0 }}

@foreach ($nombreVisites as $visite)
  var v{{$loop->iteration}}={{$visite->nombreVisites}}
  var d{{$loop->iteration}}='{{ $mois[ ($visite->mois - 1) ] }}'
  {{$i = $loop->iteration}}
  {{$k = ($visite->mois - 1) }}  
@endforeach

@if ($i < 7)
  @for ($i = $i+1 ; $i <= 7; $i++)
  {{$k++}}
  var v{{$i}}=0
  var d{{$i}}='{{ $mois[ ($k) ] }}'
  @endfor
@endif

// pour définir l'etat des lots
var stocked={{ $stocked }}
var blocked={{ $blocked }}
var reserved={{ $reserved }}

// pour définir l'etat des appartements
var appartementsStocked={{ $appartementsStocked }}
var appartementsBlocked={{ $appartementsBlocked }}
var appartementsReserved={{ $appartementsReserved }}

// définier le graph BAR ventes par type et par mois
{{$i = 0 }}
@foreach ($nombreVentes as $ventes)
  var lot{{$loop->iteration}}={{$ventes->lot}}
  var bur{{$loop->iteration}}={{$ventes->bureau}}
  var box{{$loop->iteration}}={{$ventes->box}}
  var app{{$loop->iteration}}={{$ventes->appartement}}
  var mag{{$loop->iteration}}={{$ventes->magasin}}
  var da{{$loop->iteration}}='{{ $mois[ ($ventes->mois - 1) ] }}'
  {{$i = $loop->iteration}}
@endforeach

@if ($i < 7)
  @for ($i = $i+1 ; $i <= 7; $i++)
  var lot{{$i}}=0
  var bur{{$i}}=0
  var box{{$i}}=0
  var app{{$i}}=0
  var mag{{$i}}=0
  var da{{$i}}='{{ $mois[ ($i) ] }}'
  @endfor
@endif
// fin BAR



// définir evolution de vente par mois
{{$i = 0 }}
@foreach ($nombreVentesParMois as $ventes)
  var vvpm{{$loop->iteration}}={{$ventes->nombreVentes}}
  var dvpm{{$loop->iteration}}='{{ $mois[ ($ventes->mois - 1) ] }}'
  {{$i = $loop->iteration}}
@endforeach

@if ($i < 7)
  @for ($i = $i+1 ; $i <= 7; $i++)
  var vvpm{{$i}}=0
  var dvpm{{$i}}='{{ $mois[ ($i) ] }}'
  @endfor
@endif


</script>



    <script src="{{config('app.url')}}/js/charts-pie.js" defer></script>
    <script src="{{config('app.url')}}/js/charts-pieAppartement.js" defer></script>

    <script src="{{config('app.url')}}/js/charts-lines.js" defer></script>
    <script src="{{config('app.url')}}/js/charts-bars.js" defer></script>
    <script src="{{config('app.url')}}/js/charts-linesV.js" defer></script>
    <script src="{{config('app.url')}}/js/pie-interet-visites.js" defer></script>


<!-- here graph bar ventes par commercial -->
  <script>
    window.chartColors = {
      red: '#DC2626',
      teal: '#14B8A6',
      yellow: '#EAB308',
      green: '#22C55E',
      blue: '#06B6D4',
      purple: '#A855F7',
      grey: '#52525B'
    };

    var config = {
      type: 'bar',
      data: {
        labels: [da1, da2, da3, da4, da5, da6, da7],
        datasets: []
      },

  options: {
      scales: {
      yAxes: [{
                  scaleLabel: {
                    display: true
                  },
                  ticks: {
                    beginAtZero: true,
                    min: 0,
                    stepSize: 1,
                  }
                }],
      },
    responsive: true,
    legend: {
      display: false,
    },
  },
    };
   







window.onload = function() {
var com = [] ;

const barsCtxVentesParCommercials = document.getElementById('barsPerformance');
window.myLine = getNewChart(barsCtxVentesParCommercials, config);

  @foreach ($commerciaux as $commercial) // = execution 8 times/commerciaux

    @foreach ($performanceCommercial as $performance) // = execution 4 times/mois

      nom = '{{$commercial}}' ;

    com.push({{$performance->$commercial}}) // = execution 8 times/commerciaux

  @endforeach
    push(com, nom) 

    com = [] ;


  var da{{$loop->iteration}}='{{ $mois[ ($performance->mois - 1) ] }}'
  {{$i = $loop->iteration}}

@endforeach

    };
    
        function getNewChart(canvas, config) {
            return new Chart(canvas, config);
        }
    

    var colorNames = Object.keys(window.chartColors);
    
    function push(com, nom) {
      size = {{sizeof($performanceCommercial)}} ;
      sizeA = {{sizeof($performanceCommercial)}} ;

      var colorName = colorNames[config.data.datasets.length % colorNames.length];
      var newColor = window.chartColors[colorName];
      var newDataset = {
        label: nom,
        backgroundColor: newColor,
        borderColor: newColor,
        borderWidth: 1,
        data: [],
      };

      for (var index = 0; index < size ; ++index) {
        //alert(com) ;
          newDataset.data.push(com[index]);
      }
      config.data.datasets.push(newDataset);
      window.myLine.update();
    }

  </script>


</x-master>
