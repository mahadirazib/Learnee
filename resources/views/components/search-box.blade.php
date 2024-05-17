<form class="">   
  <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
  <div class="flex items-center rounded-md box-border">
    <input type="search" 
    name="query"
    placeholder="Search..." 
    value="{{ $slot }}"
    class="w-full px-4 py-2 border border-gray-200 focus:border-sky-200 active:border-sky-200 rounded-l-md me-1" 
    required/>
    <button class="px-4 py-2 border rounded-r-md hover:bg-indigo-500 hover:font-bold hover:text-white ">
      Search
    </button>
  </div>
</form>