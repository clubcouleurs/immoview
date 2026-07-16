<x-master>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
 
            @can('voir finance')
            <h2
              class="text-2xl font-semibold text-gray-700 dark:text-gray-200"
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
                    Aujroud'hui
                  </p>
                  <p
                    class="flex text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{ $visitesDay }} <img class="h-6 ml-2 mr-2" src="{{asset('storage/'. 'visite.png')}}"> | 
                    {{$appelsDay}} <img class="h-6 ml-2" src="{{asset('storage/'. 'appel.png')}}">
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
                    Cette semaine
                  </p>
                  <p
                    class="flex text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{ $visitesWeek }} <img class="h-6 ml-2 mr-2" src="{{asset('storage/'. 'visite.png')}}"> | 
                    {{$appelsWeek}} <img class="h-6 ml-2" src="{{asset('storage/'. 'appel.png')}}">
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
                    Ce mois
                  </p>
                  <p
                    class="flex text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{ $visitesMonth }} <img class="h-6 ml-2 mr-2" src="{{asset('storage/'. 'visite.png')}}"> | 
                    {{$appelsMonth}} <img class="h-6 ml-2" src="{{asset('storage/'. 'appel.png')}}">
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
                    Cette année {{date_format(now(), 'Y')}}
                  </p>
                  <p
                    class="flex text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{ $visitesYear }} <img class="h-6 ml-2 mr-2" src="{{asset('storage/'. 'visite.png')}}"> | 
                    {{$appelsYear}} <img class="h-6 ml-2" src="{{asset('storage/'. 'appel.png')}}">
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

            <!--  paiements due et impayés  -->
            @can('voir impaye')
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Paiements dues et impayés 
            </h2>
            <!-- Cards -->
            <div class="grid gap-6 mb-2 md:grid-cols-2 xl:grid-cols-6">
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-yellow-500 rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full dark:text-orange-100 dark:bg-orange-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M2.92893219,17.0710678 C6.83417511,20.9763107 13.1658249,20.9763107 17.0710678,17.0710678 C20.9763107,13.1658249 20.9763107,6.83417511 17.0710678,2.92893219 C13.1658249,-0.976310729 6.83417511,-0.976310729 2.92893219,2.92893219 C-0.976310729,6.83417511 -0.976310729,13.1658249 2.92893219,17.0710678 Z M9,5 L11,5 L11,11 L9,11 L9,5 Z M9,13 L11,13 L11,15 L9,15 L9,13 Z" id="Combined-Shape"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-white dark:text-gray-400"
                  >
                    Nombre de paiements à encaisser aujourd'hui
                  </p>
                  <p
                    class="text-3xl font-semibold text-white dark:text-gray-200"
                  >
                    <a href="/paiements?dateEnd={{$today}}">{{$paiementsDueNbr}}</a>
                  </p>
                </div>

              </div>
               <!-- Card -->
              <div
                class="flex items-center p-4 bg-yellow-500 rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full dark:text-orange-100 dark:bg-orange-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M2.92893219,17.0710678 C6.83417511,20.9763107 13.1658249,20.9763107 17.0710678,17.0710678 C20.9763107,13.1658249 20.9763107,6.83417511 17.0710678,2.92893219 C13.1658249,-0.976310729 6.83417511,-0.976310729 2.92893219,2.92893219 C-0.976310729,6.83417511 -0.976310729,13.1658249 2.92893219,17.0710678 Z M9,5 L11,5 L11,11 L9,11 L9,5 Z M9,13 L11,13 L11,15 L9,15 L9,13 Z" id="Combined-Shape"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-white dark:text-gray-400"
                  >
                    Nombre d'échéances impayées à ce jour
                  </p>
                  <p
                    class="text-3xl font-semibold text-white dark:text-gray-200"
                  >
                    <a href="/paiements?dateEnd={{$today}}&status=3">{{$paiementsDueUntilNbr}}</a>
                  </p>
                </div>
                
              </div>
 
              <!-- Card -->
              <!-- Card -->
              @can('voir relance')
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
                  <a href="/dossiers?etatDossier=0&relance=today">
                   {{$dossiersToday}} Dossiers
                 </a>
                  </p>
                </div>
              </div>
              @endcan              
              <!-- Card -->
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-red-500 rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-red-500 bg-red-100 rounded-full dark:text-orange-100 dark:bg-orange-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M2.92893219,17.0710678 C6.83417511,20.9763107 13.1658249,20.9763107 17.0710678,17.0710678 C20.9763107,13.1658249 20.9763107,6.83417511 17.0710678,2.92893219 C13.1658249,-0.976310729 6.83417511,-0.976310729 2.92893219,2.92893219 C-0.976310729,6.83417511 -0.976310729,13.1658249 2.92893219,17.0710678 Z M9,5 L11,5 L11,11 L9,11 L9,5 Z M9,13 L11,13 L11,15 L9,15 L9,13 Z" id="Combined-Shape"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-white dark:text-gray-400"
                  >
                    Les impayés
                  </p>
                  <p
                    class="text-3xl font-semibold text-white dark:text-gray-200"
                  >
                    <a href="/paiements?status=2">{{$paiementsUnpaidNbr}}</a>
                  </p>
                </div>
              </div>
              

            

            </div>
            @endcan
            <!--  fin paiements due et impayés -->

            <!-- fin relance -->
