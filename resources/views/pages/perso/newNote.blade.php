@extends('layouts.index')

@section('content')

    <div class="container-fluid p-20 flex justify-center">
        <form action="/notes" method="POST">
            @csrf
            <div class="grid gris-cols-1 gap-4 px-20">
                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="title">Title</label>
                    <input id="title" name="title" type="text" value="{{old("title")}}" class="block w-96 px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-yellow-200 dark:focus:border-yellow-200 focus:outline-none focus:ring">
                </div>
                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="content">Content</label>
                    <textarea class="form-control" id="summary_ckeditor" name="summary_ckeditor">{{old("content")}}</textarea>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-4 px-20 mt-3">
                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="tag1">Tag #1</label>
                    <select id="tag1" name="tag1" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-yellow-200 dark:focus:border-yellow-200 focus:outline-none focus:ring">
                        @foreach ($tags as $tag)
                            <option value="{{$tag->id}}">{{Str::ucfirst($tag->tag)}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="tag2">Tag #2</label>
                    <select id="tag2" name="tag2" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-yellow-200 dark:focus:border-yellow-200 focus:outline-none focus:ring">
                        @foreach ($tags as $tag)
                            <option value="{{$tag->id}}">{{Str::ucfirst($tag->tag)}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="tag3">Tag #3</label>
                    <select id="tag3" name="tag3" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-yellow-200 dark:focus:border-yellow-200 focus:outline-none focus:ring">
                        @foreach ($tags as $tag)
                            <option value="{{$tag->id}}">{{Str::ucfirst($tag->tag)}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-center mt-6 px-6">
                <button class="bg-blue-600 hover:bg-blue-700 px-3 py-2 text-white">Create</button>
            </div>
        </form>
    </div>
    
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
    CKEDITOR.replace( 'summary_ckeditor' );
    </script>
@endsection


{{-- block w-96 px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-yellow-200 dark:focus:border-yellow-200 focus:outline-none focus:ring --}}