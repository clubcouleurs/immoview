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
              Modifier le rôle : {{$role->name}}
            </h2>
            <form action="/roles/{{$role->id}}" method="POST">
              @csrf
              @method('PATCH')
            <div
              class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800"
            >
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Intitulé du rôle</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Commercial ou comptable ou autre"
                  type="text"
                  name="name"
                  value="{{$role->name}}"
                  required
                />
                    @error('name')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror
              </label>

              <div class="mt-4 text-sm">

                    @error('type')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror

                <span class="text-gray-700 dark:text-gray-400">
                  Les autorisations ?
                </span>
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-5">
                @foreach ($permissions as $permission)

              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-md dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-green-500 rounded-full dark:text-green-100 dark:bg-green-500"
                >
                    <input
                      type="checkbox"
                      class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="permissions[]"
                      value="{{$permission->id}}"

                      @if ($role->permissions->contains($permission))
                        checked
                      @endif                       
                    />
                </div>
                <div>
                  <p
                    class="text-sm font-medium text-gray-700 dark:text-gray-400"
                  >
                    {{ucfirst($permission->name)}}
                  </p>
                </div>
              </div>
                     @endforeach                             

              </div>







              </div>



                  






                <div class="block mt-4 text-sm">
                <button
                  class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green"
                  type="submit"
                >
                  Modifier
                </button>
              </div>


            </div>
            </form>
          </div>
        </main>
</x-master>            