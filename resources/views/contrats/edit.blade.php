<x-master>
      <main class="h-full overflow-y-auto" x-data="{ 
  @if(!$errors->isEmpty())
  modelOpen: true
  @else
  modelOpen: false
  @endif
   , edit : true}">
          <div class="container px-6 mx-auto grid">

                      <div class="flex justify-start mt-6">
    <button @click="modelOpen =!modelOpen"
    onclick="resetFunction()"
    class="mt-4 flex items-center justify-center py-2 space-x-2 tracking-wide transform px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple
    focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
        </svg>
        <span>Ajouter un article</span>        
    </button>
                    </div>                
            
    <form action="/contrats" method="POST">
    @csrf
<input type="hidden" name="type" value="{{ request('type') }}">
<div class="mx-auto bg-gray-300 divide-y divide-gray-200 flex flex-col shadow">
<ul
    aria-labelledBy="agenda-title"
    x-title="Sorting Demo"
    x-data="dragAndSortHandler(items)"
    @keydown.window.tab="usedKeyboard = true"
    @dragenter.stop.prevent="dropcheck++"
    @dragleave="dropcheck--;dropcheck || rePositionPlaceholder()"
    @dragover.stop.prevent
    @dragend="revertState()"
    @drop.stop.prevent="resetState()">
    <template x-for="(item, index) in items" :key="index">
        <li
            :x-ref="index"
            @dragstart="dragstart($event)"
            @dragend="$event.target.setAttribute('draggable', false)"
            @dragover="updateListOrder($event)"
            draggable="false"
            class="border-b border-transparent"
            :class="{
                'opacity-25': indexBeingDragged == index,
            }">
            <!-- Pointer events are disabled while dragging, otherwise drag events fire on child elements -->
            <div class="bg-white p-6 flex justify-between"
                 :class="{'pointer-events-none': indexBeingDragged}">
                <div class="flex flex-col">
                    <p class="text-gray-700 font-semibold" x-text="item.titre"></p>
                    <p class="text-gray-400 leading-snug italic text-sm" x-text="item.texte"></p>
                    <input type="hidden" x-bind:name="`classement[${item.id}]`" x-bind:value ="index">
                    <input type="hidden" x-bind:value ="item.id">
                    <input type="hidden" x-bind:value ="item.classement">
                </div>
                <div aria-haspopup="true">
                    <div class="flex px-1 py-1">

              @can('editer contrats')
                <div class="mr-1">
             
                <a
                  class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray"
                   x-bind:href="`/articles/${item.id}/edit`" 
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
            @endcan

                    <!-- this go into the button below @click.away.stop.prevent="closeAllContextMenus()" -->
                    <button
                        class="flex items-center justify-between px-1 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray"                    
                        type="button"
                        aria-label="Sorting menu"
                        @mousedown="setParentDraggable(event)"
                        @mouseup="openContextMenu($event)"
                        @click="openContextMenu($event)"
                        @keydown.space="openContextMenu($event)"
                        @keyup.stop.prevent
                        @keydown.arrow-down="highlightFirstContextButton($event)"
                        @keydown.tab="closeAllContextMenus()"
                        @dragover.stop.prevent
                        :class="{'focus:outline-none': !usedKeyboard}">
                        <svg
                            @click.stop
                            @dragover.stop.prevent
                            role="img"
                            class="w-4 h-4"
                            viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                 fill-rule="evenodd"
                                 d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                 clip-rule="evenodd"/>
                        </svg>
                    </button>

            @can('supprimer contrats')
                <div class="ml-1">
                        <form x-bind:action="`/articles/${item.id}`" method="POST">
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
            @endcan                    
</div>

                </div>
            </div>
        </li>
    </template>
</ul>
    
    
</div>
                      <div class="flex justify-end mt-6">
                        <button type="submit" class="px-3 py-2 text-sm tracking-wide text-white transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                            Sauvegarder
                        </button>
                    </div>
</form>


