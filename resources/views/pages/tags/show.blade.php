@extends('layouts.index')


@section('content')
        
    <div class="container mx-auto px-4 sm:px-8 max-w-3xl">
        <div class="py-8">
            <div class="flex flex-col mb-1 sm:mb-0 justify-between w-full">
                <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                    <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-2 py-3 bg-white  border-b border-gray-200 text-gray-800  text-center text-sm uppercase font-normal">
                                        Author
                                    </th>
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
                                @foreach ($filter as $note)
                                    <tr>
                                        <td class="px-2 py-3 border-b border-gray-200 bg-white text-sm text-center w-32">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                @php
                                                    $user_id = $pivot->where("note_id", $note->id)->where("role_notes_id", 1)->first()->user_id;
                                                    $user = $users->where("id", $user_id)->first();
                                                @endphp
                                                {{$user->name}}
                                            </p>
                                        </td>
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
                                                    <a href="/tags/{{$tag->id}}" class="rounded-full bg-gray-400 text-white px-2 py-1 overflow-hidden">{{$tag->tag}}</a>
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
                                            <p class="mx-2">{{$note->like}} likes</p>
                                        </td>
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
            </div>
        </div>

    </div>
@endsection
