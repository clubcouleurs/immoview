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
              Ajouter une nouvelle Etiquette 
            </h2>

            <form action=@isset ($etiquette->label){{"/etiquettes/" . $etiquette->id}}@else "/etiquettes" @endisset
            method="POST">
              @csrf
              @isset ($etiquette->label)
                @method('PATCH')
              @endisset

            <div
              class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800"
            >
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Libellé</span>
                <textarea
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  rows="3"
                  placeholder="Libellé de cette etiquette"
                  name="label"

                >@isset ($etiquette->label){{$etiquette->label}}@endisset</textarea>


                    @error('label')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>





                <div class="block mt-4 text-sm">
                  @isset($etiquette->label)
                   <button
                    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-green-800 focus:outline-none focus:shadow-outline-purple"
                    type="submit"
                  >
                    Modifier
                  </button>
                  <a
                      class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                      href="/etiquettes"
                    >
                  Nouvelle etiquette
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
              class="my-6 text-4xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Récapitulatif des étiquettes
            </h2>

            <!-- New Table -->
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
              <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="px-4 py-3">N° de l'etiquette</th>
                      <th class="px-4 py-3">Description</th>
                      <th class="px-4 py-3">Action</th>


                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >

                  @foreach ($etiquettes as $etiquette)
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <!-- Avatar with inset shadow -->
                          <div
                            class="relative hidden w-8 h-8 mr-3 rounded-full md:block"
                          >
                            <img
                              class="object-cover w-full h-full rounded-full"
                              src="{{asset('tag.png')}}"
                              alt=""
                              loading="lazy"
                            />

                          </div>
                          <div>
                            <p class="font-semibold">
                        <span
                          class="px-2 py-1 font-semibold text-blue-700 bg-blue-100 rounded-full dark:bg-blue-700 dark:text-blue-100"
                        > 
                  {{ $etiquette->id }}
                </span>
                              </p>

                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{ $etiquette->label }}
                      </td>
                      <td class="flex px-4 py-3 text-sm">
                        @if($etiquette->id != 2 && $etiquette->id != 3)
                <div class="mr-1">
             
                <a
                  class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray"
                  aria-label="Like"
                  href="/etiquettes/{{ $etiquette->id }}"
                >
                  <svg
                    class="w-4 h-4"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                  <path d="M12.2928932,3.70710678 L0,16 L0,20 L4,20 L16.2928932,7.70710678 L12.2928932,3.70710678 Z M13.7071068,2.29289322 L16,0 L20,4 L17.7071068,6.29289322 L13.7071068,2.29289322 Z" id="Combined-Shape"></path>
                  </svg>
                </a>

            </div>

                      <form action="/etiquettes/{{$etiquette->id}}" method="POST">
                        @csrf
                        @method('DELETE')
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
              
                      </form>
                      @endif
                      </td>

                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div
                class="grid py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t"
              >
                {{--$produits->links()--}}
              </div>
            </div>


          </div>
        </main>
</x-master>
