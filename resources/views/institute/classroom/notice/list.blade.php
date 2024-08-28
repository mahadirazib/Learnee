<x-app-layout>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                <!-- Institute Name and date created -->
                <div class="grid grid-cols-3 mb-5">
                    <div class="col-span-2">
                        <h1 class="font-bold text-xl inline">
                            <a href="{{ route('institute.department.view-single', [$classroom->institute, $classroom->department] ) }}" class="text-gray-600 hover:text-blue-600">
                                {{ $classroom->department_name }}
                            </a>
                        </h1>
                        <h2 class="font-bold text-xl text-gray-600 inline">of <a class="hover:text-lime-600"
                            href="{{ route('institute.view-single', $classroom->institute) }}">{{ $classroom->institute_name }}</a>
                        </h2>
                        <div>
                            <h1 class="font-bold text-4xl text-indigo-500">
                                <a href="{{ route('institute.department.classroom.view', [$classroom->institute, $classroom->department, $classroom->id] ) }}" class="">
                                    {{ $classroom->name }}
                                </a>
                            </h1>
                            <span class="text-sm text-gray-500"> Class created:
                                {{ $classroom->created_at->format('j F, Y') }}
                            </span>
                        </div>
                    </div>

                    <div class="ms-auto">
                        @if ($is_admin)
                        <x-button-blank-link class="outline outline-2 text-gray-800 bg-gray-800 ms-auto" href="{{route('institute.department.classroom.notice.create', [$classroom->institute, $classroom->department, $classroom->id])}}">
                            Add new Notice
                        </x-button-blank-link>
                        @endif
                    </div>

                </div>


                <div class="mt-5 mb-5">
                <hr>
                </div>


                <x-alert> </x-alert>


                <!-- Institute Notice -->
                <div class="mt-5">

                    <div class="grid grid-cols-2 gap-4">
                    <h2 class="font-bold text-2xl">All Notices: </h2>
                    </div>
                    
                    <div class="mt-5 mb-5 grid grid-cols-2 gap-4">
                        @if (count($notices))
                            @foreach ($notices as $notice)
                                {{-- <a href="{{ route('institute.notice.single', [$institute->id, $notice->id]) }}"> --}}
                                    <div class="max-w-7xl mx-auto">
                                        <div class="relative group">
                                            <div class="relative leading-none px-7 py-6 bg-gray-100 hover:text-slate-600 hover:bg-gray-200 transition duration-200 ring-1 ring-gray-900/5 rounded-lg flex items-top justify-start space-x-6 ">
                                                <div class="space-y-2">
                                                    <h3 class="text-black font-bold">
                                                        {{ Str::limit($notice->title, 40) }}
                                                    </h3>
                                                    <p class="text-gray-600">
                                                    {{ Str::limit($notice->notice, 100) }}
                                                    </p>
                                                    <div class="grid grid-cols-2 gap-4 ">
                                                    <div class="content-center">
                                                        <a href="{{ route('institute.department.classroom.notice.view', [ $classroom->institute, $classroom->department, $classroom->id, $notice->id]) }}"
                                                            class="content-center">
                                                            <p
                                                                class="block text-indigo-400 font-bold  hover:text-slate-800 transition duration-200">
                                                                Details →
                                                            </p>
                                                        </a>
                                                    </div>

                                                    @if ($is_admin)
                                                        
                                                    <div>
                                                        <x-button-blank-link
                                                            class="bg-teal-600 float-end ms-3" 
                                                            href="{{ route('institute.department.classroom.notice.edit', [ $classroom->institute, $classroom->department, $classroom->id, $notice->id]) }}">
                                                            Edit
                                                        </x-button-blank-link>
                                                        <form action="{{ route('institute.department.classroom.notice.delete', [ $classroom->institute, $classroom->department, $classroom->id, $notice->id]) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <x-button-blank-submit
                                                                class="bg-red-500 float-end ms-3" href="/">
                                                                Delete
                                                            </x-button-blank-submit>
                                                        </form>
                                                    </div>
                                                    
                                                    @endif


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {{-- </a> --}}
                            @endforeach
                        @else
                            <h3 class="text-black font-bold">
                                No Notice Found
                            </h3>
                        @endif
                    </div>

                    <div>
                        {{ $notices->links() }}
                    </div>

                </div>

                <div>
                <a href="{{ route('institute.department.classroom.view', [$classroom->institute, $classroom->department, $classroom->id]) }}" class="font-bold text-gray-600 hover:text-gray-800"> ❮ Back </a>
                </div>

                  
              </div>


          </div>
      </div>
  </div>
</div>
</x-app-layout>