@foreach($projet->typesConstructiblesSupportes() as $typeConstructible)

  
            @can('editer $typeConstructible')
            
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-purple-200"
            >
              {{ ucfirst($typeConstructible) }}
            </h2>


            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-5">


              <!-- Card -->
              <div
                class="flex items-center p-4 bg-green-100 rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-red-100 dark:bg-red-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M16.803,18.615h-4.535c-1,0-1.814-0.812-1.814-1.812v-4.535c0-1.002,0.814-1.814,1.814-1.814h4.535c1.001,0,1.813,0.812,1.813,1.814v4.535C18.616,17.803,17.804,18.615,16.803,18.615zM17.71,12.268c0-0.502-0.405-0.906-0.907-0.906h-4.535c-0.501,0-0.906,0.404-0.906,0.906v4.535c0,0.502,0.405,0.906,0.906,0.906h4.535c0.502,0,0.907-0.404,0.907-0.906V12.268z M16.803,9.546h-4.535c-1,0-1.814-0.812-1.814-1.814V3.198c0-1.002,0.814-1.814,1.814-1.814h4.535c1.001,0,1.813,0.812,1.813,1.814v4.534C18.616,8.734,17.804,9.546,16.803,9.546zM17.71,3.198c0-0.501-0.405-0.907-0.907-0.907h-4.535c-0.501,0-0.906,0.406-0.906,0.907v4.534c0,0.501,0.405,0.908,0.906,0.908h4.535c0.502,0,0.907-0.406,0.907-0.908V3.198z M7.733,18.615H3.198c-1.002,0-1.814-0.812-1.814-1.812v-4.535c0-1.002,0.812-1.814,1.814-1.814h4.535c1.002,0,1.814,0.812,1.814,1.814v4.535C9.547,17.803,8.735,18.615,7.733,18.615zM8.64,12.268c0-0.502-0.406-0.906-0.907-0.906H3.198c-0.501,0-0.907,0.404-0.907,0.906v4.535c0,0.502,0.406,0.906,0.907,0.906h4.535c0.501,0,0.907-0.404,0.907-0.906V12.268z M7.733,9.546H3.198c-1.002,0-1.814-0.812-1.814-1.814V3.198c0-1.002,0.812-1.814,1.814-1.814h4.535c1.002,0,1.814,0.812,1.814,1.814v4.534C9.547,8.734,8.735,9.546,7.733,9.546z M8.64,3.198c0-0.501-0.406-0.907-0.907-0.907H3.198c-0.501,0-0.907,0.406-0.907,0.907v4.534c0,0.501,0.406,0.908,0.907,0.908h4.535c0.501,0,0.907-0.406,0.907-0.908V3.198z"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-green-600 dark:text-red-400"
                  >
                    Total {{ ucfirst($typeConstructible) }}
                  </p>
                  <p
                    class="text-lg font-semibold text-green-700 dark:text-red-200"
                  >
                    {{ $produitsOverView->get($typeConstructible . 'All') }}

                  </p>
                </div>
              </div>
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-green-200 rounded-lg shadow-md dark:bg-red-800"
              >
                <div
                  class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-red-100 dark:bg-red-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M16.803,18.615h-4.535c-1,0-1.814-0.812-1.814-1.812v-4.535c0-1.002,0.814-1.814,1.814-1.814h4.535c1.001,0,1.813,0.812,1.813,1.814v4.535C18.616,17.803,17.804,18.615,16.803,18.615zM17.71,12.268c0-0.502-0.405-0.906-0.907-0.906h-4.535c-0.501,0-0.906,0.404-0.906,0.906v4.535c0,0.502,0.405,0.906,0.906,0.906h4.535c0.502,0,0.907-0.404,0.907-0.906V12.268z M16.803,9.546h-4.535c-1,0-1.814-0.812-1.814-1.814V3.198c0-1.002,0.814-1.814,1.814-1.814h4.535c1.001,0,1.813,0.812,1.813,1.814v4.534C18.616,8.734,17.804,9.546,16.803,9.546zM17.71,3.198c0-0.501-0.405-0.907-0.907-0.907h-4.535c-0.501,0-0.906,0.406-0.906,0.907v4.534c0,0.501,0.405,0.908,0.906,0.908h4.535c0.502,0,0.907-0.406,0.907-0.908V3.198z M7.733,18.615H3.198c-1.002,0-1.814-0.812-1.814-1.812v-4.535c0-1.002,0.812-1.814,1.814-1.814h4.535c1.002,0,1.814,0.812,1.814,1.814v4.535C9.547,17.803,8.735,18.615,7.733,18.615zM8.64,12.268c0-0.502-0.406-0.906-0.907-0.906H3.198c-0.501,0-0.907,0.404-0.907,0.906v4.535c0,0.502,0.406,0.906,0.907,0.906h4.535c0.501,0,0.907-0.404,0.907-0.906V12.268z M7.733,9.546H3.198c-1.002,0-1.814-0.812-1.814-1.814V3.198c0-1.002,0.812-1.814,1.814-1.814h4.535c1.002,0,1.814,0.812,1.814,1.814v4.534C9.547,8.734,8.735,9.546,7.733,9.546z M8.64,3.198c0-0.501-0.406-0.907-0.907-0.907H3.198c-0.501,0-0.907,0.406-0.907,0.907v4.534c0,0.501,0.406,0.908,0.907,0.908h4.535c0.501,0,0.907-0.406,0.907-0.908V3.198z"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-green-600 dark:text-red-400"
                  >
                    {{ ucfirst($typeConstructible) }} vendu(e)s
                  </p>
                  <p
                    class="text-lg font-semibold text-green-700 dark:text-red-200"
                  >
                    {{ $produitsOverView->get($typeConstructible . 'Reserved') }}

                  </p>
                </div>
              </div>              
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-green-300 rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-red-100 dark:bg-red-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M16.803,18.615h-4.535c-1,0-1.814-0.812-1.814-1.812v-4.535c0-1.002,0.814-1.814,1.814-1.814h4.535c1.001,0,1.813,0.812,1.813,1.814v4.535C18.616,17.803,17.804,18.615,16.803,18.615zM17.71,12.268c0-0.502-0.405-0.906-0.907-0.906h-4.535c-0.501,0-0.906,0.404-0.906,0.906v4.535c0,0.502,0.405,0.906,0.906,0.906h4.535c0.502,0,0.907-0.404,0.907-0.906V12.268z M16.803,9.546h-4.535c-1,0-1.814-0.812-1.814-1.814V3.198c0-1.002,0.814-1.814,1.814-1.814h4.535c1.001,0,1.813,0.812,1.813,1.814v4.534C18.616,8.734,17.804,9.546,16.803,9.546zM17.71,3.198c0-0.501-0.405-0.907-0.907-0.907h-4.535c-0.501,0-0.906,0.406-0.906,0.907v4.534c0,0.501,0.405,0.908,0.906,0.908h4.535c0.502,0,0.907-0.406,0.907-0.908V3.198z M7.733,18.615H3.198c-1.002,0-1.814-0.812-1.814-1.812v-4.535c0-1.002,0.812-1.814,1.814-1.814h4.535c1.002,0,1.814,0.812,1.814,1.814v4.535C9.547,17.803,8.735,18.615,7.733,18.615zM8.64,12.268c0-0.502-0.406-0.906-0.907-0.906H3.198c-0.501,0-0.907,0.404-0.907,0.906v4.535c0,0.502,0.406,0.906,0.907,0.906h4.535c0.501,0,0.907-0.404,0.907-0.906V12.268z M7.733,9.546H3.198c-1.002,0-1.814-0.812-1.814-1.814V3.198c0-1.002,0.812-1.814,1.814-1.814h4.535c1.002,0,1.814,0.812,1.814,1.814v4.534C9.547,8.734,8.735,9.546,7.733,9.546z M8.64,3.198c0-0.501-0.406-0.907-0.907-0.907H3.198c-0.501,0-0.907,0.406-0.907,0.907v4.534c0,0.501,0.406,0.908,0.907,0.908h4.535c0.501,0,0.907-0.406,0.907-0.908V3.198z"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-green-700 dark:text-red-400"
                  >
                    {{ ucfirst($typeConstructible) }} bloqué(e)s
                  </p>
                  <p
                    class="text-lg font-semibold text-green-700 dark:text-red-200"
                  >
                   {{ $produitsOverView->get($typeConstructible . 'Blocked') }}
                    

                  </p>
                </div>
              </div>       
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-green-400 rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-red-100 dark:bg-red-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M16.803,18.615h-4.535c-1,0-1.814-0.812-1.814-1.812v-4.535c0-1.002,0.814-1.814,1.814-1.814h4.535c1.001,0,1.813,0.812,1.813,1.814v4.535C18.616,17.803,17.804,18.615,16.803,18.615zM17.71,12.268c0-0.502-0.405-0.906-0.907-0.906h-4.535c-0.501,0-0.906,0.404-0.906,0.906v4.535c0,0.502,0.405,0.906,0.906,0.906h4.535c0.502,0,0.907-0.404,0.907-0.906V12.268z M16.803,9.546h-4.535c-1,0-1.814-0.812-1.814-1.814V3.198c0-1.002,0.814-1.814,1.814-1.814h4.535c1.001,0,1.813,0.812,1.813,1.814v4.534C18.616,8.734,17.804,9.546,16.803,9.546zM17.71,3.198c0-0.501-0.405-0.907-0.907-0.907h-4.535c-0.501,0-0.906,0.406-0.906,0.907v4.534c0,0.501,0.405,0.908,0.906,0.908h4.535c0.502,0,0.907-0.406,0.907-0.908V3.198z M7.733,18.615H3.198c-1.002,0-1.814-0.812-1.814-1.812v-4.535c0-1.002,0.812-1.814,1.814-1.814h4.535c1.002,0,1.814,0.812,1.814,1.814v4.535C9.547,17.803,8.735,18.615,7.733,18.615zM8.64,12.268c0-0.502-0.406-0.906-0.907-0.906H3.198c-0.501,0-0.907,0.404-0.907,0.906v4.535c0,0.502,0.406,0.906,0.907,0.906h4.535c0.501,0,0.907-0.404,0.907-0.906V12.268z M7.733,9.546H3.198c-1.002,0-1.814-0.812-1.814-1.814V3.198c0-1.002,0.812-1.814,1.814-1.814h4.535c1.002,0,1.814,0.812,1.814,1.814v4.534C9.547,8.734,8.735,9.546,7.733,9.546z M8.64,3.198c0-0.501-0.406-0.907-0.907-0.907H3.198c-0.501,0-0.907,0.406-0.907,0.907v4.534c0,0.501,0.406,0.908,0.907,0.908h4.535c0.501,0,0.907-0.406,0.907-0.908V3.198z"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-white dark:text-red-400"
                  >
                    {{ ucfirst($typeConstructible) }} réservé(e)s
                  </p>
                  <p
                    class="text-lg font-semibold text-white dark:text-red-200"
                  >
                    
                    {{ $produitsOverView->get($typeConstructible . 'Promised') }}

                  </p>
                </div>
              </div>  

              <!-- Card -->
              <div
                class="flex items-center p-4 bg-green-500 rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-green-500 bg-green-50 rounded-full dark:text-red-100 dark:bg-red-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M16.803,18.615h-4.535c-1,0-1.814-0.812-1.814-1.812v-4.535c0-1.002,0.814-1.814,1.814-1.814h4.535c1.001,0,1.813,0.812,1.813,1.814v4.535C18.616,17.803,17.804,18.615,16.803,18.615zM17.71,12.268c0-0.502-0.405-0.906-0.907-0.906h-4.535c-0.501,0-0.906,0.404-0.906,0.906v4.535c0,0.502,0.405,0.906,0.906,0.906h4.535c0.502,0,0.907-0.404,0.907-0.906V12.268z M16.803,9.546h-4.535c-1,0-1.814-0.812-1.814-1.814V3.198c0-1.002,0.814-1.814,1.814-1.814h4.535c1.001,0,1.813,0.812,1.813,1.814v4.534C18.616,8.734,17.804,9.546,16.803,9.546zM17.71,3.198c0-0.501-0.405-0.907-0.907-0.907h-4.535c-0.501,0-0.906,0.406-0.906,0.907v4.534c0,0.501,0.405,0.908,0.906,0.908h4.535c0.502,0,0.907-0.406,0.907-0.908V3.198z M7.733,18.615H3.198c-1.002,0-1.814-0.812-1.814-1.812v-4.535c0-1.002,0.812-1.814,1.814-1.814h4.535c1.002,0,1.814,0.812,1.814,1.814v4.535C9.547,17.803,8.735,18.615,7.733,18.615zM8.64,12.268c0-0.502-0.406-0.906-0.907-0.906H3.198c-0.501,0-0.907,0.404-0.907,0.906v4.535c0,0.502,0.406,0.906,0.907,0.906h4.535c0.501,0,0.907-0.404,0.907-0.906V12.268z M7.733,9.546H3.198c-1.002,0-1.814-0.812-1.814-1.814V3.198c0-1.002,0.812-1.814,1.814-1.814h4.535c1.002,0,1.814,0.812,1.814,1.814v4.534C9.547,8.734,8.735,9.546,7.733,9.546z M8.64,3.198c0-0.501-0.406-0.907-0.907-0.907H3.198c-0.501,0-0.907,0.406-0.907,0.907v4.534c0,0.501,0.406,0.908,0.907,0.908h4.535c0.501,0,0.907-0.406,0.907-0.908V3.198z"></path>
                  </svg>  
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-white dark:text-gray-400"
                  >
                    {{ ucfirst($typeConstructible) }} en stock
                  </p>
                  <p
                    class="text-lg font-semibold text-white dark:text-gray-200"
                  >
                    {{ $produitsOverView->get($typeConstructible . 'Stocked') }}


                  </p>
                </div>
              </div> 


              </div>

              @endcan
