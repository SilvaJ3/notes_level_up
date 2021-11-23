@extends('layouts.flash')
@extends('layouts.index')

@section('content')

    <div class="container-fluid p-20 flex justify-center">
        <form action="/tags" method="POST">
            @csrf
            <div class="grid gris-cols-1 gap-4 px-20">
                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="tag">Tag</label>
                    <input id="tag" name="tag" max="20" type="text" value="{{old("tag")}}" class="block w-96 px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-yellow-200 dark:focus:border-yellow-200 focus:outline-none focus:ring">
                    @error("tag")
                        <div class="text-red-600">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="flex justify-center mt-6 px-6">
                @if (Auth::user()->role_id == 1 || (Auth::user()->credits >= 30 && Auth::user()->role_id == 2))
                    <button class="bg-blue-600 hover:bg-blue-700 px-3 py-2 text-white">Create</button>
                @else
                    <span class="bg-blue-600 hover:bg-blue-700 px-3 py-2 text-white">Il vous faut 30 crédits pour créer un tag</span>
                @endif
            </div>
        </form>
    </div>
@endsection

