@extends('layouts.index')


@section('content')

    <div class="p-12 relative">
        <h1 class="font-bold text-center text-3xl underline mb-4">Notes : {{$show->title}}</h1>
        <div>
            <div class="border shadow-md rounded-md p-5 relative">
                <div class="absolute top-3 left-3">
                    <a href="/notes/{{$show->id}}/edit" class="bg-green-500 rounded-md px-2 py-1 text-white">
                        Edit
                    </a>
                </div>
                <div class="absolute top-2 right-2 flex">
                    <p class="mx-2">{{$show->like}} likes</p>
                    @php
                        $exist = $userLike->where("note_id", $show->id)->first();
                    @endphp
                    @if ($exist)
                        <form action="/like/{{$show->id}}/unlike" method="POST">
                            @csrf
                            @method("DELETE")
                            <button type="submit">
                                <i class="fas fa-heart text-red-700"></i>
                            </button>
                        </form>
                    @else
                        <form action="/like/{{$show->id}}/like" method="POST">
                            @csrf
                            @method("POST")
                            <button type="submit">
                                <i class="far fa-heart text-gray-700"></i>
                            </button>
                        </form>
                    @endif
                </div>
                <div class="p-10">
                    <p class="py-3">{!! $show->content !!}</p>
                </div>
                @foreach ($show->tags as $tag)
                    <span class="rounded-full bg-gray-400 text-white px-2 py-1">{{$tag->tag}}</span>
                @endforeach
            </div>
        </div>
        <div class="py-7">
            @if (Auth::user()->id == $show->users[0]->id)
                <form action="/note/{{$show->id}}/share" method="POST" class="flex flex-col gap-3 items-center">
                    @csrf
                    @method("POST")
                    <div class="flex flex-col items-center">
                        <label for="email">Insérez le mail de l'utilisateur avec lequel vous voulez partager cette note</label>
                        <input type="text" name="email" placeholder="email" class="rounded-md w-96 mt-3">
                    </div>
                    <div>
                        <button type="submit" class="rounded-md bg-blue-700 text-white px-2 py-1">
                            Share <i class="fas fa-share text-white"></i>
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection