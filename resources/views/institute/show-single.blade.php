<x-app-layout>

    <script>
        var mainDescriptionText;
    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <x-alert> </x-alert>

                    <!-- Institute Name and date joined -->
                    <div class="grid grid-cols-2 gap-4 mb-5">
                        <div>
                            <h1 class="font-bold text-4xl"> {{ $institute->name }} </h1>
                            <span class="text-sm text-gray-500"> Since: {{ $institute->created_at->format('j F, Y') }}
                            </span>
                        </div>
                        <div class="ms-auto">
                            @if ($is_admin)

                                <x-link-button class="mt-4" href="/">
                                    Faculty & Students
                                </x-link-button>

                                <x-link-button class="mt-4" href="{{ route('institute.edit-form', $institute->id) }}">
                                    Edit Info
                                </x-link-button>
                            @elseif($is_member)
                                {{-- <x-link-button href="join">
                                    see details
                                </x-link-button> --}}
                            @else
                                <x-link-button href="{{ route('institute.join', $institute) }}">
                                    Join this Institute
                                </x-link-button>
                            @endif
                        </div>
                    </div>

                    <!-- Institute Image gellary -->
                    <div>
                        <!-- Implement the carousel -->
                        <div class="relative w-full mx-auto">

                            @isset($institute->images)
                                @php
                                    $counter = 1;
                                @endphp

                                @foreach ($institute->images as $image)
                                    @if (file_exists('storage/institute_images/' . $image))
                                        <div class="slide relative">
                                            <img class="w-full h-[300px] object-cover" alt="Institute Image"
                                                src="{{ asset('storage/institute_images/' . $image) }}">
                                        </div>
                                    @else
                                        <div class="slide relative">
                                            <img class="w-full h-[300px] object-cover" alt="Institute Image"
                                                src="{{ asset('storage/default_images/institute_gellary/image (' . $counter++ . ').jpg') }}">
                                        </div>
                                    @endif
                                @endforeach

                                {{-- @if (file_exists($institute->images[0]))
                                    @foreach ($institute->images as $image)
                                        <div class="slide relative">
                                            <img class="w-full h-[300px] object-cover" alt="Institute Image"
                                                src="{{ asset('storage/institute_images/' . $image) }}">
                                        </div>
                                    @endforeach --}}
                            @else
                                <div class="slide relative">
                                    <img class="w-full h-[300px] object-cover" alt="Institute Image"
                                        src="{{ asset('storage/default_images/institute_gellary/image (5).jpg') }}">
                                </div>
                                <div class="slide relative">
                                    <img class="w-full h-[300px] object-cover" alt="Institute Image"
                                        src="{{ asset('storage/default_images/institute_gellary/image (6).jpg') }}">
                                </div>
                            @endisset


                            <!-- The previous button -->
                            <a class="absolute left-0 top-1/2 p-4 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white hover:text-amber-500 cursor-pointer"
                                onclick="moveSlide(-1)">❮</a>

                            <!-- The next button -->
                            <a class="absolute right-0 top-1/2 p-4 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white hover:text-amber-500 cursor-pointer"
                                onclick="moveSlide(1)">❯</a>

                        </div>
                        <br>

                        <!-- The dots -->
                        <div class="flex justify-center items-center space-x-5" id="dotContainer"> </div>


                        <!-- Javascript code -->
                        <script>
                            // Count images and generate dot based on the numbers
                            let slidesToCount = document.getElementsByClassName("slide");
                            let num = 0;
                            for (i = 0; i < slidesToCount.length; i++) {
                                let dotHtml = document.createElement("div");
                                let classess = ['dot', 'w-4', 'h-4', 'rounded-full', 'cursor-pointer']
                                dotHtml.classList.add(...classess);
                                dotHtml.setAttribute('onclick', "currentSlide(" + (i + 1) + ")")

                                document.querySelector('#dotContainer').appendChild(dotHtml);
                            }



                            // set the default active slide to the first one
                            let slideIndex = 1;
                            showSlide(slideIndex);

                            // change slide with the prev/next button
                            function moveSlide(moveStep) {
                                showSlide(slideIndex += moveStep);
                            }

                            // change slide with the dots
                            function currentSlide(n) {
                                showSlide(slideIndex = n);
                            }

                            function showSlide(n) {
                                let i;
                                const slides = document.getElementsByClassName("slide");
                                const dots = document.getElementsByClassName('dot');

                                if (n > slides.length) {
                                    slideIndex = 1
                                }
                                if (n < 1) {
                                    slideIndex = slides.length
                                }

                                // hide all slides
                                for (i = 0; i < slides.length; i++) {
                                    slides[i].classList.add('hidden');
                                }

                                // remove active status from all dots
                                for (i = 0; i < dots.length; i++) {
                                    dots[i].classList.remove('bg-gray-500');
                                    dots[i].classList.add('bg-gray-300');
                                }

                                // show the active slide
                                slides[slideIndex - 1].classList.remove('hidden');

                                // highlight the active dot
                                dots[slideIndex - 1].classList.remove('bg-cyan-300');
                                dots[slideIndex - 1].classList.add('bg-gray-500');
                            }

                            // call showSlide(slideIndex = 2); to change the slide
                        </script>

                    </div>



                    <!-- Institute description -->
                    <div class="mt-5">
                        <div class="textWithLines" id="description">{{ $institute->description }}</div>
                    </div>




                    <!-- Institute Departments -->
                    <div class="mt-10">

                        <div class="grid grid-cols-2 gap-4 content-center">
                            <h2 class="font-bold text-2xl"> Departments: </h2>

                            <div class="font-bold content-center">
                                <div class="content-center">
                                    <div class="">
                                        <div class="flex content-center float-end">
                                            <a href=" {{ route('institute.department.all', $institute->id) }} "
                                                class="mt-1 content-center text-gray-600 hover:text-gray-800 float-end">See all ❯</a>
                                        </div>
                                    </div>
                                    
                                    <div class=" float-end me-5">
                                        @if ($is_admin)
                                        <x-button-blank-link class="outline outline-2 text-gray-800 bg-gray-800 ms-auto" href="{{route('institute.department.create', $institute->id)}}">
                                            Add new Dept.
                                        </x-button-blank-link>
                                        @endif
                                    </div>

                                </div>


                                @if (count($departments))
                                @endif
                            </div>
                        </div>

                        <div class="mt-5 mb-5 grid grid-cols-2 gap-4">
                            @if (count($departments))
                                @foreach ($departments as $department)
                                    <div class="max-w-7xl mx-auto">
                                        <div class="relative group">
                                            <div
                                                class="relative leading-none px-7 py-6 bg-gray-100 hover:text-slate-600 hover:bg-gray-200 transition duration-200 ring-1 ring-gray-900/5 rounded-lg flex items-top justify-start space-x-6 ">
                                                <div class="space-y-2">
                                                    <h3 class="text-black font-bold">
                                                        {{ Str::limit($department->name, 40) }}
                                                    </h3>
                                                    <p class="text-gray-600">
                                                        {{ Str::limit($department->description, 100) }}
                                                    </p>
                                                    <div class="grid grid-cols-2 gap-4 content-center">
                                                        <a href="{{ route('institute.department.view-single', [$institute->id, $department->id]) }}"
                                                            class="content-center">
                                                            <p
                                                                class="block text-indigo-400 font-bold  hover:text-slate-800 transition duration-200">
                                                                Details <span style="size: 20px">→</span>
                                                            </p>
                                                        </a>

                                                        {{-- <div>
                                                            @if ($is_admin)
                                                            <x-button-blank-link
                                                            class="bg-teal-600 float-end ms-3" 
                                                            href="{{ route('institute.notice.edit-form', [$institute, $department]) }}">
                                                            Edit
                                                            </x-button-blank-link>
                                                            <form action="{{ route('institute.notice.delete', [$institute, $department]) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <x-button-blank-submit
                                                                    class="bg-red-500 float-end ms-3" href="/">
                                                                    Delete
                                                                </x-button-blank-submit>
                                                            </form>
                                                            @endif
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h3 class="text-black font-bold">
                                    No department Found
                                </h3>
                            @endif
                        </div>

                        <div>
                            {{ $departments->links() }}
                        </div>

                    </div>



                    <!-- Institute Notice -->
                    @if ((isset($is_member) || isset($is_admin)) && isset($notices))
                        <div class="mt-10">
                            <div class="grid grid-cols-2 gap-4 content-center">
                                <h2 class="font-bold text-2xl"> Notices: </h2>
                                <div class="font-bold grid content-end">


                                    <div class="content-center">
                                        <div class="">
                                            <div class="flex content-center float-end">
                                                <a href=" {{ route('institute.notice.all', $institute->id) }} "
                                                    class="mt-1 content-center text-gray-600 hover:text-gray-800 float-end">See all ❯</a>
                                            </div>
                                        </div>
                                        
                                        <div class=" float-end me-5">
                                            @if ($is_admin)
                                            <x-button-blank-link class="outline outline-2 text-gray-800 bg-gray-800 ms-auto" href="{{route('institute.notice.create', $institute->id)}}">
                                                Add new Notice
                                            </x-button-blank-link>
                                            @endif
                                        </div>
    
                                    </div>

                                    @if (count($notices))
                                    @endif

                                </div>
                            </div>

                            <div class="mt-5 mb-5 grid grid-cols-2 gap-4">
                                @if (count($notices))
                                    @foreach ($notices as $notice)
                                        <div class="max-w-7xl mx-auto">
                                            <div class="relative group">
                                                <div
                                                    class="relative leading-none px-7 py-6 bg-gray-100 hover:text-slate-600 hover:bg-gray-200 transition duration-200 ring-1 ring-gray-900/5 rounded-lg flex items-top justify-start space-x-6 ">
                                                    <div class="space-y-2">
                                                        <h3 class="text-black font-bold">
                                                            {{ Str::limit($notice->title, 40) }}
                                                        </h3>
                                                        <p class="text-gray-600">
                                                            {{ Str::limit($notice->notice, 100) }}
                                                        </p>
                                                        <div class="grid grid-cols-2 gap-4 content-center">
                                                            <a href="{{ route('institute.notice.single', [$institute->id, $notice->id]) }}"
                                                                class="content-center">
                                                                <p
                                                                    class="block text-indigo-400 font-bold  hover:text-slate-800 transition duration-200">
                                                                    Details <span style="size: 20px">→</span>
                                                                </p>
                                                            </a>

                                                            <div>
                                                                @if ($is_admin)
                                                                <x-button-blank-link
                                                                class="bg-teal-600 float-end ms-3" 
                                                                href="{{ route('institute.notice.edit-form', [$institute, $notice]) }}">
                                                                Edit
                                                                </x-button-blank-link>
                                                                <form action="{{ route('institute.notice.delete', [$institute, $notice]) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <x-button-blank-submit
                                                                        class="bg-red-500 float-end ms-3" href="/">
                                                                        Delete
                                                                    </x-button-blank-submit>
                                                                </form>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <h3 class="text-black font-bold">
                                        No Notice Found
                                    </h3>
                                @endif
                            </div>

                            <div>
                                {{ $notices->links() }}
                            </div>

                        </div>
                    @endif


                    <!-- Institute contact info -->
                    <div class="mt-12">
                        <h2 class="font-bold text-2xl"> Institute Contact Info: </h2>
                        <div class="grid grid-cols-3 gap-4 mt-5">

                            <!-- Mobile Numbers -->
                            <div class="border-l-2 border-indigo-500 px-5">
                                @isset($institute->mobile_numbers)

                                    <h3 class="text-gray-800 text-lg font-bold">Say hello:</h3>

                                    @foreach ($institute->mobile_numbers as $mobile)
                                        <p class="text-gray-700 text-base">
                                            {{ $mobile }}
                                        </p>
                                    @endforeach
                                @else
                                    <h3 class="text-gray-800 text-lg font-bold">Say hello:</h3>
                                    <p class="text-gray-700 text-base">No phone number was given </p>
                                @endisset

                            </div>

                            <div class="border-l-2 border-indigo-500 px-5">

                                @isset($institute->emails)

                                    <h3 class="text-gray-800 text-lg font-bold">Get in touch:</h3>

                                    @foreach ($institute->emails as $email)
                                        <p class="text-gray-700 text-base">
                                            {{ $email }}
                                        </p>
                                    @endforeach
                                @else
                                    <h3 class="text-gray-800 text-lg font-bold">Get in touch:</h3>
                                    <p class="text-gray-700 text-base">No email was given </p>
                                @endisset

                            </div>

                            <div class="border-l-2 border-indigo-500 px-5">

                                <h3 class="text-gray-800 text-lg font-bold">Location:</h3>

                                @if (isset($institute->address_one) || isset($institute->address_two))
                                    @isset($institute->address_one)
                                        <p class="text-gray-700 text-base">
                                            {{ $institute->address_one }}
                                        </p>
                                    @endisset

                                    @isset($institute->address_two)
                                        <p class="text-gray-700 text-base">
                                            {{ $institute->address_two }}
                                        </p>
                                    @endisset
                                @else
                                    <p class="text-gray-700 text-base">No location was given </p>
                                @endisset

                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>




<script>

    document.addEventListener('DOMContentLoaded', function() {
    mainDescriptionText = document.querySelector('#description').innerText;
    var description = mainDescriptionText.substring(0, 300);
    document.querySelector('#description').innerHTML = description + "... " +'<span class="text-gray-600 font-semibold text-sm cursor-pointer" onclick="seeMore()">See more</span>'
    });
    
    function seeMore(){
        document.querySelector('#description').innerHTML = mainDescriptionText + " ";
        let spanButton = document.createElement('span');
        spanButton.setAttribute('onclick', 'seeLess()')
        spanButton.classList.add('text-gray-600', 'font-semibold', 'text-sm', 'cursor-pointer');
        spanButton.innerText = 'See less';
        document.querySelector('#description').appendChild(spanButton);
    }

    function seeLess(){
        var description = mainDescriptionText.substring(0, 300);
        document.querySelector('#description').innerHTML = description + "... " +'<span class="text-gray-600 font-semibold text-sm cursor-pointer" onclick="seeMore()">See more</span>'
    }

</script>





</x-app-layout>
