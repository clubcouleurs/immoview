<x-layout>
      <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">

            <form action="/formulaire-concours" method="POST">
              @csrf
  <div class="-mx-3 md:flex mb-6">
    <div class="md:w-full px-3">
      <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-password">
        Nom et prénom de l'enfant
      </label>
      <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3" name="nomEnfant" type="text" placeholder="Nom & prénom" required value="{{old('nomEnfant')}}">
                      @error('nomEnfant')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror 
      </div>
  </div>

  <div class="-mx-3 md:flex mb-4">
    <div class="md:w-full px-3">
      <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-password">
        Nom et prénom du tuteur
      </label>
      <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3" name="nomTuteur" type="text" placeholder="Nom & prénom" required value="{{old('nomTuteur')}}">
                      @error('nomTuteur')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror 
    </div>
  </div>

  <div class="-mx-3 md:flex mb-4">
    <div class="md:w-full px-3">
      <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-password">
        Votre numéro de téléphone
      </label>
      <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3" name="mobile" type="text" placeholder="0608000000" maxlength="10" required value="{{old('mobile')}}">
                      @error('mobile')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror 
    </div>
  </div>
  <div class="-mx-3 md:flex mb-4">
    <div class="md:w-full px-3">
      <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-password">
        Adresse Email
      </label>
      <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3" name="email" type="text" placeholder="exemple@exemple.com" required value="{{old('email')}}">
                      @error('email')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror 
    </div>
  </div>

  <div class="-mx-3 md:flex mb-4">
    <div class="md:w-full px-3">
      <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-password">
        Adresse Postale
      </label>
      <textarea class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3" name="adresse" placeholder="" required>{{old('adresse')}}</textarea> 
                      @error('adresse')
                    <p class="block h-10 px-2 py-2 rounded-md w-full mt-2
                    bg-red-600 text-white font-bold"> Attention : {{ $message }}</p>
                    @enderror 
    </div>
  </div>
 
   <div class="-mx-3 md:flex mb-4">
    <div class="md:w-full px-3">
<button class="bg-blue-500 text-white font-bold py-2 px-4 rounded-full" type="submit">
  Envoyer
</button>

    </div>
  </div>
</form>
</div>
</main>
</x-layout>
