<x-app-layout>

    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
      var emails = [];
      var phone_numbers = [];
      var passkeys = [];
    </script>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">


            <div class="grid grid-cols-2">
                <div>
                    <h1 class="font-semibold text-xl mb-8" style="margin: 0 0 15px"> Update your Institute information: </h1>
                </div>

                <div class="ms-auto">
                    <x-link-button class="mt-4" href="/">
                        Change Images
                    </x-link-button>

                    <x-link-button class="mt-4 ms-4" href="{{ route('institute.admin.list', $institute) }}">
                        Change Admin
                    </x-link-button>
                </div>

            </div>

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" id="myForm" action="{{ route('institute.update', $institute) }}"
                enctype="multipart/form-data">
              @csrf
              {{-- @method('PUT') --}}


              <div class="">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                  <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white border-b border-gray-200">


                      <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">

                        <div>
                            <div class="">
                              <x-label for="name" :value="__('Name of the Institute')" />
    
                              <x-input id="name" class="block mt-1 w-full" type="text" 
                                name="name" :value="old('name')" required
                                value="{{ $institute->name }}"  />
                            </div>


                            <div class="mt-4">
                                <x-label for="emailInput" :value="__('Email Address')" />
      
                                <x-input id="emailInput" class="block mt-1 w-full" type="email"
                                    name=""  />
      
                                <input type="hidden" name=" " id="email">
      
                                <div class="flex flex-wrap gap-2 mt-3" id="emailContainer">
                                  <!-- Emails will be added here -->
                                  @isset($institute->emails)
                                    @foreach ($institute->emails as $email)
                                        <div class="bg-gray-200 text-black px-3 py-1 rounded cursor-pointer hover:bg-gray-700 hover:text-white">
                                            {{ $email }}
                                            <input type="hidden" name="emails[]" value="{{ $email }}">
                                        </div>
                                    @endforeach
                                  @endisset
                                  
                                </div>
      
                            </div>
      
                        </div>


                        <div>
                            <label class="block font-medium text-sm text-gray-700"
                                for="description">Description</label>
                            <textarea style="height: 200px;" name="description" id="description" type="textarea" required
                                class="px-3 py-2 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">{{ $institute->description }}</textarea>
                        </div>

                      </div>

                      <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mt-5">


                        <div class="">
                          <x-label for="phoneInput" :value="__('Mobile Numbers')" />

                          <x-input id="phoneInput" class="block mt-1 w-full" type="text"
                              name=" " />

                          <input type="hidden" name=" ">

                          <div class="flex flex-wrap gap-2 mt-3" id="phoneContainer">
                              <!-- Phone numbers will be added here -->
                              @isset($institute->passkeys)
                                @foreach ($institute->mobile_numbers as $mobile_number)
                                    <div class="bg-gray-200 text-black px-3 py-1 rounded cursor-pointer hover:bg-gray-700 hover:text-white">
                                        {{ $mobile_number }}
                                        <input type="hidden" name="mobile_numbers[]" value="{{ $mobile_number }}">
                                    </div>
                                @endforeach
                            @endisset
                          </div>
                        </div>

                        <div class="">
                            <x-label for="passkeyInput" :value="__('Passkeys to enter the institute')" />

                            <x-input id="passkeyInput" class="block mt-1 w-full" type="text"
                                name=" " />

                            <input type="hidden" name=" ">

                            <div class="flex flex-wrap gap-2 mt-3" id="passkeyContainer">
                                <!-- Passkeys will be added here -->
                                @isset($institute->passkeys)
                                    @foreach ($institute->passkeys as $passkey)
                                        <div class="bg-gray-200 text-black px-3 py-1 rounded cursor-pointer hover:bg-gray-700 hover:text-white">
                                            {{ $passkey }}
                                            <input type="hidden" name="passkeys[]" value="{{ $passkey }}">
                                        </div>
                                    @endforeach
                                @endisset
                            </div>

                        </div>

                      </div>


                      <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mt-5 mb-5">

                        <div class="">
                          <x-label for="address_1" :value="__('Address Line 1')" />
                          @php
                              $address_one = '';
                              $address_two = '';
                              if(isset($institute->address_one)){
                                $address_one = $institute->address_one;
                              }
                              if(isset($institute->address_two)){
                                $address_two = $institute->address_two;
                              }
                          @endphp
                          <x-input id="address_1" class="block mt-1 w-full" type="text"
                              name="address_1" 
                              value=" {{ $address_one }} "/>
                        </div>

                        <div class="">
                          <x-label for="address_2" :value="__('Address Line 2')" />

                          <x-input id="address_2" class="block mt-1 w-full" type="text"
                              name="address_2" 
                              value=" {{ $address_two }} "/>
                        </div>

                      </div>


                    </div>
                  </div>
                </div>
              </div>


              <!-- Register and cancel button -->
              <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('institute.view-single', $institute) }}">
                  {{ __('Cancel?') }}
                </a>

                <x-button class="ml-4" id="submitButton">
                  {{ __('Update') }}
                </x-button>

              </div>

            </form>


          </div>
        </div>
      </div>
    </div>





    <script>

        $('input').on('keypress', function(e) {
            if (e.which == 13) {
                e.preventDefault();
            }
        });


        // Handle emails ----------------------------------------------------------->>>>>>>>>
        $(document).ready(function() {
            // Function to add an email
            function addEmail(singleEmail) {
                var emailHtml =
                    '<div class="bg-gray-200 text-black px-3 py-1 rounded cursor-pointer hover:bg-gray-700 hover:text-white">' +
                    singleEmail + ' <input type="hidden" name="emails[]" value="' + singleEmail + '">  </div>';
                $('#emailContainer').append(emailHtml);
            }

            // Function to remove an email
            $(document).on('click', '#emailContainer div', function() {
                let removableEmail = $(this).text();
                let index = emails.indexOf(removableEmail);
                $('#emailInput').val(removableEmail);
                emails.splice(index, 1);
                $(this).remove();
            });

            function validateEmail(email) {
                var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return regex.test(email);
            }

            // Listen for keypress event on input field
            $('#emailInput').keypress(function(event) {
                if (event.which === 13) { // Check if Enter key is pressed
                    var singleEmail = $(this).val().trim();
                    if (singleEmail !== '') {

                        if (validateEmail(singleEmail)) {
                            if (!emails.includes(singleEmail)) {
                                addEmail(singleEmail);
                                emails.push(singleEmail)
                                $(this).val(''); // Clear input field after adding email
                            } else {
                                $('#emailInput').val('This Email already added');
                            }
                        } else {
                            $('#emailInput').val('Please Enter a valid email');
                        }

                    }
                }
            });
        });




        // Handle Mobile Numbers ----------------------------------------------------------->>>>>>>>>
        $(document).ready(function() {
            // Function to add
            function addPhone(singlePhone) {
                var phoneHtml =
                    '<div class="bg-gray-200 text-black px-3 py-1 rounded cursor-pointer hover:bg-gray-700 hover:text-white">' + singlePhone + ' <input type="hidden" name="mobile_numbers[]" value="'  + singlePhone + '"> </div>';
                $('#phoneContainer').append(phoneHtml);
            }

            // Function to remove
            $(document).on('click', '#phoneContainer div', function() {
                let removablePhone = $.trim($(this).text());
                let index = phone_numbers.indexOf(removablePhone);
                $('#phoneInput').val(removablePhone);
                phone_numbers.splice(index, 1);
                $(this).remove();
            });

            function validateNumber(inputString) {
                var regex = /^\+?[0-9]+$/;
                return regex.test(inputString);
            }

            // Listen for keypress event on input field
            $('#phoneInput').keypress(function(event) {
                if (event.which === 13) { // Check if Enter key is pressed
                    var singlePhone = $(this).val().trim();
                    if (singlePhone !== '') {
                        if (validateNumber(singlePhone)) {
                            if (!phone_numbers.includes(singlePhone)) {
                                addPhone(singlePhone);
                                phone_numbers.push(singlePhone);
                                $(this).val(''); // Clear input field after adding phone number
                            } else {
                                $('#phoneInput').val('This Number already added');
                            }
                        } else {
                            $('#phoneInput').val('Please Enter a valid phone number');
                        }

                    }
                }
            });
        });




        // Handle Passkeys ----------------------------------------------------------->>>>>>>>>
        $(document).ready(function() {
            // Function to add
            function addPasskey(singlePasskey) {
                var passkeyHtml =
                    '<div class="bg-gray-200 text-black px-3 py-1 rounded cursor-pointer hover:bg-gray-700 hover:text-white">' +
                    singlePasskey + '<input type="hidden" name="passkeys[]" value="' + singlePasskey + '"></div>';
                $('#passkeyContainer').append(passkeyHtml);
            }

            // Function to remove
            $(document).on('click', '#passkeyContainer div', function() {
                let removablePasskey = $.trim($(this).text());
                let index = passkeys.indexOf(removablePasskey);
                $('#passkeyInput').val(removablePasskey);
                passkeys.splice(index, 1);
                $(this).remove();
            });

            // Listen for keypress event on input field
            $('#passkeyInput').keypress(function(event) {
                if (event.which === 13) { // Check if Enter key is pressed
                    var singlePasskey = $(this).val().trim();
                    if (singlePasskey !== '') {
                        if (!passkeys.includes(singlePasskey)) {
                            addPasskey(singlePasskey);
                            passkeys.push(singlePasskey);
                            $(this).val(''); // Clear input field after adding phone number
                        } else {
                            $('#passkeyInput').val('This passkey already added');
                        }

                    }
                }
            });
        });





        // Handle Form Submission ----------------------------------------------------------->>>>>>>>>

        // $(document).ready(function() {
        //     $("#submitButton").click(function(event) {
        //         event.preventDefault(); // Prevent default form submission

        //         var formData = new FormData($("#myForm")[0]);

        //         admins.forEach(el => {
        //             formData.append("admins[]", el);
        //         });

        //         emails.forEach(el => {
        //             formData.append("emails[]", el);
        //         });

        //         phone_numbers.forEach(el => {
        //             formData.append("mobile_numbers[]", el);
        //         });

        //         passkeys.forEach(el => {
        //             formData.append("passkeys[]", el);
        //         });


        //         // Display the key/value pairs
        //         // for (var pair of formData.entries()) {
        //         //     console.log(pair[0]+ ', ' + pair[1]);
        //         // }

        //         $.ajax({
        //             url: "{{ route('institute.create') }}",
        //             type: "post",
        //             data: formData,
        //             processData: false, // Prevent jQuery from processing data
        //             contentType: false, // Prevent jQuery from setting content type
        //             success: function(response) {
        //                 // Handle successful form submission response
        //                 console.log("Form submitted successfully!");
        //                 console.log(response.data.id);
        //                 let id = response.data.id;
        //                 window.location.replace(window.location.origin + "/institute/" + id)
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error("Error submitting form:", error);
        //                 // Handle form submission error
        //             }
        //         });
        //     });
        // });



        function getCookie(name) {
            var value = "; " + document.cookie;
            var parts = value.split("; " + name + "=");
            if (parts.length === 2) return parts.pop().split(";").shift();
        }
    </script>




</x-app-layout>
