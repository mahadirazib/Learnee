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


                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />


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


                            <div class="col-span-3 ml-4 content-center">
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


                            <div class="col-span-4">
                                @if ($is_owner)
                                    <form action="{{ route('institute.owner.update', $institute->id) }}" method="POST">
                                        @csrf

                                        <div class=" mt-5 mb-5">
                                            <div class=" grid grid-cols-2">
                                                <div class="w-full">

                                                    <x-input id="search-user-input" class="block mt-1 w-full"
                                                        type="text" name="" required />

                                                    <input name="new_owner" id="new_owner" type="hidden">

                                                    <div id="search-results"
                                                        class="absolute mt-1 bg-white border border-gray-300 rounded-md shadow-lg z-10 hidden">
                                                        <!-- Search results will be displayed here -->
                                                    </div>

                                                </div>

                                                <div class="content-center">
                                                    <div class="inline ms-3">
                                                        <x-button-blank-link
                                                            class="outline outline-2 bg-gray-600 ms-auto p-2"
                                                            id="searchUserForOwner">
                                                            Search
                                                        </x-button-blank-link>
                                                    </div>

                                                    <div class="inline float-end">
                                                        <x-button class="outline outline-2 bg-teal-600 ms-auto p-2">
                                                            Change Owner
                                                        </x-button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </form>

                                    <script>
                                        // Handle Owner ----------------------------------------------------------->>>>>>>>>
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

                                            $('#searchUserForOwner').on('click', function() {
                                                let searchTerm = $('#search-user-input').val();
                                                searchTeacher(searchTerm);
                                            })

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
                                                            $('#new_owner').val(result.id);
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
                                    </script>
                                @else
                                    <div class="font-bold text-red-500 flex content-center">
                                        <div class="content-center">
                                            <x-icons.locked> </x-icons.locked>
                                        </div>
                                        <p class="content-center ms-3">
                                            Only Owner can change Owner
                                        </p>
                                    </div>
                                @endif

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


                            <div class="col-span-3 ml-4 content-center">
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


                            <div class="col-span-4">
                                @if ($is_owner || $is_head)
                                    <form action="{{ route('institute.head.update', $institute->id) }}" method="POST">
                                        @csrf

                                        <div class=" mt-5 mb-5">
                                            <div class=" grid grid-cols-2">
                                                <div class="w-full">

                                                    <x-input id="search-user-input-for-head" class="block mt-1 w-full"
                                                        type="text" name="" required />

                                                    <input name="new_head" id="new_head" type="hidden">

                                                    <div id="search-results-for-head"
                                                        class="absolute mt-1 bg-white border border-gray-300 rounded-md shadow-lg z-10 hidden">
                                                        <!-- Search results will be displayed here -->
                                                    </div>

                                                </div>

                                                <div class="content-center">
                                                    <div class="inline ms-3">
                                                        <x-button-blank-link
                                                            class="outline outline-2 bg-gray-600 ms-auto p-2"
                                                            id="searchUserForHead">
                                                            Search
                                                        </x-button-blank-link>
                                                    </div>

                                                    <div class="inline float-end">
                                                        <x-button class="outline outline-2 bg-teal-600 ms-auto p-2">
                                                            Change Head
                                                        </x-button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </form>


                                    <script>
                                        $('#search-user-input-for-head').on('keypress', function(event) {
                                            // Enter key pressed
                                            if (event.keyCode === 13) {
                                                event.preventDefault();
                                                var searchTerm = $(this).val();
                                                if (searchTerm.trim() !== '') {
                                                    searchTeacherForhead(searchTerm);
                                                }
                                            }

                                        });

                                        $('#searchUserForHead').on('click', function() {
                                            let searchTerm = $('#search-user-input-for-head').val();
                                            searchTeacherForhead(searchTerm);
                                        })

                                        function searchTeacherForhead(searchTerm) {
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
                                                    displaySearchResultsForHead(response);
                                                },
                                                error: function(xhr, status, error) {
                                                    console.error(error);
                                                }
                                            });
                                        }

                                        function displaySearchResultsForHead(results) {
                                            var searchResultsDiv = $('#search-results-for-head');
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
                                                        $('#search-user-input-for-head').val(result.name);
                                                        $('#new_head').val(result.id);
                                                        searchResultsDiv.addClass('hidden'); // Hide search results
                                                    });
                                                    searchResultsDiv.append(clickableResult);
                                                });
                                                searchResultsDiv.removeClass('hidden');
                                            } else {
                                                $('#search-user-input-for-head').val("Nothing Found");
                                                searchResultsDiv.addClass('hidden');
                                            }
                                        }
                                    </script>
                                @else
                                    <div class="font-bold text-red-500 flex content-center">
                                        <div class="content-center">
                                            <x-icons.locked> </x-icons.locked>
                                        </div>
                                        <p class="content-center ms-3">
                                            Only Owner can change Institute head
                                        </p>
                                    </div>
                                @endif

                            </div>

                        </div>
                    </div>


                    <div class="mt-10 mb-10">
                        <hr>
                    </div>

                    @if ($is_owner || $is_head)

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

                        <script>
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
                        </script>



                    @endif


                    <div class="">


                        <h2 class="font-bold text-2xl"> Admins of the Institute: </h2>

                        @php
                            $userId = auth()->user()->id;
                        @endphp

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

                                @if ($is_owner || $is_head)
                                    <div class="col-span-4 content-center text-right">

                                        <form
                                            action="{{ route('institute.admin.delete', [$institute->id, $admin->id]) }}"
                                            class="ms-auto inline" 
                                            method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <x-button class="outline outline-2 bg-red-600">
                                                Delete
                                            </x-button>
                                        </form>

                                        <form 
                                            action="{{ route('institute.admin.change_role', [$institute->id, $admin->id]) }}" 
                                            class="inline"
                                            method="POST">
                                            @csrf
                                            <x-button class="outline outline-2 text-sky-600 bg-sky-600 ms-4">
                                                Make General Faculty
                                            </x-button>

                                        </form>

                                    </div>
                                @elseif ($admin->id == $userId)
                                    <div class="col-span-4 content-center text-right">
                                        <form
                                            action="{{ route('institute.admin.delete', [$institute->id, $admin->id]) }}"
                                            class="ms-auto inline" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <x-button class="outline outline-2 bg-red-600">
                                                Leave institute
                                            </x-button>
                                        </form>
                                    </div>
                                @endif

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
    </script>




</x-app-layout>
