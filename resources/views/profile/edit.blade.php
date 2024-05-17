<x-app-layout>
    <x-auth-card>

        <x-slot name="logo">

        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('profile.update', $user) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')


            <div class="drop-shadow-md rounded-md overflow-hidden" style="width: 100%; height:300px; margin: 10px auto 20px;">

                <img 
                    class=""
                    src="{{ asset('storage/profile_pictures/'.$user->image) }}"
                    alt="Profile Picture">
                
            </div>

            <div>
                <x-label for="profile_picture" :value="__('Change Profile Picture')" />

                <x-input id="profile_picture" class="block mt-1 w-full rounded-md" type="file" name="profile_picture" />
            </div>

            <!-- Name -->
            <div class="mt-4">
                <x-label for="name" :value="__('Change Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                    autofocus value="{{ $user->name }}" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Change Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required 
                value="{{ $user->email }}" />
            </div>



            {{-- <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Change Password')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required />
            </div> --}}



            <!-- Register and cancel button -->
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('profile.index') }}">
                    {{ __('Cancel?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Update') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-app-layout>
