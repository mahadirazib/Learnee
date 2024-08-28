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
                          <h1 class="font-bold text-2xl text-indigo-500">
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


                <x-alert> </x-alert>

                <!-- Institute Notice -->
                <div class="grid grid-cols-3 gap-4 mb-5">
                  <div class="col-span-2">
                    <h2 class="font-bold text-4xl"> {{ $notice->title }} </h2>

                    <p class="font-normal text-sm">
                        Given at:
                        {{ $notice->created_at->format('j F, Y h:i A') }}
                    </p>

                    <p class="font-normal text-sm">
                      Given by:
                      <span class="text-base font-semibold"> 
                        <a href="{{ route('user.view', $notice->given_by) }}"> {{ $notice->name }} </a> 
                      </span>
                    </p>

                  </div>

                  <div>
                    <div>
                      @if ($is_admin)
                      <x-button-blank-link
                          class="bg-teal-600 float-end ms-3" 
                          href="{{ route('institute.department.classroom.notice.edit', [$classroom->institute, $classroom->department, $classroom->id, $notice]) }}">
                          Edit
                      </x-button-blank-link>
                      <form action="{{ route('institute.department.classroom.notice.delete', [$classroom->institute, $classroom->department, $classroom->id, $notice]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <x-button-blank-submit
                            class="bg-red-500 float-end ms-3" href="/">
                            Delete
                        </x-button-blank-submit>
                      </form>
                      @endif
                  </div>
                  </div>

                </div>

                <div class="mb-5">
                  <hr>
                </div>

                <div>
                  <p style="white-space: pre-wrap;">{{ $notice->notice }}
                  </p>
                  <a href="{{ route('institute.department.classroom.notice.list', [$classroom->institute, $classroom->department, $classroom->id]) }}" class="font-bold text-gray-600 hover:text-gray-800"> ❮ Back </a>
                </div>


              </div>
          </div>
      </div>
  </div>
</x-app-layout>