@endforeach




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
                    Dossiers plus 30%
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
                    Dossiers moins 30%
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{$dossiersUnder30}}
                  </p>
                </div>
              </div>              
              <!-- Card -->
              

                <!-- Card -->
              
              <div
                class="flex bg-red-500 items-center p-4 rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-white rounded-full dark:text-orange-100 dark:bg-orange-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
<path d="M0 10a10 10 0 1 1 20 0 10 10 0 0 1-20 0zm16.32-4.9L5.09 16.31A8 8 0 0 0 16.32 5.09zm-1.41-1.42A8 8 0 0 0 3.68 14.91L14.91 3.68z"></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-white dark:text-gray-400"
                  >
                    Dossiers en litige
                  </p>
                  <p
                    class="text-lg font-semibold text-white dark:text-gray-200"
                  >
                  <a href="dossiers?litige=1">
                    {{$dossiersLitige}} Dossiers
                    </a>
                  </p>
                </div>
              </div>              

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
                  Ventes par mois et par commercial
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
                      <th class="px-4 py-3">Dossier Vente</th>
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
                              src="{{asset('storage/'. 'floor-plan.png')}}"
                              alt=""
                              loading="lazy"
                            />
                            <div
                              class="absolute inset-0 rounded-full shadow-inner"
                              aria-hidden="true"
                            ></div>
                          </div>
                          <div>
                           
