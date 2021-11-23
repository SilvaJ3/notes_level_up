@extends('layouts.flash')
@extends('layouts.index')


@section('content')

    {{-- Partie Concours --}}
    @if ($end > $now)
        <div class="flex flex-col justify-center items-center py-2 bg-red-400">
            <h1>Un concours est en cours actuellement...</h1>
            <form action="/note/{{$show->id}}/contest" method="POST">
                @csrf
                @method("POST")
                <button type="submit" class="text-blue-600 hover:text-blue-800">
                    Participer avec cette note
                </button>
            </form>
        </div>
    @endif
    <div class="py-12 lg:px-72 px-32 relative">
        <div>
            <div class="border-8 shadow-lg p-5 relative">
                @if (Auth::user())
                    <div class="absolute top-3 left-3 flex items-center">
                        @if (Auth::user()->id == $author->id || $editor)
                        <a href="/notes/{{$show->id}}/edit" class="bg-green-500 rounded-md px-2 py-1 text-white">
                            Edit
                        </a>
                        @endif
                        @if (Auth::user()->id == $author->id)
                            <form action="/notes/{{$show->id}}" method="POST" class="mx-2">
                                @csrf
                                @method("DELETE")
                                <button type="submit">
                                    <i class="fas fa-trash hover:text-red-700"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
                <div class="absolute top-2 right-2 flex">
                    <p class="mx-2">
                        @if ($show->like <= 1)
                        {{$show->like}} like
                        @else
                        {{$show->like}} likes
                        @endif</p>
                        @if (Auth::user())
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
                        @endif
                </div>
                <div class="lg:p-10 p-5">
                    <p class="text-indigo-500 text-2xl font-medium">
                        {{ $show->title}}
                    </p>
                    <p class="py-3">
                        {!! $show->content !!}
                    </p>
                </div>
                <div class="p-10">
                    @php
                        $user_id = $pivot->where("note_id", $show->id)->where("role_notes_id", 1)->first()->user_id;
                        $user = $users->where("id", $user_id)->first();
                    @endphp
                    <p>Ecrit par : {{$user->name}}</p>
                </div>
                @foreach ($show->tags as $tag)
                    <span class="rounded-full bg-gray-400 text-white px-2 py-1">{{$tag->tag}}</span>
                @endforeach
            </div>
        </div>
        <div class="py-7">
            @if (Auth::user())
                @if (Auth::user()->id == $author->id)
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
            @endif
        </div>
    </div>
@endsection