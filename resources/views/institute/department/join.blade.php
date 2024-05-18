<x-app-layout>


  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">


          <!-- Validation Errors -->
          <x-auth-validation-errors class="mb-4" :errors="$errors" />

          <form method="POST" 
            class="mx-auto my-20 max-w-lg"
            action="{{ route('institute.department.join.confirm', [$institute, $department]) }}">
            @csrf


            <div class="mb-4 text-sm text-gray-600">
              {{ __('Please enter the passkeys to join this department.') }}
            </div>

            <!-- passkey -->
            <div>
              <x-label for="passkey" :value="__('Passkey: ')" />

              <x-input id="passkey" class="block mt-1 w-full"
                      type="text"
                      name="passkey"
                      required />
            </div>

            <div class="flex justify-end mt-4">
              <x-button>
                {{ __('Confirm') }}
              </x-button>
            </div>
          </form>


        </div>
      </div>
    </div>
  </div>

</x-app-layout>
