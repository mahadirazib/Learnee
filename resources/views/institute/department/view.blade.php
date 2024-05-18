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
                          <h1 class="font-bold text-4xl">{{$department->name}}</h1> 
                          <h2 class="font-bold text-2xl ">of <a class="text-lime-600" href="{{ route('institute.view-single', $department->institute ) }}">{{ $department->institute_name }}</a> </h2>
                          <span class="text-sm text-gray-500"> Department created: {{ $department->created_at->format('j F, Y') }}
                          </span>
                      </div>

                      <div class="ms-auto"> 
                        @if ($is_admin)
                            <x-link-button class="mt-4 " href="{{ route('institute.department.edit-form', [ $institute, $department ]) }}">
                                Edit Dept.
                            </x-link-button>
                        @elseif (!$is_department_member)

                            <x-button-blank-link class="outline outline-2 text-gray-800 bg-gray-800 ms-auto" href="{{ route('institute.department.join', [$institute, $department]) }}">
                                Join Dept.
                            </x-button-blank-link>
                        
                        @endif
                      </div>

                  </div>



                  <!-- Department description -->
                  <div class="mt-5">
                      <div class="textWithLines" id="description">{{ $department->description }}</div>
                  </div>



                  <!-- Department Notice -->
                  @if (isset($notices) && $notices != null)
                    <div class="mt-10">
                        <div class="grid grid-cols-2 gap-4 content-center">
                            <h2 class="font-bold text-2xl"> Notices: </h2>
                            <div class="font-bold grid content-end">

                                <div class="flex float-end">
                                    <a href=" {{ route('institute.notice.all', $institute) }} "
                                        class="ms-auto ml-4 content-center text-gray-600 hover:text-gray-800">See all ❯</a>

                                </div>
                            </div>
                        </div>
                        <div class="mt-5 mb-5">
                            @if ($is_admin)
                            <x-button-blank-link class="outline outline-2 text-gray-800 bg-gray-800 ms-auto" href="{{route('institute.department.notice.create', [$institute, $department])}}">
                                Add new Notice
                            </x-button-blank-link>
                            @endif
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
                                                        <a href="{{ route('institute.notice.single', [$institute, $notice->id]) }}"
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

                  <div>
                    <h3 class="font-bold text-2xl mt-8"> Subjects: </h3>
                    <div class="mt-3 w-full overflow-x-auto">
                        @isset($department->subjects)
                        <table class="border-collapse table-auto text-sm w-full" style="min-width: 500px">
                            <thead>
                              <tr class="bg-gray-200">
                                <th class="border-collapse border p-1">No.</th>
                                <th class="border-collapse border p-1">Subject</th>
                                <th class="border-collapse border p-1">Reward</th>
                              </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach ($department->subjects as $subject => $reward)
                                    <tr>
                                        <td class="border-collapse border p-1 ps-3">{{ $counter++ }}</td>
                                        <td class="border-collapse border p-1 ps-3">{{ $subject }}</td>
                                        <td class="border-collapse border p-1 ps-3">{{ $reward }}</td>
                                    </tr>
                                {{-- <div class="bg-gray-200 text-black px-3 py-1 rounded cursor-pointer hover:bg-gray-700 hover:text-white">
                                    {{ $subject }}
                                </div> --}}
                                @endforeach
                            </tbody>
                        </table>
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
