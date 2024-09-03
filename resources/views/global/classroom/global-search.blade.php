<x-app-layout>


  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">


                <div class="max-w-lg mx-auto">
                  <x-search-box> 
                    @if(isset($query) && $query != null)
                      {{ __($query) }} 
                    @endisset
                  </x-search-box>
                  @if(isset($query) && $query != null)
                  <div class="">
                    <p class="text-gray-400 text-sm"> Search result for {{ $query }} </p>
                  </div>
                  @endisset
                </div>


                <!-- searched Institute -->
                @if(isset($search_classroom) &&  $search_classroom != null)
                <div class="mb-20">
                  <h2 class="font-bold text-2xl mb-4">Search Result:</h2> 
                  <hr>
                  <div class="grid grid-cols-2 gap-4 mt-5">
                    @foreach ($search_classroom as $classroom)
                      <div>
                        <a href="{{ route('institute.department.classroom.view', [ $classroom->institute, $classroom->department, $classroom->id]) }}">
                          <div class="max-w-7xl mx-auto">
                            <div class="relative group">
                              <div class="relative leading-none px-7 py-6 bg-gray-100 hover:text-slate-600 hover:bg-gray-200 transition duration-200 ring-1 ring-gray-900/5 rounded-lg flex items-top justify-start space-x-6 ">
                                <svg class="w-10 h-8 text-indigo-600" fill="none">
                                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" ></path>
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
                                  <p class="block text-indigo-400 hover:text-slate-600 transition duration-200"> Details → </p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </a>
                      </div>
                    @endforeach
                  </div>

                  @if (count($search_classroom) <= 0)
                    <p class="font-bold text-lg mb-4"> No results Found </p> 
                  @endif

                </div>
                @else
                  <div class="m-20 text-center">
                    <h2 class="font-bold text-2xl mb-4">
                      Search by name of a classroom.
                    </h2> 
                  </div>
                @endif



              </div>
          </div>
      </div>
  </div>
</x-app-layout>
