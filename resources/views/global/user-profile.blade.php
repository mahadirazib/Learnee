<x-app-layout>


  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200 grid gap-4 grid-cols-3 ">

                  <div class="drop-shadow-md rounded-md overflow-hidden mr-10 w-fit h-60">

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

                  <div class="col-span-2 content-center" >

                      <h1 class="font-semibold text-xl"
                      style="font-size: 30px">
                          Name: {{ $user->name }}
                      </h1>

                      <p class="font-normal text-sm">
                          Member since: <br>
                          {{ $user->created_at }}
                      </p>

                      <p class="font-normal text-sm">
                          Email:
                          {{ $user->email }}
                      </p>

                      <p class="font-normal text-sm">
                          Account type:
                          {{ $user->account_type }}
                      </p>

                  </div>


              </div>
          </div>
      </div>
  </div>


</x-app-layout>