<!--                             <p class="font-semibold">
                             <a href="/dossiers/{{ $dossier->id }}">
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-700 dark:text-blue-100"
                        >                              
                              {{ $dossier->num }}
                        </span></a>
                            </p> -->
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                          <!-- <a href="{{ $dossier->produit->constructible_type }}s/{{ $dossier->produit->constructible->id }}"> -->
                            <a href="/dossiers/{{ $dossier->id }}">
                          {{ ucfirst($dossier->produit->constructible_type) }} N°
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
                        @foreach ($dossier->clients as $client)
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                        >
                        {{$client->nom}} {{$client->prenom}}                       
                        </span>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                              CIN : {{ $client->cin }}
                            </p>  
                        @endforeach 
                       
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

    <script src="{{config('app.url')}}/js/Chart.min.js" defer></script>


<script>


// déclarer les types constructibles avant affectation de % interets au cas ou 
// y'a pas d'interêt pour un type de constructible donné
var lot = 0 ;
var bureau = 0 ;
var appartement = 0 ;
var magasin = 0 ;
var box = 0 ;



{{-- 1. On laisse la partie intérêt telle quelle au début --}}
@foreach ($interets as $interet)
  var {{ $interet->interet }} = {{ $interet->nombre }};
@endforeach

{{ $totalMonths = 7 }}
{{ $donneesComptees = count($nombreVisites) }}
{{ $moisManquants = $totalMonths - $donneesComptees }}

