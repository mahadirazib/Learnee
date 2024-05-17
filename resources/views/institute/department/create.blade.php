<x-app-layout>

    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.tailwindcss.com"></script>


    <script>
        var admins = [];
        var passkeys = [];
        var subjects = {};
    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-5">
                        <h1 class="font-bold text-4xl"> {{ $institute->name }} </h1>
                        <input type="hidden" id="instituteName" value="{{ $institute->id }}">
                        <span class="text-sm text-gray-500"> Since: {{ $institute->created_at->format('j F, Y') }}
                        </span>
                    </div>

                    <div class="mb-5 mt-5">
                        <hr>
                    </div>

                    <h1 class="font-semibold text-xl mb-8" style="margin: 0 0 15px"> Creat new Department: </h1>

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <div id="errors" class="text-semibold font-sm text-red-500"> </div>

                    <!-- Main form -->
                    <form method="POST" id="myForm" action="" enctype="multipart/form-data">
                        @csrf


                        <div class="">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="bg-white border-b border-gray-200 p-5">


                                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">

                                            <div class="">
                                                <x-label for="name" :value="__('Name of the Department')" />

                                                <x-input id="name" class="block mt-1 w-full" type="text"
                                                    name="name" :value="old('name')" />

                                            </div>


                                            <div class="flex justify-center items-center">
                                                <div class="relative w-full">

                                                    <x-label for="search-user-input" :value="__('Head of the Department')" />

                                                    <x-input id="search-user-input" class="block mt-1 w-full"
                                                        type="text" name="" />

                                                    <input name="department_head" id="department_head" type="hidden">

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
                                                <!-- Admin Selection panel -->
                                                <div>
                                                    <div class="relative w-full">

                                                        <x-label for="fetch-users" :value="__('Select Admin')" />

                                                        <x-input id="fetch-users" class="block mt-1 w-full"
                                                            type="text" name=" " :value="old('Search')" />

                                                        <input name=" " id="admins" type="hidden">

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
                                                    <x-label for="passkeyInput" :value="__('Passkeys to enter the department')" />

                                                    <x-input id="passkeyInput" class="block mt-1 w-full" type="text"
                                                        name=" " />

                                                    <input type="hidden" name=" ">

                                                    <div class="flex flex-wrap gap-2 mt-3" id="passkeyContainer">
                                                        <!-- Passkeys will be added here -->
                                                    </div>

                                                </div>
                                            </div>

                                        </div>



                                        <!-- Subjects Section -->
                                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mt-5 mb-8">
                                            <div>
                                                <div class="grid grid-cols-3 gap-2">
                                                    <div class="col-span-2">
                                                        <x-label for="subject" :value="__('Subjects of this department')" />
                                                        <x-input id="subject" class="block mt-1 w-full"
                                                            type="text">
                                                        </x-input>
                                                    </div>
                                                    <div>
                                                        <x-label for="subjectReward" :value="__('Reward')" />
                                                        <x-input id="subjectReward" class="block mt-1 w-full"
                                                            type="text">
                                                        </x-input>
                                                    </div>
                                                </div>
                                                <button id="addSubject" type="button"
                                                    class="inline-flex items-center px-4 py-2 bg-teal-600 border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 active:bg-teal-900 focus:outline-none focus:border-teal-900 focus:ring ring-teal-300 disabled:opacity-25 transition ease-in-out duration-150 mt-2 float-end">
                                                    Add Subject
                                                </button>
                                            </div>

                                            <div>
                                                <h3 class="block font-medium text-sm text-gray-700">Subjects:</h3>

                                                <table class="border-collapse border table-auto w-full mt-1">
                                                    <thead>
                                                        <tr>
                                                            <th class="border-collapse border p-1 text-gray-600">Subject
                                                                Name</th>
                                                            <th class="border-collapse border p-1 text-gray-600">Rewards
                                                            </th>
                                                            <th class="border-collapse border p-1 text-gray-600">Action
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="subjectContainer">
                                                        {{-- <tr>
                                                            <td class="border-collapse border p-1 px-2">Some name</td>
                                                            <td class="border-collapse border p-1 px-2">Some marks</td>
                                                            <td class="border-collapse border p-1 px-2">
                                                                <div
                                                                    class="grid grid-cols-2 gap-2 content-center text-center">
                                                                    <span class="text-green-600 mx-auto">
                                                                        <x-icons.edit></x-icons.edit>
                                                                    </span>
                                                                    <span class="text-orange-600 mx-auto">
                                                                        <x-icons.delete></x-icons.delete>
                                                                    </span>
                                                                </div>
                                                            </td>
                                                        </tr> --}}
                                                    </tbody>
                                                </table>


                                            </div>

                                            <div class="">

                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Register and cancel button -->
                        <div class="flex items-center justify-end mt-4">
                            <a class="underline text-sm text-gray-600 hover:text-gray-900"
                                href="{{ route('institute.view-single', $institute) }}">
                                {{ __('Cancel?') }}
                            </a>

                            <x-button class="ml-4" id="submitButton">
                                {{ __('Create Department') }}
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


            // Handle Head Teacher ----------------------------------------------------------->>>>>>>>>

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
                    url: "{{ route('search-institute-teacher', $institute->id) }}",
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
                            $('#department_head').val(result.id);
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




        // Handle subjects ----------------------------------------------------------->>>>>>>>>

        // Function to add a subject
        function addSubject(subject, reward) {
            var subjectRow =
                `<tr class="newSubject">
                    <td class="subjectName border-collapse border p-1 px-2">${subject}</td>
                    <td class="border-collapse border p-1 px-2">${reward}</td>
                    <td class="border-collapse border p-1 px-2">
                        <div class="flex justify-evenly">
                            <span class="text-green-600 cursor-pointer" onclick="editSubject(this, '${subject}', '${reward}')">
                                <x-icons.edit></x-icons.edit>
                            </span>
                            <span class="text-orange-600 cursor-pointer" onclick="deleteSubject(this, '${subject}')">
                                <x-icons.delete></x-icons.delete>
                            </span>
                        </div>
                    </td>
                </tr>`;
            $('#subjectContainer').append(subjectRow);
        }

        // Function to remove a subject
        function deleteSubject(ele, subjectName) {
            let sub = ele.closest('.newSubject')
            delete subjects[subjectName]
            // subjects = subjects.filter(subArray => subArray[0] !== subjectName);
            // console.log(subjects);
            sub.remove();
        }

        function editSubject(ele, subjectName, reward) {
            let sub = ele.closest('.newSubject')
            delete subjects[subjectName]
            // subjects = subjects.filter(subArray => subArray[0] !== subjectName);
            $('#subject').val(subjectName);
            $('#subjectReward').val(reward);
            sub.remove();
        }



        // Listen for click in add subject button
        $("#addSubject").on("click", function() {
            let subject = $('#subject').val().trim();
            let rewards = $('#subjectReward').val().trim();

            // let is_present = subjects.some(function(item) {
            //     return item[0] === subject
            // })

            let is_present = false;
            if (subject !== '' && subjectReward != '') {
                // if (!is_present) {
                //     addSubject(subject, rewards);
                //     subjects = {...subjects, [subject] : rewards};
                //     console.log(subjects);
                //     // subjects.push([subject, rewards])
                //     $('#subject').val(''); // Clear input subjectafter adding subject
                //     $('#subjectReward').val(''); // Clear reward field after adding subject
                // } else {
                //     $('#subject').val('This Subject already added');
                // }

                if (subject in subjects) {
                    $('#subject').val('This Subject already added');
                } else {
                    addSubject(subject, rewards);
                    subjects = {
                        ...subjects,
                        [subject]: rewards
                    };
                    // console.log(subjects);
                    $('#subject').val(''); // Clear input subjectafter adding subject
                    $('#subjectReward').val(''); // Clear reward field after adding subject
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
                        url: "{{ route('search-institute-teacher', $institute->id) }}",
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
                '<div class="bg-gray-200 text-black px-3 py-1 rounded cursor-pointer hover:bg-gray-700 hover:text-white"> <input type="hidden" name="admins[]" value="' +
                userId + '"> ' + userName + '</div>');
        }






        // Handle Form Submission ----------------------------------------------------------->>>>>>>>>

        $(document).ready(function() {
            $("#submitButton").click(function(event) {
                event.preventDefault(); // Prevent default form submission

                var formData = new FormData($("#myForm")[0]);

                formData.append("subjects", JSON.stringify(subjects));

                // //   Display the key/value pairs
                //   for (var pair of formData.entries()) {
                //       console.log(pair[0]+ ', ' + pair[1]); 
                //   }

                $.ajax({
                    url: "{{ route('institute.department.store', $institute) }}",
                    type: "post",
                    data: formData,
                    processData: false, // Prevent jQuery from processing data
                    contentType: false, // Prevent jQuery from setting content type
                    success: function(response) {
                        // Handle successful form submission response
                        console.log("Form submitted successfully!");
                        // console.log(response.data);
                        
                        if (response.message) {
                            $('#errors').text(response.message)
                        }

                        let instituteId = Number($("#instituteName").val());


                        window.location.replace(window.location.origin + "/institute/" +
                            instituteId + "/department/" + response.data.id)
                    },
                    error: function(xhr, status, error) {
                        console.error("Error submitting form:", error);
                        $('#errors').text(
                            '🔴 Something went wrong! Please make sure that you provided all the required fields.'
                        )
                        // Handle form submission error
                    }
                });
            });
        });
    </script>




</x-app-layout>
