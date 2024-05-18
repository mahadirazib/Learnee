<x-app-layout>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">

                <!-- Institute Name and date joined -->
                <div class="grid mb-5">
                  <div>
                      <h1 class="font-bold text-4xl">{{$department->name}}</h1> 
                      <h2 class="font-bold text-2xl ">of <a class="text-lime-600" href="{{ route('institute.view-single', $department->institute ) }}">{{ $department->institute_name }}</a> </h2>
                      <span class="text-sm text-gray-500"> Department created: {{ $department->created_at->format('j F, Y') }}
                      </span>
                  </div>
                </div>


                <x-alert> </x-alert>

                <div class="mb-5">
                  <hr>
                </div>

                  <!-- Institute Notice -->
                  <div class="grid grid-cols-3 gap-4 mb-5">
                    <div class="col-span-2">
                      <h2 class="font-bold text-2xl"> {{ $notice->title }} </h2>

                      <p class="font-normal text-sm">
                          Given at:
                          {{ $notice->created_at->format('j F, Y h:i A') }}
                      </p>

                      <p class="font-normal text-sm">
                        Given by:
                        <span class="text-base font-semibold"> 
                          <a href="/"> {{ $notice->name }} </a> 
                        </span>
                      </p>

                    </div>

                    <div>
                      <div>
                        @if ($is_admin)
                        <x-button-blank-link
                            class="bg-teal-600 float-end ms-3" 
                            href="{{ route('institute.department.notice.edit-form', [$department->institute, $department, $notice]) }}">
                            Edit
                        </x-button-blank-link>
                        <form action="{{ route('institute.department.notice.delete', [$department->institute, $department, $notice]) }}" method="POST">
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
                    <a href="{{ route('institute.department.notice.all', [$department->institute, $department]) }}" class="font-bold text-gray-600 hover:text-gray-800"> ❮ Back </a>
                  </div>


              </div>
          </div>
      </div>
  </div>
</x-app-layout>
