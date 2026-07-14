<x-master>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">

        @if(!$errors->isEmpty())
        <p class="block h-160 px-4 py-4 rounded-lg mx-auto w-full mt-4
        bg-red-200 text-red-600 text-xl"> Attention Il y'a des erreurs dans votre formulaire</p>
        <!-- <h4>{{$errors->first()}}</h4> -->
        @endif
        

</div>
</main>
</x-master>