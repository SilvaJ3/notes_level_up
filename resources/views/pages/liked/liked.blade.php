@extends('layouts.index')


@section('content')
    @if ($likeds_list)
        <div class="p-12 grid grid-cols-3 gap-4">
            @foreach ($likeds_list as $note)
                <div class="border shadow-md rounded-md p-5 relative">
                    <div class="absolute top-2 right-2 flex">
                        <p class="mx-2">{{$note->like}} likes</p>
                        <form action="/like/{{$note->id}}/unlike" method="POST">
                            @csrf
                            @method("DELETE")
                            <button type="submit">
                                <i class="fas fa-heart text-red-700"></i>
                            </button>
                        </form>
                    </div>
                    <a href="/notes/{{$note->id}}">
                        <h1 class="underline text-xl font-semibold pt-2">{{$note->title}}</h1>
                        <p class="py-3">{{Str::limit($note->content, 100)}}</p>
                    </a>
                    <p class="py-3">{{Str::ucfirst($note->role_notes[0]->role_notes)}} : {{$note->users[0]->name}}</p>
                    @foreach ($note->tags as $tag)
                        <span class="rounded-full bg-gray-400 text-white px-2 py-1 mr-3">{{$tag->tag}}</span>
                    @endforeach
                </div>
            @endforeach
        </div>
    @else
        <div class="p-20">
            <h1 class="font-bold text-black text-center text-2xl">
                Vous n'avez pas encore de notes likées
            </h1>
        </div>
    @endif
@endsection