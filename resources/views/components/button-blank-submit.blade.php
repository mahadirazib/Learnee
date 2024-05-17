
<button {{ $attributes->merge(['type' => 'submit','class' => "inline-flex items-center px-4 py-2 hover:bg-gray-700 text-white text-sm font-medium rounded-md"]) }}>

	{{ $slot }}

</button>
