<form method="POST" class="m-4">
    <!-- CSRF token for form protection. -->    
    @csrf
    
        <label class="block flex justify-end p-1">
            <span class="mr-2">Country Name</span>
            <input type="text" name="country_name" value="{{Request::input('country_name')}}" class="w-32 appearance-none block bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
        </label>
        <label class="block flex justify-end p-1">
            <span class="mr-2">Country Code</span>
            <input type="text" name="country_code" value="{{Request::input('country_code')}}" class="w-32 appearance-none block bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
        </label>
        <label class="block flex justify-end p-1">
            <span class="mr-2">Capital City</span>
            <input type="text" name="capital" value="{{Request::input('capital')}}" class="w-32 appearance-none block bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
        </label>
        <label class="block flex justify-end p-1">
            <span class="mr-2">Currency Code</span>
            <input type="text" name="currency" value="{{Request::input('currency')}}" class="w-32 appearance-none block bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
        </label>
        <label class="block flex justify-end p-1">
            <span class="mr-2">Language</span>
            <input type="text" name="language" value="{{Request::input('language')}}" class="w-32 appearance-none block bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
        </label>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"> Search</button>
</form>