<x-app-layout>

    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.tailwindcss.com"></script>


    <script>
        var admins = [];
        var emails = [];
        var phone_numbers = [];
        var passkeys = [];
    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">


                    <h1 class="font-semibold text-xl mb-8" style="margin: 0 0 15px"> Creat your Institute: </h1>

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" id="myForm" action="{{ route('institute.create') }}"
                        enctype="multipart/form-data">
                        @csrf


                        <div class="">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="bg-white border-b border-gray-200">


                                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">

                                            <div class="">
                                                <x-label for="name" :value="__('Name of the Institute')" />

                                                <x-input id="name" class="block mt-1 w-full" type="text"
                                                    name="name" :value="old('name')" required />

                                            </div>


                                            <div class="flex justify-center items-center">
                                                <div class="relative w-full">

                                                    <x-label for="search-user-input" :value="__('Head of the Institute')" />

                                                    <x-input id="search-user-input" class="block mt-1 w-full"
                                                        type="text" name="" />

                                                    <input name="institute_head" id="institute_head" type="hidden">

                                                    <div id="search-results"
                                                        class="absolute top-full left-0 mt-1 bg-white border border-gray-300 rounded-md shadow-lg z-10 hidden max-h-60 overflow-y-auto">
                                                        <!-- Search results will be displayed here -->
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mt-5">

                                            <div class="">
                                                <x-label for="emailInput" :value="__('Email Address')" />

                                                <x-input id="emailInput" class="block mt-1 w-full" type="email"
                                                    name="" required />

                                                <input type="hidden" name=" " id="email">

                                                <div class="flex flex-wrap gap-2 mt-3" id="emailContainer">
                                                    <!-- Emails will be added here -->
                                                </div>

                                            </div>


                                            <div class="">
                                                <x-label for="phoneInput" :value="__('Mobile Numbers')" />

                                                <x-input id="phoneInput" class="block mt-1 w-full" type="text"
                                                    name=" " />

                                                <input type="hidden" name=" ">

                                                <div class="flex flex-wrap gap-2 mt-3" id="phoneContainer">
                                                    <!-- Phone numbers will be added here -->
                                                </div>
                                            </div>

                                        </div>


                                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mt-5">

                                            <div class="">
                                                <x-label for="address_1" :value="__('Address Line 1')" />

                                                <x-input id="address_1" class="block mt-1 w-full" type="text"
                                                    name="address_1" required />
                                            </div>

                                            <div class="">
                                                <x-label for="address_2" :value="__('Address Line 2')" />

                                                <x-input id="address_2" class="block mt-1 w-full" type="text"
                                                    name="address_2" />
                                            </div>

                                        </div>


                                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mt-5">

                                            <div class="">
                                                <x-label for="passkeyInput" :value="__('Passkeys to enter the institute')" />

                                                <x-input id="passkeyInput" class="block mt-1 w-full" type="text"
                                                    name=" " />

                                                <input type="hidden" name=" ">

                                                <div class="flex flex-wrap gap-2 mt-3" id="passkeyContainer">
                                                    <!-- Passkeys will be added here -->
                                                </div>

                                            </div>

                                            {{-- Select Admin --}}
                                            <div>

                                                <div>
                                                    <div class="relative w-full">

                                                        <x-label for="fetch-users" :value="__('Select Admin')" />

                                                        <x-input id="fetch-users" class="block mt-1 w-full"
                                                            type="text" name=" " :value="old('Search')" required />

                                                        <input name=" " id="admins" type="hidden">

                                                        <div id="user-list"
                                                            class="absolute top-full left-0 mt-1 bg-white border border-gray-300 rounded-md shadow-lg z-10 hidden max-h-60 overflow-y-auto">
                                                            <!-- Search results will be displayed here -->
                                                        </div>

                                                    </div>

                                                    <div class="flex flex-wrap gap-2 mt-3 " id="selected-users">
                                                        <!-- Selected users will be displayed here -->
                                                    </div>

                                                </div>


                                            </div>

                                        </div>


                                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mt-5 mb-12">

                                            {{-- Image Upload --}}
                                            <div>
                                                <label class="block font-medium text-sm text-gray-700">
                                                    Image Gallery
                                                </label>
                                                <div
                                                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md text-center">

                                                    <div class="space-y-1 text-center">

                                                        <!-- image gellary -->
                                                        <div class="mt-4">

                                                            <svg class="mx-auto h-12 w-12 text-black"
                                                                stroke="currentColor" fill="none"
                                                                viewBox="0 0 48 48" aria-hidden="true">
                                                                <path
                                                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                            </svg>

                                                            <x-label for="images" :value="__('Upload Images')"
                                                                class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500" />

                                                            <x-input onchange="FileDetails()" id="images"
                                                                class="sr-only" type="file" name="images[]"
                                                                multiple />

                                                            <p id="fileInfo"> </p>
                                                            <p class="text-xs text-black">
                                                                PNG, JPG, GIF up to 10MB
                                                            </p>

                                                            <script>
                                                                function FileDetails() {

                                                                    var fi = document.getElementById('images');

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

                                                                        $('#fileInfo').html(fileInfoHtml);

                                                                    }

                                                                }
                                                            </script>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>


                                            <div>
                                                <label class="block font-medium text-sm text-gray-700"
                                                    for="description">Description</label>
                                                <textarea 
                                                    style="height: 148px;"
                                                    name="description" id="description" type="textarea"
                                                    class="px-3 py-2 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full"></textarea>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Register and cancel button -->
                        <div class="flex items-center justify-end mt-4">
                            <a class="underline text-sm text-gray-600 hover:text-gray-900"
                                href="{{ route('login') }}">
                                {{ __('Cancel?') }}
                            </a>

                            <x-button type="button" class="ml-4" id="submitButton">
                                {{ __('Create Institute') }}
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


        // Handle Head Teacher ----------------------------------------------------------->>>>>>>>>
        $(document).ready(function() {
            $('#search-user-input').on('keypress', function(event) {
                // Enter key pressed
                if (event.keyCode === 13) {
                    event.preventDefault();
                    var searchTerm = $(this).val();
                    if (searchTerm.trim() !== '') {
                        searchTeacher(searchTerm);
                    }
                }

            });

            function searchTeacher(searchTerm) {
                // AJAX call to fetch search results
                $.ajax({
                    url: "{{ route('search-user') }}",
                    method: "GET",
                    data: {
                        search: searchTerm
                    },
                    success: function(response) {
                        // Manipulate DOM with the JSON response
                        // console.log(response);
                        displaySearchResults(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            function displaySearchResults(results) {
                var searchResultsDiv = $('#search-results');
                searchResultsDiv.empty();
                if (results.length > 0) {
                    $.each(results, function(index, result) {
                        var clickableResult = $(
                            '<p style="margin: 5px 0; padding: 5px 20px" class="cursor-pointer hover:bg-gray-200 leading-3">' +
                            result.name + '<br><span class="text-sm text-gray-500">' + result.email +
                            '</span></p>')
                        clickableResult.on('click', function(event) {
                            event.stopPropagation();
                            // Set input box's value to the clicked search result
                            $('#search-user-input').val(result.name);
                            $('#institute_head').val(result.id);
                            searchResultsDiv.addClass('hidden'); // Hide search results
                        });
                        searchResultsDiv.append(clickableResult);
                    });
                    searchResultsDiv.removeClass('hidden');
                } else {
                    $('#search-user-input').val("Nothing Found");
                    searchResultsDiv.addClass('hidden');
                }
            }
        });





        // Handle emails ----------------------------------------------------------->>>>>>>>>
        $(document).ready(function() {
            // Function to add a tag
            function addEmail(singleEmail) {
                var emailHtml =
                    '<div class="bg-gray-200 text-black px-3 py-1 rounded cursor-pointer hover:bg-gray-700 hover:text-white">' +
                    singleEmail + '</div>';
                $('#emailContainer').append(emailHtml);
            }

            // Function to remove a tag
            $(document).on('click', '#emailContainer div', function() {
                let removableEmail = $(this).html();
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
                    '<div class="bg-gray-200 text-black px-3 py-1 rounded cursor-pointer hover:bg-gray-700 hover:text-white">' +
                    singlePhone + '</div>';
                $('#phoneContainer').append(phoneHtml);
            }

            // Function to remove
            $(document).on('click', '#phoneContainer div', function() {
                let removablePhone = $(this).html();
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
                    singlePasskey + '</div>';
                $('#passkeyContainer').append(passkeyHtml);
            }

            // Function to remove
            $(document).on('click', '#passkeyContainer div', function() {
                let removablePasskey = $(this).html();
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




        // Handle Admins ----------------------------------------------------------->>>>>>>>>
        $('#fetch-users').on('keypress', function(event) {
            if (event.keyCode === 13) {
                var searchResultsDiv = $('#user-list');

                var searchTerm = $(this).val();
                if (searchTerm.trim() !== '') {
                    $.ajax({
                        url: "{{ route('search-user') }}",
                        method: "GET",
                        data: {
                            search: searchTerm
                        },
                        success: function(response) {

                            searchResultsDiv.empty();
                            if (response.length > 0) {

                                $.each(response, function(index, response) {
                                    if (!admins.includes(Number(response.id))) {
                                        var clickableResult = $(`<p style="margin: 5px 0; padding: 5px 20px" class="cursor-pointer hover:bg-gray-200 leading-3">
                                                                                        ${response.name} <br>
                                                                                        <span class="text-sm text-gray-500">${response.email}</span>
                                                                                        </p>`);
                                        clickableResult.on('click', function(event) {
                                            event.stopPropagation();
                                            addToSelectedUser(response.id, response
                                                .name)
                                            searchResultsDiv.addClass(
                                                'hidden'); // Hide search results
                                        });
                                        searchResultsDiv.append(clickableResult);
                                    }
                                });

                                searchResultsDiv.removeClass('hidden');
                            } else {
                                $('#fetch-users').html("Nothing Found");
                                searchResultsDiv.addClass('hidden');
                            }

                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                } else {
                    searchResultsDiv.empty();
                }
            }
        });

        $('#user-list').on('change', function() {
            var selectedOption = $(this).find(':selected');
            var userId = selectedOption.val();
            var userName = selectedOption.text();
            // Remove the selected option from the dropdown
            selectedOption.remove();
            // Add the product to the selected products container
            addToSelectedUser(userId, userName);
        });

        // Function to remove
        $(document).on('click', '#selected-users div', function() {
            let getUserId = $('#selected-users div input').val();
            let index = admins.indexOf(getUserId);
            admins.splice(index, 1);
            $(this).remove();
        });

        // Function to add
        function addToSelectedUser(userId, userName) {
            var selectedUserDiv = $('#selected-users');
            if (!admins.includes(userId)) {
                admins.push(userId);
            }
            selectedUserDiv.append(
                '<div class="bg-gray-200 text-black px-3 py-1 rounded cursor-pointer hover:bg-gray-700 hover:text-white"> <input type="hidden" value="' +
                userId + '"> ' + userName + '</div>');
        }








        // Handle Form Submission ----------------------------------------------------------->>>>>>>>>

        $(document).ready(function() {
            $("#submitButton").click(function(event) {
                event.preventDefault(); // Prevent default form submission

                var formData = new FormData($("#myForm")[0]);

                admins.forEach(el => {
                    formData.append("admins[]", el);
                });

                emails.forEach(el => {
                    formData.append("emails[]", el);
                });

                phone_numbers.forEach(el => {
                    formData.append("mobile_numbers[]", el);
                });

                passkeys.forEach(el => {
                    formData.append("passkeys[]", el);
                });


                // Display the key/value pairs
                // for (var pair of formData.entries()) {
                //     console.log(pair[0]+ ', ' + pair[1]); 
                // }

                $.ajax({
                    url: "{{ route('institute.create') }}",
                    type: "post",
                    data: formData,
                    processData: false, // Prevent jQuery from processing data
                    contentType: false, // Prevent jQuery from setting content type
                    success: function(response) {
                        // Handle successful form submission response
                        console.log("Form submitted successfully!");
                        console.log(response.data.id);
                        let id = response.data.id;
                        window.location.replace(window.location.origin + "/institute/" + id)
                    },
                    error: function(xhr, status, error) {
                        console.error("Error submitting form:", error);
                        // Handle form submission error
                    }
                });
            });
        });



        function getCookie(name) {
            var value = "; " + document.cookie;
            var parts = value.split("; " + name + "=");
            if (parts.length === 2) return parts.pop().split(";").shift();
        }
    </script>




</x-app-layout>
