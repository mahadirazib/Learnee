<x-app-layout>



<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="pb-6 bg-white border-b border-gray-200">

              <div class="p-3 text-center leading-4">
                <a class="hover:text-indigo-700"
                href="{{ route('institute.department.classroom.view', [$classroom->institute, $classroom->department, $classroom->id] ) }}">
                  <h2 class="font-bold text-2xl">{{ $classroom->name }} </h2>
                </a>
                <span class="text-sm font-semibold text-gray-700"> in 
                  <a class="hover:text-teal-700"
                  href="{{ route('institute.department.view-single', [$classroom->institute, $classroom->department] ) }}">
                    {{ $classroom->department_name }} 
                  </a>
                  of 
                  <a class="hover:text-green-700"
                  href="{{ route('institute.view-single', $classroom->institute) }}">
                    {{ $classroom->institute_name }} 
                  </a>
                </span>
              </div>

              <x-alert></x-alert>

              <div class="grid grid-cols-6 text-sm font-semibold text-gray-600">
                <div class="cursor-pointer p-3 text-center hover:text-rose-600 hover:bg-rose-50 hover:border-b-2 hover:border-b-rose-600"> Resource </div>
                <div class="cursor-pointer p-3 text-center hover:text-orange-600 hover:bg-orange-50 hover:border-b-2 hover:border-b-orange-600"> Assignment </div>
                <div class="cursor-pointer p-3 text-center hover:text-lime-600 hover:bg-lime-50 hover:border-b-2 hover:border-b-lime-600"> Exam </div>
                <div class="cursor-pointer p-3 text-center hover:text-teal-600 hover:bg-teal-50 hover:border-b-2 hover:border-b-teal-600"> Live Class </div>
                <div class="cursor-pointer p-3 text-center hover:text-sky-600 hover:bg-sky-50 hover:border-b-2 hover:border-b-sky-600"> Attandence </div>
                <div class="cursor-pointer p-3 text-center hover:text-indigo-600 text- hover:bg-indigo-50 hover:border-b-2 hover:border-b-indigo-600"> Notice </div>
              </div>


            </div>
        </div>
    </div>
</div>
</x-app-layout>
