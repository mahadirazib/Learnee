<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    Logged in as <br>
                    <span class="font-bold text-xl"> {{ Auth::user()->name }} </span> &lpar;{{ Auth::user()->account_type }}&rpar;

                    <div>
                      <div class="">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="bg-white">

                              <x-alert></x-alert>
                              <x-auth-validation-errors class="mb-4" :errors="$errors" />

                              <form action="{{ route('public.post.create') }}" 
                              method="post"
                              enctype="multipart/form-data"
                              class="mt-5 mb-5">
                                @csrf

                                <div class="grid grid-cols-2 gap-4">
  
                                  <div>
                                    <div class="">
                                      <x-label for="title" :value="__('Title for the Blog')" />
                                      <x-input id="title" class="block mt-1 w-full" type="text"
                                          name="title" :value="old('name')" required />
                                    </div>
  
                                    <div class="mt-5">
                                      <label class="block font-medium text-sm text-gray-700">
                                          Files:
                                      </label>
                                      <div
                                          class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md text-center">
  
                                          <div class="space-y-1 text-center">
  
                                              <!-- image gellary -->
                                              <div class="">
  
                                                  <x-label for="files" :value="__('Select Files')"
                                                      class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500" />
  
                                                  <x-input onchange="FileDetails()" id="files"
                                                      class="sr-only" type="file" name="files[]"
                                                      multiple />
  
                                                  <div id="fileInfo"> 
                                                    <p class="text-xs text-black">
                                                      supported types: pdf, doc, docx, csv, txt, png, jpg, jpeg, gif, zip <br>
                                                      max size per file 2MB or 2048KB
                                                    </p>
                                                  </div>
  
                                                  <script>
                                                      function FileDetails() {
  
                                                          var fi = document.getElementById('files');
  
                                                          if (fi.files.length > 0) {
                                                              // the total file count.
                                                              let fileInfoHtml = fi.files.length + " Files selected ( <span class='text-sm text-gray-600'>";
  
                                                              // run a loop to get each selected file name.
                                                              for (var i = 0; i <= fi.files.length - 1; i++) {
                                                                  if (i > 3) {
                                                                      fileInfoHtml += "..."
                                                                      break;
                                                                  }
  
                                                                  fileInfoHtml += fi.files.item(i).name.slice(0, 5) + '..., ';
                                                              }
  
                                                              fileInfoHtml += "</span>)";
  
                                                              document.querySelector('#fileInfo').innerHTML = fileInfoHtml;
                                                              
  
                                                          }
  
                                                      }
                                                  </script>
  
                                              </div>
                                          </div>
                                      </div>
  
                                    </div>
                                  </div>
  
  
                                  <div class="">
                                    <label class="block font-medium text-sm text-gray-700" for="post">
                                      What is on your mind
                                    </label>
                                    <textarea style="height: 180px;" name="post" id="post" type="textarea"
                                        class="px-3 py-2 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full"></textarea>
                                  </div>
  
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                  <x-button type="submit" class="ml-4" id="submitButton">
                                      {{ __('Share Post') }}
                                  </x-button>
                                </div>

                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <hr>

                  @if(isset($posts) && $posts != null && count($posts))
                    <div class="p-10 bg-gray-100">
                      @foreach ($posts as $post)

                      <div class="mb-5">

                        <div class="grid grid-cols-2">
                          <h3 class="text-base font-semibold text-indigo-600"> 
                            <span class="text-gray-700">Published By </span>
                            <a href="{{ route('user.view', $post->user) }}"> {{ $post->user_name }} </a> 
                          </h3>
                          <div class="text-xs ms-auto">
                            {{ $post->created_at->format('j F, Y h:i A') }}
                          </div>
                        </div>
  
                        <div>
  
                          <div>
                            <h2 class="text-lg font-bold"> {{ $post->title }} </h2>
                          </div>
  
                          @isset($post->post)
                            <div class="mt-2">
                              <div class="textWithLines" class="description" data-description="{{ $post->post }}">{{ Str::limit($post->post, 160) }} <span class="text-gray-600 font-semibold text-sm cursor-pointer" onclick="seeMore(this)">See more</span>
                              </div>
                            </div>
                          @endisset
  
                        </div>
  
                        <div>
                          @isset($post->files)
                            <div class="grid grid-cols-6 mt-3">
                              @foreach($post->files as $file)
                                @if (file_exists('storage/public_post_files/' . $file[1]))
  
                                  @php
                                    $fileType = app('App\Http\Controllers\PublicPostController')->getFileType($file[1]);
                                  @endphp
                                  
  
                                  @if (str_contains($fileType, 'image'))
                                    <div class="seeFullImage cursor-pointer overflow-hidden inline-block rounded-md bg-slate-200" style="height: 50px; width: 100px">
                                      <img src="{{ asset('storage/public_post_files/' . $file[1]) }}" alt="{{ $file[0] }}">
                                    </div>
                                  @else
                                    <div>
                                      <a href="{{ asset('storage/public_post_files/' . $file[1]) }}" target="_blank" download="{{ $file[0] }}"
                                      class="overflow-hidden rounded-md bg-gray-400 flex justify-center items-center" style="height: 50px; width: 100px">
                                        @php
                                          $original_name = $file[0];
                                          if (strlen($original_name)>7) {
                                            $name_arr = explode('.', $file[0]);
                                            $first_four_char = substr($original_name, 0, 5);
                                            $final_file_name = $first_four_char . ".." . end($name_arr);
                                          }else {
                                            $final_file_name = $original_name;
                                          }
                                        @endphp
                                        {{-- {{ $file[0] }} --}}
                                        {{ $final_file_name }}
                                      </a>
                                    </div>
                                  @endif
  
                                @endif
                              @endforeach
                            </div>
                          @endisset
                        </div>

                      </div>
                      
                      <div class="w-100 h-1 mb-5 bg-white"></div>

                      @endforeach

                      <div>
                        {{ $posts->links() }}
                      </div>

                    </div>
                  @else
                    <div class="p-10 bg-gray-200">
                      <h2 class="font-bold">No Post Found.</h2>
                    </div>
                  @endif

                </div>
            </div>
        </div>
    </div>


    <script>
      
      function seeMore(ele){
        fullDescription = ele.parentElement.dataset.description + " ";
        descriptionBox = ele.parentElement;
        let spanButton = document.createElement('span');
        spanButton.setAttribute('onclick', 'seeLess(this)')
        spanButton.classList.add('text-gray-600', 'font-semibold', 'text-sm', 'cursor-pointer');
        spanButton.innerText = 'See less';
        descriptionBox.innerHTML = fullDescription + "    ";
        descriptionBox.appendChild(spanButton);
      }
  
      function seeLess(ele){
          fullDescription = ele.parentElement.dataset.description + " ";
          var description = fullDescription.substring(0, 150);
          ele.parentElement.innerHTML = description + "... " +'<span class="text-gray-600 font-semibold text-sm cursor-pointer" onclick="seeMore(this)">See more</span>'
      }
  
    </script>


    <style>
      #fullpage {
        display: none;
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-size: contain;
        background-repeat: no-repeat no-repeat;
        background-position: center center;
        background-color: rgba(1, 3, 17, 0.5);
      }
    </style>

    <div id="fullpage" onclick="this.style.display='none';"></div>

    <script>
      function getPics() {} //just for this demo
      const imgs = document.querySelectorAll('.seeFullImage img');
      const fullPage = document.querySelector('#fullpage');

      imgs.forEach(img => {
        img.addEventListener('click', function() {
          fullPage.style.backgroundImage = 'url(' + img.src + ')';
          fullPage.style.display = 'block';
          fullPage.innerHTML = `
            <div class="opacity-25 hover:opacity-100" style="width: fit-content; margin: 250px auto;" >
              <a class="p-5 rounded bg-gray-700 text-white cursor-pointer" href="${ img.src }" download>
              Download &darr;
              </a>
            </div>
            `
        });
      });
    </script>









</x-app-layout>
