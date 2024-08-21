<x-app-layout>

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

                <h1 class="font-semibold text-xl mb-8" style="margin: 0 0 15px"> {{ $classroom->name }} </h1>


            </div>
        </div>
    </div>
</div>

</x-app-layout>