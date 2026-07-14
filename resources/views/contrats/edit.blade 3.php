<x-master>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <div class="flex justify-between">


                <form class="mt-5" action="/contrats" method="POST" id="edit-form">
                    @csrf
                    
  <div class="mt-8 mx-auto bg-gray-300 divide-y divide-gray-200 flex flex-col shadow" 
    x-data="articles()"
    @drop.prevent='onDrop($event)'
    @dragover.prevent='onDragover($event)'>

    <template x-for="(article, index) in articles" :key='index'>
      <div 
        draggable="true"
        @dragstart='onDragstart(index)'
        @dragend='onDragend()'
        :class="{'opacity-25': draggingIndex === index, 'pt-20': droppingIndex == index && draggingIndex > index, 'pb-20': droppingIndex == index && draggingIndex < index}"
        class="flex flex-row relative cursor-move transition-spacing duration-300 ease-in-out">

        <div class="bg-white w-full flex">
          <div class="w-9 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
            </svg>
          </div>

          <div class="py-2 px-4 flex gap-x-4 items-center">
            
            <div class="flex flex-col">
              <p class="text-gray-700 font-semibold" x-text="article.titre"></p>
              <p class="text-gray-400 leading-snug italic text-sm" x-text="article.texte"></p>
              <p class="text-gray-400 leading-snug italic text-sm" x-text="article.id"></p>
              <input type="text" x-bind:id="article.id" x-bind:name="article.id" value ="">
            </div>
          </div>
        </div>

        <div class="absolute inset-0 opacity-60 cursor-move transition-spacing duration-300 ease-in-out z-10" 
          x-show.transition="draggingIndex !== null" @dragenter.prevent="onDragenter(event, index)" @dragleave="onDragleave">
        </div>

        <div :class="{'h-20 top-0 bg-gray-300': droppingIndex === index && draggingIndex > index, 'h-20 bottom-0 bg-gray-300': droppingIndex === index && draggingIndex < index}" class="absolute h-0 w-full bg-gray-300 transition-spacing duration-300 ease-in-out opacity-50">
        </div>
      </div>
    </template>
  </div>
                      <div class="flex justify-end mt-6">
                        <button id="edit-button" type="submit" class="px-3 py-2 text-sm tracking-wide text-white transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                            Ajouter
                        </button>
                    </div>
</form>
  <script>
    function articles(){
      return {
        draggingIndex: null,
        droppingIndex: null,

        articles: <?php echo $articles; ?> ,
        onDrop(event) {
            alert(this.draggingIndex) ;
          document.getElementById("127").value = this.droppingIndex ;
          // rearrange the array by inserting the dropped element
          if (this.draggingIndex !== null && this.droppingIndex !== null) {
            if (this.draggingIndex < this.droppingIndex) {

              this.articles = [
                ...this.articles.slice(0, this.draggingIndex),
                ...this.articles.slice(this.draggingIndex + 1, this.droppingIndex + 1),
                this.articles[this.draggingIndex],
                ...this.articles.slice(this.droppingIndex + 1)
              ]; 
            } else if(this.draggingIndex == this.droppingIndex) {
              // do nothing if the drag and drop index is the same
            } else {               
              this.articles = [
                ...this.articles.slice(0, this.droppingIndex),
                this.articles[this.draggingIndex],
                ...this.articles.slice(this.droppingIndex, this.draggingIndex),
                ...this.articles.slice(this.draggingIndex + 1)
              ];
            }
          }; 
          alert(this.draggingIndex) ;
        },
        onDragover(event) {
            alert(this.draggingIndex) ;
          event.dataTransfer.dropEffect = "move";
        },
        onDragstart(index) {
          this.draggingIndex = index;
        },
        onDragend() {
            alert(this.draggingIndex) ;
          this.draggingIndex = null;
          this.droppingIndex = null;
        },
        onDragenter(event, index) {
            alert(this.draggingIndex) ;
          event.preventDefault();
          this.droppingIndex = index;
        },
        onDragleave(index) {
            alert(this.draggingIndex) ;
          if (index === this.droppingIndex) {
            this.droppingIndex = null;
          }
        },
      }
    }


  </script>
</div>
</div>
</main>

</x-master>            