{{-- 2. On trouve le mois le plus ancien de tes visites --}}
{{ $moisLePlusAncien = $donneesComptees > 0 ? $nombreVisites[0]->mois - 1 : date('n') - 1 }}

{{ $indexGraph = 1 }}

{{-- 3. ÉTAPE 1 : On génère d'abord les mois de visites vides (Passé lointain) --}}
@if ($moisManquants > 0)
  @for ($j = $moisManquants; $j > 0; $j--)
    {{-- On recule dans le temps par rapport au mois le plus ancien --}}
    {{ $k = ($moisLePlusAncien - $j + 12) % 12 }}

    var v{{ $indexGraph }} = 0;
    var d{{ $indexGraph }} = '{{ $mois[$k] }}';
    {{ $indexGraph++ }}
  @endfor
@endif

{{-- 4. ÉTAPE 2 : On affiche tes vraies visites (Passé récent / Présent) --}}
@foreach ($nombreVisites as $visite)
  var v{{ $indexGraph }} = {{ $visite->nombreVisites }};
  var d{{ $indexGraph }} = '{{ $mois[$visite->mois - 1] }}';
  {{ $indexGraph++ }}
@endforeach


// pour définir l'etat des lots
var stocked=@isset($lotsStocked){{$lotsStocked}}@else 0 @endisset;
var blocked=@isset($lotsBlocked){{$lotsBlocked}}@else 0 @endisset;
var reserved=@isset($lotsReserved){{$lotsReserved}}@else 0 @endisset;

// pour définir l'etat des appartements
var appartementsStocked=@isset($appartementsStocked){{$appartementsStocked}}@else 0 @endisset;
var appartementsBlocked=@isset($appartementsBlocked){{$appartementsBlocked}}@else 0 @endisset;
var appartementsReserved=@isset($appartementsReserved){{$appartementsReserved}}@else 0 @endisset;





{{ $totalMonths = 7 }}
{{ $donneesComptees = count($nombreVentes) }}
{{ $moisManquants = $totalMonths - $donneesComptees }}

{{-- 1. On trouve le mois le plus ancien de tes données actuelles --}}
{{ $moisLePlusAncien = $donneesComptees > 0 ? $nombreVentes[0]->mois - 1 : date('n') - 1 }}

{{ $indexGraph = 1 }}

{{-- 2. ÉTAPE 1 : On génère d'abord les mois vides à 0 (Passé lointain) --}}
@if ($moisManquants > 0)
  @for ($j = $moisManquants; $j > 0; $j--)
    {{-- On recule dans le temps par rapport au mois le plus ancien --}}
    {{ $k = ($moisLePlusAncien - $j + 12) % 12 }}

    var lot{{ $indexGraph }} = 0;
    var bur{{ $indexGraph }} = 0;
    var box{{ $indexGraph }} = 0;
    var app{{ $indexGraph }} = 0;
    var mag{{ $indexGraph }} = 0;
    var da{{ $indexGraph }} = '{{ $mois[$k] }}';
    {{ $indexGraph++ }}
  @endfor
@endif

{{-- 3. ÉTAPE 2 : On affiche tes vraies ventes par type de produit (Passé récent / Présent) --}}
@foreach ($nombreVentes as $ventes)
  var lot{{ $indexGraph }} = {{ $ventes->lot }};
  var bur{{ $indexGraph }} = {{ $ventes->bureau }};
  var box{{ $indexGraph }} = {{ $ventes->box }};
  var app{{ $indexGraph }} = {{ $ventes->appartement }};
  var mag{{ $indexGraph }} = {{ $ventes->magasin }};
  var da{{ $indexGraph }} = '{{ $mois[$ventes->mois - 1] }}';
  {{ $indexGraph++ }}
@endforeach


{{ $totalMonths = 7 }}
{{ $donneesComptees = count($nombreVentesParMois) }}
{{ $moisManquants = $totalMonths - $donneesComptees }}

{{-- 1. On trouve le mois le plus ancien de tes données actuelles pour reculer à partir de là --}}
{{ $moisLePlusAncien = $donneesComptees > 0 ? $nombreVentesParMois[0]->mois - 1 : date('n') - 1 }}

{{ $indexGraph = 1 }}

{{-- 2. ÉTAPE 1 : On génère dabord les mois vides (Passé lointain) --}}
@if ($moisManquants > 0)
  @for ($j = $moisManquants; $j > 0; $j--)
    {{-- On recule dans le temps par rapport au mois le plus ancien --}}
    {{ $k = ($moisLePlusAncien - $j + 12) % 12 }}

    var vvpm{{ $indexGraph }} = 0;
    var dvpm{{ $indexGraph }} = '{{ $mois[$k] }}';
    {{ $indexGraph++ }}
  @endfor
@endif

{{-- 3. ÉTAPE 2 : On affiche tes vraies ventes (Passé récent / Présent) --}}
@foreach ($nombreVentesParMois as $ventes)
  var vvpm{{ $indexGraph }} = {{ $ventes->nombreVentes }};
  var dvpm{{ $indexGraph }} = '{{ $mois[$ventes->mois - 1] }}';
  {{ $indexGraph++ }}
@endforeach

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
@if(!empty($performanceCommercial))
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
@endif

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
