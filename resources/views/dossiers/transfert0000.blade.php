<x-master>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
        @if(!$errors->isEmpty())
        <p class="block h-160 px-4 py-4 rounded-lg mx-auto w-full mt-4
        bg-red-200 text-red-600 text-xl"> Attention Il y'a des erreurs dans votre formulaire</p>
        <h4>{{$errors->first()}}</h4>
        @endif

            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Transfert d'un dossier du vente {{$dossier->produit->constructible_type}} N° {{$dossier->produit->constructible->num}} 
            </h2>


              <div
                class="flex items-center justify-between p-2 mb-2 text-sm font-semibold text-blue-600 bg-blue-100 rounded-lg shadow-sm focus:outline-none focus:shadow-outline-blue rounded-2xl">
                {{$dataRecap}}
              </div>

<div>


            <div
              class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800"
            >

  <form action="/dossiers/{{ $dossier->id }}/demandeTransfert" method="POST">
    @csrf


              <div class="flex">
                @can('supprimer dossiers')
                <!-- pour télécharger la la demande de transfert -->
                <div class="mr-1">
                <button
                  class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray"
                  aria-label="Like"
                  type="submit"
                >
                    Générer la demande de transfert
                </button>
              </div>
                <!-- fin telechargement la demande de transfert -->
                @endcan
              </div>
            </form>
<hr class="mt-4">


            <form action="/dossiers/{{$dossier->id}}" method="POST" x-on:submit.prevent
              id="DossierForm">
              @csrf
              @method('PUT')
              <input type="hidden" id="idProduit" name="produit" value="@isset($produit->id){{$produit->id}}@endisset">




              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                  Pour quel client ?
                </span>


                @foreach ($dossier->clients as $c)
<div class="mb-2" id="{{ $c->id }}">
      <div class="flex -mx-2">

 <div class="w-1/3 px-2 w-full ">

 <div
 class="relative focus-within:text-purple-600"
 >


                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  name="client[]"
                >
                  @foreach ($clients as $client)
                    <option value="{{ $client->id }}"
                      @if($c->id === $client->id)
                        selected
                      @endif
                      >{{$client->nom}} {{$client->prenom}} - {{$client->cin}}
                    </option>
                  @endforeach
                </select>
@if (!$loop->first)
 <button
 class="absolute inset-y-0 right-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-r-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
 @click="supprimer({{ $c->id }});">
 Supprimer
</button>
@endif
</div>    

</div>
</div>
<hr class="mt-4">
</div>

  @endforeach


              </label>  

<!-- ajouter un autre client au dossier de vente -->
<section
x-data="{
client:[],
todos:[


      @php
      $i = 0 ;
      @endphp

   @while (null !== old('client.'.$i) )
    {
      id: {{$i}} ,
      name : 'client{{$i}}' , 
      client : '{{old('client.'.$i)}}',
    },
      @php
      $i++;
      @endphp
    @endwhile
],

newTodo:'',
addTodo(){
this.todos.push({
id: this.todos.length +1,
name : this.client.push(this.todos.length) ,

});
},

deleteTodo(todo){

this.todos.splice(this.todos.indexOf(todo), 1 );
}

}"
>




  

  <button type="button" class="px-4 py-2 mt-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple mb-2" @click="addTodo">
    + Ajouter un client

  </button>
  <hr class="mt-2">



<section x-show="todos.length">
  <template x-for="todo in todos" :key="todo.id">
    <div class="mb-2">
      <div class="flex -mx-2">

 <div class="w-1/3 px-2 w-full ">

 <div
 class="relative focus-within:text-purple-600"
 >


                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  name="client[]"
                 :key="todo.id"
                  :value="todo.client"
                 :id="todo.name"
                >
                @foreach ($clients as $client)
                  <option value="{{ $client->id }}">{{$client->nom}} {{$client->prenom}} - {{$client->cin}}</option>
                @endforeach
                </select>


     @error('p.*')
        <p class="block px-2 py-2 rounded-md w-full mt-2
    bg-red-600 text-white text-xs"> Attention :{{ $message }}</p>
    @enderror
 <button
 class="absolute inset-y-0 right-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-r-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
 @click="deleteTodo(todo)">
 Supprimer
</button>
</div>    

</div>
</div>
<hr class="mt-4">
</div>
</template>
</section>


</section>

<!-- fin d'ajout d'un autre client au dossier de vente -->


<!-- début upload pièce jointe -->
              <div class="mt-4 text-sm" x-show="isOpen">
                    @error('demandeTransfert')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror

                <span class="text-gray-700 dark:text-gray-400">
                  Uploader la demande de transfert légalisée.
                </span>
                <div class="mt-2">



        
    <input
    type="file"
    name="demandeTransfert"
    id="demandeTransfert"
    required
    >

    @error('demandeTransfert')
    <p id="logoError" class="block h-10 px-2 py-2 rounded-md w-full mt-2
    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
    @enderror

                </div>
              </div>              

             
              <!-- fin upload pièce jointe -->

                <div class="block mt-4 text-sm">
                <button
                  class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green"
                  type="submit"
                  @click="submit();"
                >
                  Modifier
                </button>
              </div>


            
            </form>
</div>



          </div>
            </div>

          </div>
        </main>
</x-master>            