<x-app-layout>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">


                <x-alert> </x-alert>

                <!-- Institute Name and date created -->
                <div class="grid grid-cols-1 mb-5">
                    <div>
                        <h1 class="font-bold text-2xl inline">
                            <a href="{{ route('institute.department.view-single', [$department->institute_id, $department->id] ) }}" class=" text-blue-600">
                                {{ $department->name }}
                            </a>
                        </h1>
                        <h2 class="font-bold text-xl text-gray-600 inline">of <a class="text-lime-600"
                                href="{{ route('institute.view-single', $department->institute_id) }}">{{ $department->institute_name }}</a>
                        </h2>
                        <div>
                            <span class="text-sm text-gray-500"> Department created:
                                {{ $department->created_at->format('j F, Y') }}
                            </span>
                        </div>
                    </div>

                </div>

                <div class="mb-5 mt-5">
                    <hr>
                </div>

                <div class="grid grid-cols-4 gap-4">

                    <div class="col-span-3">
                        <h1 class="font-bold text-4xl mb-8" style="margin: 0"> {{ $classroom->name }} </h1>
                        <span class="text-sm text-gray-500"> Classroom created: {{ $classroom->created_at->format('j F, Y') }}
                        </span>
                    </div>
    
                    <div class="ms-auto"> 
                        @if ($is_admin)
                            <x-link-button class="mt-4 " href="">
                                Edit class
                            </x-link-button>
                        @elseif (!$is_class_member)
                            <x-button-blank-link class="outline outline-2 text-gray-800 bg-gray-800 ms-auto" href="{{ route('institute.department.classroom.join', [$department->institute_id, $department->id, $classroom->id] ) }}">
                                Join class
                            </x-button-blank-link>
                        
                        @endif
                    </div>

                </div>

                <!-- CLassroom description -->
                <div class="mt-5">
                    <div class="textWithLines" id="description">{{ $classroom->description }}</div>
                </div>

                @if (isset($classroom->topics) && $classroom->topics != null)
                    <div class="mt-5">
                        <h3 class="font-semibold mb-2">Topics of this classroom:</h3>
                        @foreach ($classroom->topics as $topics)
                            <span class="bg-gray-200 text-black px-3 py-1 rounded cursor-pointer hover:bg-gray-300 me-3">
                                {{ $topics }}
                            </span>
                        @endforeach
                    </div>
                @endif


                @if (isset($notices) && $notices != null)
                <!-- Department Notices -->
                  <div class="mt-10">

                    <div class="grid grid-cols-2 gap-4 content-center">
                        <h2 class="font-bold text-2xl"> Notices: </h2>
                        <div class="content-center">
                            <div class="">
                                <div class="flex content-center float-end">
                                    <a href=" {{ route('institute.department.classroom.notice.list', [$classroom->institute, $classroom->department, $classroom->id]) }} "
                                    class="ms-auto ml-4 content-center text-gray-600 hover:text-gray-800 font-bold">See all ❯</a>
                                </div>
                            </div>
                            
                            <div class=" float-end me-5">
                                @if ($is_admin)
                                    <x-button-blank-link class="outline outline-2 text-gray-800 bg-gray-800 ms-auto" href="{{route('institute.department.classroom.notice.create', [$classroom->institute, $classroom->department, $classroom->id] )}}">
                                        Add new Notice
                                    </x-button-blank-link>
                                @endif
                            </div>

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
                                                    <a href="{{ route('institute.department.classroom.notice.view', [$classroom->institute, $classroom->department, $classroom->id, $notice->id]) }}"
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
                                                        href="{{ route('institute.department.classroom.notice.edit', [ $classroom->institute, $classroom->department, $classroom->id, $notice->id]) }}">
                                                        Edit
                                                        </x-button-blank-link>
                                                        <form action="{{ route('institute.department.classroom.notice.delete', [$classroom->institute, $classroom->department, $classroom->id, $notice->id]) }}" method="POST">
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



            </div>
        </div>
    </div>
</div>




<script>

    document.addEventListener('DOMContentLoaded', function() {
    mainDescriptionText = document.querySelector('#description').innerText;
    var description = mainDescriptionText.substring(0, 300);
    document.querySelector('#description').innerHTML = description + "... " +'<span class="text-gray-600 font-bold text-sm cursor-pointer" onclick="seeMore()">See more</span>'
    });
    
    function seeMore(){
        document.querySelector('#description').innerHTML = mainDescriptionText + " ";
        let spanButton = document.createElement('span');
        spanButton.setAttribute('onclick', 'seeLess()')
        spanButton.classList.add('text-gray-600', 'font-bold', 'text-sm', 'cursor-pointer');
        spanButton.innerText = 'See less';
        document.querySelector('#description').appendChild(spanButton);
    }
  
    function seeLess(){
        var description = mainDescriptionText.substring(0, 300);
        document.querySelector('#description').innerHTML = description + "... " +'<span class="text-gray-600 font-bold text-sm cursor-pointer" onclick="seeMore()">See more</span>'
    }
  
  </script>



</x-app-layout>