<!-- modal pour ajouter un compte bancaire -->
    <div x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
            <div x-cloak @click="modelOpen = false" x-show="modelOpen" 
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0" 
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100" 
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"
            ></div>

            <div x-cloak x-show="modelOpen" 
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block w-full max-w-xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl"
            >
                <div class="flex items-center justify-between space-x-4">
                    <h1 class="text-xl font-medium text-gray-800 ">Ajouter un article</h1>

                    <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                </div>

                <p class="mt-2 text-sm text-gray-500">
                    Ajouter un nouvel article au contrat
                </p>
        @if(!$errors->isEmpty())
        <p class="block h-160 px-4 py-4 rounded-lg mx-auto w-full mt-4 mb-2
        bg-red-200 text-red-600 text-xl"> Attention Il y'a des erreurs dans votre formulaire</p>
        <h4>{{$errors->first()}}</h4>
        @endif

                <form class="mt-5" action="/contrats/{{$contrat->id}}" method="POST" id="edit-form">
                  @method('PATCH')
                  @csrf

                    <div>
                        <label for="titre" class="block text-sm text-gray-700 dark:text-gray-200">
                        Titre de l'article (*)</label>
                        <input placeholder="Article X : Modalités de paiement" type="text" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40"
                        id="titre"
                        required
                        value="{{old('titre')}}"
                        name="titre">
                    @error('titre')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror                        
                    </div>

                    <div class="mt-4">
                        <label for="texte" class="block text-sm text-gray-700 dark:text-gray-200">
                        Texte de l'article (*)</label>
                        <textarea placeholder="Corps du texte de l'article" type="text" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40"
                        required
                        rows="10" 
                        id="texte"
                        value="{{old('texte')}}"                            
                        name="texte"></textarea>
                    @error('texte')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror                          
                    </div>
                                 
                    
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="px-3 py-2 text-sm tracking-wide text-white transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                            Ajouter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>            
<!-- modal pour ajouter un compte bancaire -->

</div>
</main>
 <script>
   const items = <?php echo $articles; ?> ;
function dragAndSortHandler(items) {
    return {
        // Keeps track of when we leave the dropzone
        // Otherwise child events will trigger @dragloave
        dropcheck: 0,
        usedKeyboard: false,
        originalIndexBeingDragged: null,
        indexBeingDragged: null,
        indexBeingDraggedOver: null,
        openedContextMenu: null,
        items: items,
        preDragOrder: items,
        dragstart(event) {
            if (this.openedContextMenu) {
                // Without this the drag will show the context menu
                return this.closeContextMenu()  
            }
            // Store a copy for when we drag out of range
            this.preDragOrder = [...this.items]
            // The index is continuously updated to reorder live and also keep a placeholder
            this.indexBeingDragged = event.target.getAttribute('x-ref')
            // The original is needed for then the drag leaves the container
            this.originalIndexBeingDragged = event.target.getAttribute('x-ref')
            // Not entirely sure this is needed but moz recommended it (?)
            event.dataTransfer.dropEffect = "copy"
        },
        updateListOrder(event) {
            // This fires every time you drag over another list item
            // It reorders the items array but maintains the placeholder 
            if (this.indexBeingDragged) {
                this.indexBeingDraggedOver = event.target.getAttribute('x-ref')
                let from = this.indexBeingDragged
                let to = this.indexBeingDraggedOver
                
                if (this.indexBeingDragged == to) return
                if (from == to) return

                this.move(from, to)
                this.indexBeingDragged = to
            }
        },
        // These are needed for the handle effect
        setParentDraggable(event) {
            event.target.closest('li').setAttribute('draggable', true)
        },
        setParentNotDraggable(event) {
            event.target.closest('li').setAttribute('draggable', false)
        },
        resetState() {
            this.dropcheck = 0
            this.indexBeingDragged = null
            this.preDragOrder = [...this.items]
            this.indexBeingDraggedOver = null
            this.originalIndexBeingDragged = null
        },
        // This acts as a cancelled event, when the item is dropped outside the container
        revertState() {
            this.items = this.preDragOrder.length ? this.preDragOrder : this.items
            this.resetState()
        },
        // Just repositions the placeholder when we move out of range of the container
        rePositionPlaceholder() {
            this.items = [...this.preDragOrder]
            this.indexBeingDragged = this.originalIndexBeingDragged
        },
        move(from, to) {

            let items = this.items
            if (to >= items.length) {
                let k = to - items.length + 1
                while (k--) {
                    items.push(undefined)
                }
            }
            items.splice(to, 0, items.splice(from, 1)[0])
            this.items = items
        },
        // THe rest are just for adding better UX to the context menu
        openContextMenu(event) {
            this.openedContextMenu = event.target.closest('li').__x_for_key
        },
        closeAllContextMenus() {    
            this.openedContextMenu = null
        },
        highlightFirstContextButton($event) {
            event.target.nextElementSibling.querySelector('button').focus()
        },
        highlightNextContextMenuItem(event) {
            event.target.closest('li').nextElementSibling.querySelector('button').focus()
        },
        highlightPreviousContextMenuItem(event) {
            event.target.closest('li').previousElementSibling.querySelector('button').focus()
        },
    }
}


  </script>
</x-master>            