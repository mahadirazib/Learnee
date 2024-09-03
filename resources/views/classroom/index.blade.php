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
                  class="mt-4 ms-3"
                  href="{{ route('classroom.search') }}">
                      Search Classroom
                  </x-link-button>

                </div>

                <hr>

                
                <!-- Administrative Role -->
                
                <div class="mt-10">
                  <h2 class="font-bold text-2xl mb-4">Administrative role:</h2>
                  <hr>
                  
                  <div class="grid grid-cols-2 gap-4 mt-5 mb-20">
                    @if(isset($admin_access) &&  $admin_access != null && count($admin_access)>0)
                      @foreach ($admin_access as $classroom)
                        <div>
                          <a href="{{ route('classroom.dashboard', [ $classroom->institute, $classroom->department, $classroom->id]) }}">
                            <div class="max-w-7xl mx-auto">
                              <div class="relative group">
                                <div class="relative leading-none px-7 py-6 bg-gray-100 hover:text-slate-600 hover:bg-gray-200 transition duration-200 ring-1 ring-gray-900/5 rounded-lg flex items-top justify-start space-x-6 ">
                                  <svg class="w-8 h-8 text-indigo-600" fill="none">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 6.75C6.75 5.64543 7.64543 4.75 8.75 4.75H15.25C16.3546 4.75 17.25 5.64543 17.25 6.75V19.25L12 14.75L6.75 19.25V6.75Z"></path>
                                  </svg>
                                  <div class="space-y-2">
                                    <h3 class="text-black font-bold">
                                      {{ Str::limit($classroom->name, 40) }}
                                    </h3>
                                    <p class="text-sm text-gray-600 leading-4">
                                      Institute: {{ Str::limit($classroom->institute_name, 40) }} <br>
                                      Department: {{ Str::limit($classroom->department_name, 40) }}
                                    </p>
                                    <p class="text-gray-600">
                                      {{ Str::limit($classroom->description, 100) }}
                                    </p>
                                    <p class="block text-indigo-400 hover:text-slate-600 transition duration-200 font-bold"> Details → </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </a>
      
                        </div>
                      @endforeach

                      <div class="col-span-2">
                        {{ $admin_access->links() }}
                      </div>
                    @else
                      <h3 class="text-black font-bold">
                        No Classroom Found
                      </h3>
                    @endif
                        
                  </div>
                </div>




                <!-- General Faculty Role -->
                <div>
                  <h2 class="font-bold text-2xl mb-4">General role:</h2>
                  <hr>
  
                  <div class="grid grid-cols-2 gap-4 mt-5 mb-20">
  
                    @if(isset($general_access) &&  $general_access != null && count($general_access)>0)
                      @foreach ($general_access as $classroom)
                        <div>
                          <a href="{{ route('classroom.dashboard', [ $classroom->institute, $classroom->department, $classroom->id]) }}">
                            <div class="max-w-7xl mx-auto">
                              <div class="relative group">
                                <div class="relative leading-none px-7 py-6 bg-gray-100 hover:text-slate-600 hover:bg-gray-200 transition duration-200 ring-1 ring-gray-900/5 rounded-lg flex items-top justify-start space-x-6 ">
                                  <svg class="w-8 h-8 text-indigo-600" fill="none">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 6.75C6.75 5.64543 7.64543 4.75 8.75 4.75H15.25C16.3546 4.75 17.25 5.64543 17.25 6.75V19.25L12 14.75L6.75 19.25V6.75Z"></path>
                                  </svg>
                                  <div class="space-y-2">
                                    <h3 class="text-black font-bold">
                                      {{ Str::limit($classroom->name, 40) }}
                                    </h3>
                                    <p class="text-sm text-gray-600 leading-4">
                                      Institute: {{ Str::limit($classroom->institute_name, 40) }} <br>
                                      Department: {{ Str::limit($classroom->department_name, 40) }}
                                    </p>
                                    <p class="text-gray-600">
                                      {{ Str::limit($classroom->description, 100) }}
                                    </p>
                                    <p class="block text-indigo-400 hover:text-slate-600 transition duration-200 font-bold"> Details → </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </a>
      
                        </div>
                      @endforeach

                      <div class="col-span-2">
                        {{ $general_access->links() }}
                      </div>

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
