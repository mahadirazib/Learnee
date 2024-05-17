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


                <div class="mb-5">
                  <x-link-button
                  class="mt-4"
                  href="{{ route('institute.create-form') }}">
                      Create an Institute
                  </x-link-button>

                  <x-link-button
                  class="mt-4 ms-3"
                  href="{{ route('global.institute.search') }}">
                      Search Institute
                  </x-link-button>
                </div>

                <hr>

                
                <!-- Administrative Role -->
                <div class="mt-10">
                  <h2 class="font-bold text-2xl mb-4">Administrative role:</h2>
                  <hr>
  
                  <div class="grid grid-cols-2 gap-4 mt-5 mb-20">
  
                    @if(isset($administrative_access) &&  $administrative_access != null)
                      @foreach ($administrative_access as $institute)
                        <div>
                          <a href="{{ route('institute.view-single', $institute->id) }}">
                            <div class="max-w-7xl mx-auto">
                              <div class="relative group">
                                <div class="relative leading-none px-7 py-6 bg-gray-100 hover:text-slate-600 hover:bg-gray-200 transition duration-200 ring-1 ring-gray-900/5 rounded-lg flex items-top justify-start space-x-6 ">
                                  <svg class="w-8 h-8 text-indigo-600" fill="none">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 6.75C6.75 5.64543 7.64543 4.75 8.75 4.75H15.25C16.3546 4.75 17.25 5.64543 17.25 6.75V19.25L12 14.75L6.75 19.25V6.75Z"></path>
                                  </svg>
                                  <div class="space-y-2">
                                    <h3 class="text-black font-bold">
                                      {{ Str::limit($institute->name, 40) }}
                                    </h3>
                                    <p class="text-gray-600">
                                      {{ Str::limit($institute->description, 100) }}
                                    </p>
                                    <p class="block text-indigo-400 hover:text-slate-600 transition duration-200"> Details → </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </a>
      
                        </div>
                      @endforeach
                    @else
                      <h3 class="text-black font-bold">
                        No institute Found
                      </h3>
                    @endisset
  
                  </div>
                </div>



                <!-- General Faculty Role -->
                <div>
                  <h2 class="font-bold text-2xl mb-4">General Faculty role:</h2>
                  <hr>
  
                  <div class="grid grid-cols-2 gap-4 mt-5 mb-20">
  
                    @if(isset($general_access) &&  $general_access != null)
                      @foreach ($general_access as $institute)
                        <div>
                          <a href="{{ route('institute.view-single', $institute->id) }}">
                            <div class="max-w-7xl mx-auto">
                              <div class="relative group">
                                <div class="relative leading-none px-7 py-6 bg-gray-100 hover:text-slate-600 hover:bg-gray-200 transition duration-200 ring-1 ring-gray-900/5 rounded-lg flex items-top justify-start space-x-6 ">
                                  <svg class="w-8 h-8 text-indigo-600" fill="none">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 6.75C6.75 5.64543 7.64543 4.75 8.75 4.75H15.25C16.3546 4.75 17.25 5.64543 17.25 6.75V19.25L12 14.75L6.75 19.25V6.75Z"></path>
                                  </svg>
                                  <div class="space-y-2">
                                    <h3 class="text-black font-bold">
                                      {{ Str::limit($institute->name, 40) }}
                                    </h3>
                                    <p class="text-gray-600">
                                      {{ Str::limit($institute->description, 100) }}
                                    </p>
                                    <p class="block text-indigo-400 hover:text-slate-600 transition duration-200"> Details → </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </a>
      
                        </div>
                      @endforeach
                    @else
                      <h3 class="text-black font-bold">
                        No institute Found
                      </h3>
                    @endisset
  
  
  
  
                  </div>
                </div>


              </div>
          </div>
      </div>
  </div>
</x-app-layout>
