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

                    <h1 class="font-semibold text-xl mb-8" style="margin: 0 0 15px">
                        Edit <span class="text-teal-600 font-bold"> <q>{{ $department->name }}</q> </span> department:
                    </h1>

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

                                            <div>
                                                <div class="">
                                                    <x-label for="name" :value="__('Name of the Department')" />

                                                    <x-input id="name" class="block mt-1 w-full" type="text"
                                                        name="name" :value="old('name')"
                                                        value="{{ $department->name }}" />
                                                </div>


                                                <!-- Passkey section -->
                                                <div class="mt-4">
                                                    <x-label for="passkeyInput" :value="__('Passkeys to enter the department')" />

                                                    <x-input id="passkeyInput" class="block mt-1 w-full" type="text"
                                                        name=" " />

                                                    <input type="hidden" name=" ">

                                                    <div class="flex flex-wrap gap-2 mt-3" id="passkeyContainer">
                                                        @if (isset($department->passkeys) && $department->passkeys != null)
                                                            @foreach ($department->passkeys as $passkey)
                                                                <div
                                                                    class="bg-gray-200 text-black px-3 py-1 rounded cursor-pointer hover:bg-gray-700 hover:text-white">
                                                                    <input type="hidden" name="passkeys[]"
                                                                        value="{{ $passkey }}">
                                                                    {{ $passkey }}
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>

                                                </div>

                                            </div>


                                            <div class="w-full">
                                                <div>
                                                    <label class="block font-medium text-sm text-gray-700"
                                                        for="description">Description</label>
                                                    <textarea style="height: 180px;" name="description" id="description" type="textarea"
                                                        class="px-3 py-2 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">{{ $department->description }}</textarea>
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

                                                        <script>
                                                            var itr = 0;
                                                        </script>

                                                        @foreach ($department->subjects as $subject => $reward)
                                                            <tr class="newSubject">
                                                                <td class="subjectName border-collapse border p-1 px-2">
                                                                    {{ $subject }}</td>
                                                                <td
                                                                    class="subjectReward border-collapse border p-1 px-2">
                                                                    {{ $reward }}</td>
                                                                <td class="border-collapse border p-1 px-2">
                                                                    <div class="flex justify-evenly">
                                                                        <span class="text-green-600 cursor-pointer"
                                                                            onclick="editSubject(this, '{{ $subject }}', '{{ $reward }}')">
                                                                            <x-icons.edit></x-icons.edit>
                                                                        </span>
                                                                        <span class="text-orange-600 cursor-pointer"
                                                                            onclick="deleteSubject(this, '{{ $subject }}')">
                                                                            <x-icons.delete></x-icons.delete>
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                        <script>
                                                            let elem = $('.subjectName');
                                                            for (let item of elem) {
                                                                let sub = $('.subjectName')[itr]
                                                                let reward = $('.subjectReward')[itr++]
                                                                subjects = {...subjects, [sub.innerText]: reward.innerText}
                                                            }
                                                        </script>

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
                                href="{{ route('institute.department.view-single', [$institute, $department]) }}">
                                {{ __('Cancel?') }}
                            </a>

                            <x-button class="ml-4" id="submitButton">
                                {{ __('Update Department') }}
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
            let sub = ele.closest('.newSubject');

            delete subjects[subjectName]
            sub.remove();
        }

        function editSubject(ele, subjectName, reward) {
            let sub = ele.closest('.newSubject')
            delete subjects[subjectName]

            $('#subject').val(subjectName);
            $('#subjectReward').val(reward);
            sub.remove();
        }



        // Listen for click in add subject button
        $("#addSubject").on("click", function() {
            let subject = $('#subject').val().trim();
            let rewards = $('#subjectReward').val().trim();

            let is_present = false;
            if (subject !== '' && subjectReward != '') {

                if (subject in subjects) {
                    $('#subject').val('This Subject already added');
                } else {
                    addSubject(subject, rewards);
                    subjects = {
                        ...subjects,
                        [subject]: rewards
                    };

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
                let removablePasskey = $(this).text().trim();
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
                    url: "{{ route('institute.department.update', [$institute, $department]) }}",
                    type: "post",
                    data: formData,
                    processData: false, // Prevent jQuery from processing data
                    contentType: false, // Prevent jQuery from setting content type
                    success: function(response) {
                        // Handle successful form submission response
                        console.log("Form submitted successfully!");
                        console.log(response.data);

                        if (response.message) {
                            $('#errors').text(response.message)
                        }

                        let instituteId = Number($("#instituteName").val());


                        window.location.replace("{{ route('institute.department.view-single', [$institute, $department]) }}")
                        // window.location.replace(window.location.origin + "/institute/" +
                        //     instituteId + "/department/" + response.data.id)
                    },
                    error: function(xhr, status, error) {
                        console.error("Error submitting form:", error);
                        $('#errors').text(
                            ':( Something went wrong!'
                        )
                        // Handle form submission error
                    }
                });
            });
        });
    </script>




</x-app-layout>
