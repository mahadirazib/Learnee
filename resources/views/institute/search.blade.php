<x-app-layout>

  @isset($message)
  <script>
      alert(" {{ $message }} ")
  </script>
  @endisset

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">

                  <!-- Institute Name and date joined -->
                  <div class="grid grid-cols-2 gap-4 mb-5">
                      <div>
                          <h1 class="font-bold text-4xl"> {{ $institute->name }} </h1>
                          <span class="text-sm text-gray-500"> Since: {{ $institute->created_at->format('j F, Y') }}
                          </span>
                      </div>
                      <div class="ms-auto">
                          @if ($is_admin)
                              <x-link-button
                              class="mt-4"
                              href="/">
                                  Add Image
                              </x-link-button>

                              <x-link-button
                              class="mt-4"
                              href="/">
                                  Faculty & Students
                              </x-link-button>

                              <x-link-button
                              class="mt-4"
                              href="{{ route('institute.edit-form', $institute->id) }}">
                                  Edit Info
                              </x-link-button>

                          @elseif($is_member)
                          
                              {{-- <x-link-button href="join">
                                  see details
                              </x-link-button> --}}
                              
                          @else
                              <x-link-button href="join">
                                  Join this Institute
                              </x-link-button>
                          @endif
                      </div>
                  </div>



                  <!-- Institute description -->
                  <div class="mt-5">
                      <div class="textWithLines">{{ $institute->description }} </div>
                  </div>


                  <!-- Institute contact info -->
                  <div class="mt-12">
                      <h2 class="font-bold text-2xl"> Institute Contact Info: </h2>
                      <div class="grid grid-cols-3 gap-4 mt-5">
  
                          <!-- Mobile Numbers -->
                          <div class="border-l-2 border-indigo-500 px-5">
                              @isset($institute->mobile_numbers)
                              
                                  <h3 class="text-gray-800 text-lg font-bold">Say hello:</h3>
                                  
                                  @foreach ($institute->mobile_numbers as $mobile)
                                      <p class="text-gray-700 text-base">
                                          {{ $mobile }}
                                      </p>
  
                                  @endforeach
  
                              @else
  
                                  <h3 class="text-gray-800 text-lg font-bold">Say hello:</h3>
                                  <p class="text-gray-700 text-base">No phone number was given </p>
                              @endisset
  
                          </div>
  
                          <div class="border-l-2 border-indigo-500 px-5">
  
                              @isset($institute->emails)
                              
                                  <h3 class="text-gray-800 text-lg font-bold">Get in touch:</h3>
                                  
                                  @foreach ($institute->emails as $email)
                                      <p class="text-gray-700 text-base">
                                          {{ $email }}
                                      </p>
  
                                  @endforeach
  
                              @else
  
                                  <h3 class="text-gray-800 text-lg font-bold">Get in touch:</h3>
                                  <p class="text-gray-700 text-base">No email was given </p>
                              @endisset
  
                          </div>
  
                          <div class="border-l-2 border-indigo-500 px-5">
  
                              <h3 class="text-gray-800 text-lg font-bold">Location:</h3>
  
                              @if(isset($institute->address_one) || isset($institute->address_two))
                                  @isset($institute->address_one)
                                      <p class="text-gray-700 text-base">
                                          {{ $institute->address_one }}
                                      </p>
                                  @endisset
  
                                  @isset($institute->address_two)
                                      <p class="text-gray-700 text-base">
                                          {{ $institute->address_two }}
                                      </p>
                                  @endisset
  
                              @else
                                  <p class="text-gray-700 text-base">No location was given </p>
                              @endisset
  
                          </div>
                      </div>
                  </div>



              </div>
          </div>
      </div>
  </div>
</x-app-layout>
