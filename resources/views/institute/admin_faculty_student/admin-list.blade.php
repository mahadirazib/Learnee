<x-app-layout>

    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        var admins = [];
    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">


                    <x-alert> </x-alert>

                    <div>
                        <h1 class="font-bold text-4xl"> {{ $institute->name }} </h1>
                        <span class="text-sm text-gray-500"> Since:
                            {{ date('j F, Y', strtotime($institute->created_at)) }}
                        </span>
                    </div>


                    <div class="mt-5 mb-5">
                        <hr>
                    </div>

                    <div class="">
                        <h2 class="font-bold text-2xl"> Institute Created by: </h2>
                        <div class="grid grid-cols-8 gap-2 mt-3 mb-5">

                            <div class="w-fit h-24 rounded-xl overflow-hidden">

                                @if (isset($institute->owner_image) && file_exists('storage/profile_pictures/' . $institute->owner_image))
                                    <img class=""
                                        src="{{ asset('storage/profile_pictures/' . $institute->owner_image) }}"
                                        alt="Profile Picture">
                                @else
                                    <img class="" src="{{ asset('storage/default_images/pro_pic.jpg') }}"
                                        alt="Profile Picture">
                                @endif

                            </div>


                            <div class="col-span-5 ml-4 content-center">
                                <a href="{{ route('user.view', $institute->owner_id) }}">
                                    <h4 class="font-bold text-md"> {{ $institute->owner_name }} </h4>
                                </a>

                                <p class="font-normal text-sm">
                                    Email:
                                    {{ $institute->owner_email }}
                                </p>

                                <p class="font-normal text-sm">
                                    Phone Number:
                                    {{ $institute->owner_mobile_number ? $institute->owner_mobile_number : 'Not given' }}
                                </p>

                            </div>

                        </div>

                    </div>



                    <div class="mt-10">
                        <h2 class="font-bold text-2xl"> Head of the Institute: </h2>
                        <div class="grid grid-cols-8 gap-2 mt-3 mb-5">

                            <div class="w-fit h-24 rounded-xl overflow-hidden">

                                @if (isset($institute->institute_head_image) &&
                                        file_exists('storage/profile_pictures/' . $institute->institute_head_image))
                                    <img class=""
                                        src="{{ asset('storage/profile_pictures/' . $institute->institute_head_image) }}"
                                        alt="Profile Picture">
                                @else
                                    <img class="" src="{{ asset('storage/default_images/pro_pic.jpg') }}"
                                        alt="Profile Picture">
                                @endif

                            </div>


                            <div class="col-span-5 ml-4 content-center">
                                <a href="{{ route('user.view', $institute->institute_head_id) }}">
                                    <h4 class="font-bold text-md"> {{ $institute->institute_head_name }} </h4>
                                </a>

                                <p class="font-normal text-sm">
                                    Email:
                                    {{ $institute->institute_head_email }}
                                </p>

                                <p class="font-normal text-sm">
                                    Phone Number:
                                    {{ $institute->institute_head_mobile_number ? $institute->institute_head_mobile_number : 'Not given' }}
                                </p>

                            </div>
                        </div>
                    </div>


                    <div class="mt-10 mb-10">
                        <hr>
                    </div>

                    <form action="{{ route('institute.admin.update', $institute->id) }}" method="POST">
                        @csrf

                        @foreach ($admins as $admin)
                            <input type="hidden" name="admins[]" value="{{ $admin->id }}">
                        @endforeach

                        <div>

                            <h2 class="font-bold text-2xl"> Add new admins: </h2>

                            <div class=" mt-5 mb-5">

                                <div class=" grid grid-cols-2">
                                    <div class="max-w-xl">
                                        <x-input id="fetch-users" class="block w-full" type="text" name=" "
                                            :value="old('Search')" />

                                        <div id="user-list"
                                            class="absolute bg-white border border-gray-300 rounded-md shadow-lg z-10 hidden">
                                            <!-- Search results will be displayed here -->
                                        </div>
                                    </div>

                                    <div>
                                        <div class="inline ms-3">
                                            <x-button-blank-link class="outline outline-2 bg-gray-600 ms-auto p-2"
                                                id="searchUser">
                                                Search
                                            </x-button-blank-link>
                                        </div>

                                        <div class="inline ms-5">
                                            <x-button class="outline outline-2 bg-teal-600 ms-auto p-2">
                                                Add New Admins
                                            </x-button>
                                        </div>

                                    </div>

                                </div>

                                <div class="">
                                    <div id="selected-users" class="content-fit">
                                        <!-- Faculty search result will be shown here -->
                                    </div>
                                </div>

                            </div>

                        </div>

                    </form>


                    <div class="mt-10 mb-10">
                        <hr>
                    </div>


                    <div class="">


                        <h2 class="font-bold text-2xl"> Admins of the Institute: </h2>

                        @foreach ($admins as $admin)
                            <div class="grid grid-cols-8 gap-2 mt-3 mb-5">

                                <div class="w-fit h-24 rounded-xl overflow-hidden">

                                    @if (isset($admin->image) && file_exists('storage/profile_pictures/' . $admin->image))
                                        <img class=""
                                            src="{{ asset('storage/profile_pictures/' . $admin->image) }}"
                                            alt="Profile Picture">
                                    @else
                                        <img class="" src="{{ asset('storage/default_images/pro_pic.jpg') }}"
                                            alt="Profile Picture">
                                    @endif

                                </div>

                                <div class="col-span-3 ml-4 content-center">
                                    <a href="{{ route('user.view', $admin->id) }}">
                                        <h4 class="font-bold text-md"> {{ $admin->name }} </h4>
                                    </a>

                                    <p class="font-normal text-sm">
                                        Email:
                                        {{ $admin->email }}
                                    </p>

                                    <p class="font-normal text-sm">
                                        Phone Number:
                                        {{ $admin->mobile_number ? $admin->institute_head_mobile_number : 'Not given' }}
                                    </p>

                                </div>

                                <div class="col-span-4 content-center text-right">

                                    <form action="{{ route('institute.admin.delete', [$institute->id, $admin->id]) }}"
                                        class="ms-auto inline" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <x-button class="outline outline-2 bg-red-600"
                                            href="{{ route('institute.department.create', $institute->id) }}">
                                            Delete
                                        </x-button>
                                    </form>

                                    <x-button-blank-link class="outline outline-2 text-sky-600 bg-sky-600 ms-4"
                                        href="{{ route('institute.department.create', $institute->id) }}">
                                        Make General Faculty
                                    </x-button-blank-link>

                                </div>

                            </div>
                        @endforeach



                    </div>





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





        // Handle Admins ----------------------------------------------------------->>>>>>>>>
        $('#fetch-users').on('keypress', function(event) {
            if (event.keyCode === 13) {
                var searchTerm = $(this).val();
                fetchUserResult(searchTerm);
            }
        });

        $('#searchUser').on('click', function() {
            let searchTerm = $('#fetch-users').val();
            fetchUserResult(searchTerm);
        })

        let fetchUserResult = (searchTerm) => {
            var searchResultsDiv = $('#user-list');

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
                                            .name, response.email)
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

        // $('#user-list').on('change', function() {
        //     var selectedOption = $(this).find(':selected');
        //     var userId = selectedOption.val();
        //     var userName = selectedOption.text();
        //     // Remove the selected option from the dropdown
        //     selectedOption.remove();
        //     // Add the product to the selected products container
        //     // addToSelectedUser(userId, userName);
        // });

        // Function to remove
        $(document).on('click', '#selected-users div', function() {
            let getUserId = $('#selected-users div input').val();
            let index = admins.indexOf(getUserId);
            admins.splice(index, 1);
            $(this).remove();
        });

        // Function to add
        function addToSelectedUser(userId, userName, userEmail) {
            var selectedUserDiv = $('#selected-users');
            if (!admins.includes(userId)) {
                admins.push(userId);
            }
            selectedUserDiv.append(
                '<div class="bg-gray-200 text-black px-3 py-2 rounded cursor-pointer hover:bg-gray-700 hover:text-white leading-3 m-3" style="width: fit-content; display: inline-block"> <input type="hidden" name="admins[]" value="' +
                userId + '"> ' + userName + '<br> <span class="text-sm font-normal"> ' + userEmail + ' </span> </div>');

            console.log(userName);
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
