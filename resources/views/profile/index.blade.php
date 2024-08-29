<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">


                <div class="p-6 bg-white border-b border-gray-200 grid gap-4 grid-cols-2 ">

                    <div class="drop-shadow-md w-fit h-96 rounded-md overflow-hidden" >

                        @if (isset($user->image) && file_exists('storage/profile_pictures/'.$user->image))
                            <img 
                                class=""
                                src="{{ asset('storage/profile_pictures/'.$user->image) }}"
                                alt="Profile Picture">
                        @else
                            <img 
                                class=""
                                src="{{ asset('storage/default_images/pro_pic.jpg') }}"
                                alt="Profile Picture">
                        @endif
                        
                    </div>

                    <div class="grid gap-6 grid-rows-2" style="padding-left: 20px">

                        <div class=" leading-3" >
    
                            <h1 class="font-semibold text-xl"
                            style="font-size: 30px">
                                Name: {{ $user->name }}
                            </h1>
    
                            <p class=" font-normal text-sm">
                                Member since {{ $user->created_at->format('j F, Y') }}
                            </p>
    
                            <div class="grid grid-cols-2 font-normal text-sm mt-5">
                                <p> Email: </p>
                                <p> {{ $user->email }} </p>
                            </div>

                            <div class="grid grid-cols-2 font-normal text-sm mt-2">
                                <p>Mobile Number:</p>
                                
                                @isset($user->mobile_number)
                                    <p> {{ $user->mobile_number }} </p>
                                @else
                                    <p> Not Given </p>
                                @endisset
                            </div>

                            <div class="grid grid-cols-2 font-normal text-sm mt-2">
                                <p> Account type: </p>
                                <p> {{ $user->account_type }} </p>
                            </div>
    
                        </div>




                        <div>
                            <hr>

                            <h2 class="font-semibold text-base mt-4">
                                Profile Action:
                            </h2>

                            <div class="mt-2">

                                <x-button-blank-link 
                                    style="background-color: rgb(46, 48, 51); margin:10px 20px 0 0" 
                                    href="{{ route('profile.edit', $user->id) }}" >

                                    {{ __('Edit Informations') }}
                                    
                                </x-button-blank-link>

                                <x-button-blank-submit 
                                    style="background-color: rgb(62, 72, 70); margin:10px 20px 0 0" 
                                    href="{{ route('profile.index') }}" >

                                    {{ __('Deactivate Account') }}

                                </x-button-blank-submit>

                                <x-button-blank-submit 
                                    style="background-color: red; margin:10px 0 0 0" 
                                    href="{{ route('profile.destroy', $user) }}" >

                                    {{ __('Delete Account') }}

                                </x-button-blank-submit>

                            </div>

                        </div>

                    </div>



                </div>

                <div>
                  @if(isset($posts) && $posts != null && count($posts))
                    <div class="p-10 bg-gray-200">
                      @foreach ($posts as $post)

                      <div class="mb-5">
  
                        <div>
  
                          <div class="grid grid-cols-3">
                            <h2 class=" col-span-2 text-lg font-bold"> {{ $post->title }} </h2>
                            <div class="text-xs ms-auto">
                                {{ $post->created_at->format('j F, Y h:i A') }}
                            </div>
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
