@extends('welcome')

@section('content')
        
    <div class="container mx-auto py-20 px-44 sm:px-8 flex">
        <div class="py-8">
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
                    @foreach ($notes as $note)
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
                                </p>
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
            {{-- Pagination --}}

            <div>
                {{$notes->links("vendor.pagination.custom")}}
            </div>
        </div>
        <div class="py-8 ml-10">
            <h1 class="underline mb-3">Tags :</h1>
            <div class="border p-5 w-44">
                <ul>
                    @foreach ($tags as $tag)
                    @if (count($tag_pivot->where("tag_id", $tag->id)) > 0)
                        <li>
                            <a href="/tags/{{$tag->id}}" class="hover:text-blue-700">
                                {{count($tag_pivot->where("tag_id", $tag->id))}} - {{$tag->tag}}
                            </a>
                        </li>
                    @endif
                    @endforeach
                    <hr class="my-3">
                    <li class="text-center">
                        <a href="/tags/create" class="hover:text-blue-900">
                            Ajouter un tag
                        </a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
@endsection