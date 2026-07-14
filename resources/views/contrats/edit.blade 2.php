<x-master>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
        @if(!$errors->isEmpty())
        <p class="block h-160 px-4 py-4 rounded-lg mx-auto w-full mt-4
        bg-red-200 text-red-600 text-xl"> Attention Il y'a des erreurs dans votre formulaire</p>
        @endif
        {{--$errors--}}
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
            </h2>
                       <form action="/contrats/{{$contrat->id}}" method="POST">
              @csrf
              @method('PATCH')
<div class="p-8" x-data= "app()" >

    <div class="mb-4">
        <button type="button" @click="addRow" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Ajouter un article
        </button>
    </div>

    <template x-for="(row, index) in rows" :key="index">

        <div class="mb-4 p-4 bg-gray-100 rounded-lg">
            <div class="mb-2">
                <input type="hidden" x-model="row.id" class="w-full border p-2"
                x-bind:name="`id[${index}]`"
                >                
                <input type="text" x-model="row.title" class="w-full border p-2"
                x-bind:name="`titre[${index}]`"
                >
            </div>
            <div class="mb-2">
                <textarea x-model="row.content" class="w-full border p-2"
                x-bind:name="`texte[${index}]`" rows=10
                ></textarea>
            </div>
            <div>
                <button type="button" @click="removeRow(index)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Supprimer
                </button>
            </div>
        </div>
    </template>
                <div class="block mt-4 text-sm">
                <button
                  class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                  type="submit"
                  @click="submit();"
                >
                  Sauvegarder
                </button>
              </div>
</div>
            </form>
          </div>
        </main>

            <script>
        function app() {
            return {
                rows :[
                    @foreach($contrat->articles as $article)
                        {id :"{{$article->id}}",
                        title:"{{$article->titre}}",
                        content:<?php echo json_encode($article->texte)?>},
                    @endforeach
                
                    ],
                rowId : 0 ,
                addRow() {
                    this.rows.push({id:this.rowId++ ,  title:'', content:''});
                },
                removeRow(index) {
                    this.rows.splice(index, 1);
                }
            };
        }
    </script>


</x-master>            