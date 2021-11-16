@extends('layouts.index')


@section('content')

    <div class="p-12 relative">
        <div class="absolute top-3 right-0 pr-1">
            <a href="/notes/create" class="px-4 py-3 text-white transition-colors duration-200 transform bg-blue-700 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">
                <i class="fas fa-plus mt-2"></i>
            </a>
        </div>
        <h1 class="font-bold text-center text-3xl underline mb-4">Vos notes :</h1>
        <div class="grid grid-cols-3 gap-4">
            @foreach ($notes as $note)
                <div class="border shadow-md rounded-md px-8 py-10 relative">
                    <div class="absolute top-2 right-2 flex">
                        <p class="mx-2">{{$note->like}} likes</p>
                        @php
                            $exist = $userLike->where("note_id", $note->id)->first();
                        @endphp
                        @if ($exist)
                            <form action="/like/{{$note->id}}/unlike" method="POST">
                                @csrf
                                @method("DELETE")
                                <button type="submit">
                                    <i class="fas fa-heart text-red-700"></i>
                                </button>
                            </form>
                        @else
                            <form action="/like/{{$note->id}}/like" method="POST">
                                @csrf
                                @method("POST")
                                <button type="submit">
                                    <i class="far fa-heart text-gray-700"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                    <a href="/notes/{{$note->id}}">
                        <h1 class="underline text-xl font-semibold pt-2">{{Str::limit($note->title, 30)}}</h1>
                        <p class="py-3">{!!Str::limit($note->content, 100)!!}</p>
                    </a>
                    @foreach ($note->tags as $tag)
                        <span class="rounded-full bg-gray-400 text-white px-2 py-1 mr-3">{{$tag->tag}}</span>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endsection