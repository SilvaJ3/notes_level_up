@extends('layouts.index')


@section('content')

    <div class="py-12 px-44 relative">
        <div class="absolute top-3 right-0 pr-1">
            <a href="/notes/create" class="px-4 py-3 text-white transition-colors duration-200 transform bg-blue-700 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">
                <i class="fas fa-plus mt-2"></i>
            </a>
        </div>
        <h1 class="font-bold text-center text-3xl underline mb-4">Vos notes :</h1>
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th scope="col" class="px-2 py-3 bg-white  border-b border-gray-200 text-gray-800  text-center text-sm uppercase font-normal">
                        Title
                    </th>
                    <th scope="col" class="px-2 py-3 bg-white  border-b border-gray-200 text-gray-800  text-center text-sm uppercase font-normal">
                        Content
                    </th>
                    <th scope="col" class="px-2 py-3 bg-white  border-b border-gray-200 text-gray-800  text-center text-sm uppercase font-normal">
                        Tags
                    </th>
                    <th scope="col" class="px-2 py-3 bg-white  border-b border-gray-200 text-gray-800  text-center text-sm uppercase font-normal">
                        Likes
                    </th>
                    <th scope="col" class="px-2 py-3 bg-white  border-b border-gray-200 text-gray-800  text-center text-sm uppercase font-normal">
                        Read
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notes as $note)
                    <tr>
                        <td class="px-2 py-3 border-b border-gray-200 bg-white text-sm text-center">
                            <p class="text-gray-900 whitespace-no-wrap">
                                {{$note->title}}
                            </p>
                        </td>
                        <td class="px-2 py-3 border-b border-gray-200 bg-white text-sm text-center">
                            <p class="text-gray-900 whitespace-no-wrap">
                                {!!Str::limit($note->content, 100)!!}
                            </p>
                        </td>
                        <td class="px-2 py-3 border-b border-gray-200 bg-white text-sm text-center w-32">
                            <div class="grid grid-cols-1 gap-1">
                                @foreach ($note->tags as $tag)
                                    <a href="/tags/{{$tag->id}}" class="rounded-full bg-gray-400 text-white px-2 py-1 overflow-hidden">{{Str::limit($tag->tag, 10)}}</a>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-2 py-3 border-b border-gray-200 bg-white text-sm text-center w-20">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900">
                                @php
                                    $exist = $userLike->where("note_id", $note->id)->first();
                                @endphp
                                @if ($exist)
                                    <form action="/like/{{$note->id}}/unlike" method="POST" class="flex justify-center">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit">
                                            <i class="fas fa-heart text-red-700"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="/like/{{$note->id}}/like" method="POST" class="flex justify-center">
                                        @csrf
                                        @method("POST")
                                        <button type="submit">
                                            <i class="far fa-heart text-gray-700"></i>
                                        </button>
                                    </form>
                                @endif
                            </a>
                            <p class="mx-2">
                                @if ($note->like <= 1)
                                    {{$note->like}} like
                                @else
                                    {{$note->like}} likes
                                @endif
                            </p>                        </td>
                        <td class="px-2 py-3 border-b border-gray-200 bg-white text-sm text-center">
                            <a href="/notes/{{$note->id}}">
                                <i class="fas fa-glasses"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
@endsection