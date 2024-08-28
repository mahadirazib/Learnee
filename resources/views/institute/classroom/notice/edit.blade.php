<x-app-layout>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Institute Name and date joined -->
                    <div class="grid mb-5">
                        <div>
                            <h1 class="font-bold text-4xl"> {{ $institute->name }} </h1>
                            <span class="text-sm text-gray-500"> Since: {{ $institute->created_at->format('j F, Y') }}
                            </span>
                        </div>
                    </div>

                  <h1 class="font-semibold text-xl mb-8" style="margin: 0 0 15px"> Update your Notice: </h1>

                  <!-- Validation Errors -->
                  <x-auth-validation-errors class="mb-4" :errors="$errors" />

                  <form method="POST" id="myForm" action="{{ route('institute.notice.update', [$institute, $notice->id]) }}"
                      enctype="multipart/form-data">
                      @csrf


                      <div class="">
                          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                              <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                  <div class="bg-white border-b border-gray-200">


                                    <div class="">
                                        <x-label for="title" :value="__('Title for the notice')" />

                                        <x-input id="title" class="block mt-1 w-full" type="text"
                                            name="title" :value="old('name')" required 
                                            value="{{ $notice->title }}" />

                                    </div>


                                    <div class="mt-5">
                                      <label class="block font-medium text-sm text-gray-700"
                                          for="notice">Notice Body</label>
                                      <textarea 
                                          style="height: 200px;"
                                          name="notice" id="notice" type="textarea"
                                          class="px-3 py-2 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">{{ $notice->notice }}
                                        </textarea>
                                  </div>


                                  </div>
                              </div>
                          </div>
                      </div>


                      <!-- Register and cancel button -->
                      <div class="flex items-center justify-end mt-4">
                          <a class="underline text-sm text-gray-600 hover:text-gray-900"
                              href="{{ route('institute.notice.all', $institute) }}">
                              {{ __('Cancel?') }}
                          </a>

                          <x-button class="ml-4" id="submitButton">
                              {{ __('Update Notice') }}
                          </x-button>

                      </div>

                  </form>


              </div>
          </div>
      </div>
  </div>





</x-app-layout>
