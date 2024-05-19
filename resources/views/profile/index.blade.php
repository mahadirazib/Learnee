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

                        <div class="" >
    
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
            </div>
        </div>
    </div>


</x-app-layout>
