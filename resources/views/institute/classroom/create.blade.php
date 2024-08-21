<x-app-layout>

    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        var admins = [];
        var passkeys = [];
        var topics = [];
        var exam_types = [];
    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Institute Name and date created -->
                    <div class="grid grid-cols-1 mb-5">
                        <div>
                            <h1 class="font-bold text-4xl">
                                <a href="{{ route('institute.department.view-single', [$department->institute_id, $department->id] ) }}" class=" text-blue-600">
                                    {{ $department->name }}
                                </a>
                            </h1>
                            <h2 class="font-bold text-2xl text-gray-600">of <a class="text-lime-600"
                                    href="{{ route('institute.view-single', $department->institute_id) }}">{{ $department->institute_name }}</a>
                            </h2>
                            <span class="text-sm text-gray-500"> Department created:
                                {{ $department->created_at->format('j F, Y') }}
                            </span>
                        </div>

                    </div>

                    <div class="mb-5 mt-5">
                        <hr>
                    </div>

                    <h1 class="font-semibold text-xl mb-8" style="margin: 0 0 15px"> Creat new Classroom: </h1>

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <div id="errors" class="text-semibold font-sm text-red-500"> </div>


                    <!-- Main form -->
                    <form method="POST" id="myForm" action="{{ route('institute.department.classroom.store', [$department->institute_id, $department->id ]) }}" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="institute" value="{{ $department->institute_id }}">
                        <input type="hidden" name="department" value="{{ $department->id }}">

                        <div class="">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="bg-white border-b border-gray-200 p-5">


                                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">

                                            <div class="">
                                                <x-label for="name" :value="__('Classroom Title')" />

                                                <x-input id="name" class="block mt-1 w-full" type="text"
                                                    name="name" :value="old('name')" />

                                            </div>


                                            <div class="flex justify-center items-center">
                                                <div class="relative w-full">

                                                    <x-label for="search-user-input" :value="__('Main faculty for this classroom')" />

                                                    <x-input id="search-user-input" class="block mt-1 w-full"
                                                        type="text" name="" />

                                                    <input name="main_faculty" id="main_faculty" type="hidden">

                                                    <div id="search-results"
                                                        class="absolute top-full left-0 mt-1 bg-white border border-gray-300 rounded-md shadow-lg z-10 hidden">
                                                        <!-- Search results will be displayed here -->
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mt-5">
                                            <div>
                                                <label class="block font-medium text-sm text-gray-700"
                                                    for="description">Description</label>
                                                <textarea style="height: 150px;" name="description" id="description" type="textarea"
                                                    class="px-3 py-2 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full"></textarea>
                                            </div>

                                            <div>
                                                <!-- Other Faculties -->
                                                <div>
                                                    <div class="relative w-full">

                                                        <x-label for="fetch-users" :value="__('Other faculties')" />

                                                        <x-input id="fetch-users" class="block mt-1 w-full"
                                                            type="text" name=" " :value="old('Search')" />


                                                        <div id="user-list"
                                                            class="absolute top-full left-0 mt-1 bg-white border border-gray-300 rounded-md shadow-lg z-10 hidden">
                                                            <!-- Search results will be displayed here -->
                                                        </div>

                                                    </div>

                                                    <div class="flex flex-wrap gap-2 mt-3" id="selected-users">
                                                        <!-- Selected users will be displayed here -->
                                                    </div>
                                                </div>

                                                <!-- Passkey section -->
                                                <div class="mt-4">
                                                    <x-label for="passkeyInput" :value="__('Passkeys to enter the classroom')" />

                                                    <x-input id="passkeyInput" class="block mt-1 w-full" type="text"
                                                        name=" " />

                                                    <div class="flex flex-wrap gap-2 mt-3" id="passkeyContainer">
                                                        <!-- Passkeys will be added here -->
                                                    </div>

                                                </div>
                                            </div>

                                        </div>


                                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">

                                            <div class="">
                                                <x-label for="topicInput" :value="__('Classroom Topics')" />

                                                <x-input id="topicInput" class="block mt-1 w-full" type="text"
                                                    name=" " />

                                                <div class="flex flex-wrap gap-2 mt-3" id="topicContainer">
                                                    <!-- Passkeys will be added here -->
                                                </div>

                                            </div>


                                            <div class="">
                                                <x-label for="examTypesInput" :value="__('Exam types')" />

                                                <x-input id="examTypesInput" class="block mt-1 w-full" type="text"
                                                    name=" " placeholder="eg: Quiz, CT" />

                                                <div class="flex flex-wrap gap-2 mt-3" id="examTypeContainer">
                                                    <!-- Passkeys will be added here -->
                                                </div>
                                            </div>

                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Register and cancel button -->
                        <div class="flex items-center justify-end mt-4">
                            <a class="underline text-sm text-gray-600 hover:text-gray-900"
                                href="{{ route('institute.view-single', $department->institute_id) }}">
                                {{ __('Cancel?') }}
                            </a>

                            <x-button class="ml-4" id="submitButton">
                                {{ __('Create Classrom') }}
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


        $(document).ready(function() {


            // Handle Main Teacher ----------------------------------------------------------->>>>>>>>>

            $('#search-user-input').on('keyup', function(event) {
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
                    url: "{{ route('search-department-teacher', [$department->institute_id, $department->id]) }}",
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
                            $('#main_faculty').val(result.id);
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




        // Handle Passkeys ----------------------------------------------------------->>>>>>>>>
        $(document).ready(function() {
            // Function to add
            function addPasskey(singlePasskey) {
                var passkeyHtml =
                    '<div class="bg-gray-200 text-black px-3 py-1 rounded cursor-pointer hover:bg-gray-700 hover:text-white"> <input type="hidden" name="passkeys[]" value="' +
                    singlePasskey + '">  ' +
                    singlePasskey + '</div>';
                $('#passkeyContainer').append(passkeyHtml);
            }

            // Function to remove
            $(document).on('click', '#passkeyContainer div', function() {
                let removablePasskey = $(this).text().trim();
                let index = passkeys.indexOf(removablePasskey);
                $('#passkeyInput').val(removablePasskey);
                passkeys.splice(index, 1);
                $(this).remove();
            });

            // Listen for keypress event on input field
            $('#passkeyInput').keyup(function(event) {
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




        // Handle Topics ----------------------------------------------------------->>>>>>>>>
        $(document).ready(function() {
            // Function to add
            function addTopic(singlePasskey) {
                var passkeyHtml =
                    '<div class="bg-gray-200 text-black px-3 py-1 rounded cursor-pointer hover:bg-gray-700 hover:text-white"> <input type="hidden" name="topics[]" value="' +
                    singlePasskey + '">  ' +
                    singlePasskey + '</div>';
                $('#topicContainer').append(passkeyHtml);
            }

            // Function to remove
            $(document).on('click', '#topicContainer div', function() {
                let removableTopic = $(this).text().trim();
                let index = topics.indexOf(removableTopic);
                $('#topicInput').val(removableTopic);
                topics.splice(index, 1);
                $(this).remove();
            });

            // Listen for keypress event on input field
            $('#topicInput').keyup(function(event) {
                if (event.which === 13) { // Check if Enter key is pressed
                    var singleTopic = $(this).val().trim();
                    if (singleTopic !== '') {
                        if (!topics.includes(singleTopic)) {
                            addTopic(singleTopic);
                            topics.push(singleTopic);
                            $(this).val(''); // Clear input field after adding phone number
                        } else {
                            $('#topicInput').val('This topic already added');
                        }

                    }
                }
            });
        });




        // Handle Exam types ----------------------------------------------------------->>>>>>>>>
        $(document).ready(function() {
            // Function to add
            function addExamType(singleType) {
                var examTypeHtml =
                    '<div class="bg-gray-200 text-black px-3 py-1 rounded cursor-pointer hover:bg-gray-700 hover:text-white"> <input type="hidden" name="exam_types[]" value="' +
                    singleType + '">  ' +
                    singleType + '</div>';
                $('#examTypeContainer').append(examTypeHtml);
            }

            // Function to remove
            $(document).on('click', '#examTypeContainer div', function() {
                let removabletype = $(this).text().trim();
                let index = exam_types.indexOf(removabletype);
                $('#examTypesInput').val(removabletype);
                exam_types.splice(index, 1);
                $(this).remove();
            });

            // Listen for keypress event on input field
            $('#examTypesInput').keyup(function(event) {
                if (event.which === 13) { // Check if Enter key is pressed
                    var singleType = $(this).val().trim();
                    if (singleType !== '') {
                        if (!exam_types.includes(singleType)) {
                            addExamType(singleType);
                            exam_types.push(singleType);
                            $(this).val(''); // Clear input field after adding phone number
                        } else {
                            $('#examTypesInput').val('This type already added');
                        }

                    }
                }
            });
        });




        // Handle Other faculties ----------------------------------------------------------->>>>>>>>>
        $('#fetch-users').on('keypress', function(event) {
            if (event.keyCode === 13) {
                var searchResultsDiv = $('#user-list');

                var searchTerm = $(this).val();
                if (searchTerm.trim() !== '') {
                    $.ajax({
                        url: "{{  route('search-department-teacher', [$department->institute_id, $department->id]) }}",
                        method: "GET",
                        data: {
                            search: searchTerm
                        },
                        success: function(response) {

                            // console.log(response);

                            searchResultsDiv.empty();
                            if (response.length > 0) {

                                $.each(response, function(index, response) {
                                    if (!admins.includes(Number(response.id))) {
                                        var clickableResult = $(`
                                        <p style="margin: 5px 0; padding: 5px 20px" class="cursor-pointer hover:bg-gray-200 leading-3">
                                            ${response.name} <br>
                                            <span class="text-sm text-gray-500">${response.email}</span>
                                        </p>`);
                                        clickableResult.on('click', function(event) {
                                            event.stopPropagation();
                                            addToSelectedUser(response.id, response.name)
                                            searchResultsDiv.addClass('hidden'); // Hide search results
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
            // Add the user to the selected user container
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
                '<div class="bg-gray-200 text-black px-3 py-1 rounded cursor-pointer hover:bg-gray-700 hover:text-white"> <input type="hidden" name="other_faculties[]" value="' +
                userId + '"> ' + userName + '</div>');
        }






        // Handle Form Submission ----------------------------------------------------------->>>>>>>>>

        // $(document).ready(function() {
        //     $("#submitButton").click(function(event) {
        //         event.preventDefault(); // Prevent default form submission

        //         var formData = new FormData($("#myForm")[0]);

        //         formData.append("subjects", JSON.stringify(subjects));

        //         // //   Display the key/value pairs
        //         //   for (var pair of formData.entries()) {
        //         //       console.log(pair[0]+ ', ' + pair[1]); 
        //         //   }

        //         $.ajax({
        //             url: "{{ route('institute.department.classroom.store', [$department->institute_id, $department->id]) }}",
        //             type: "post",
        //             data: formData,
        //             processData: false, // Prevent jQuery from processing data
        //             contentType: false, // Prevent jQuery from setting content type
        //             success: function(response) {
        //                 // Handle successful form submission response
        //                 console.log("Form submitted successfully!");
        //                 // console.log(response.data);

        //                 if (response.message) {
        //                     $('#errors').text(response.message)
        //                 }

        //                 let instituteId = Number($("#instituteName").val());


        //                 window.location.replace(window.location.origin + "/institute/" +
        //                     instituteId + "/department/" + response.data.id)
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error("Error submitting form:", error);
        //                 $('#errors').text(
        //                     '🔴 Something went wrong! Please make sure that you provided all the required fields.'
        //                 )
        //                 // Handle form submission error
        //             }
        //         });
        //     });
        // });


    </script>




</x-app-layout>
