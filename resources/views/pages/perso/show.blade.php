@extends('layouts.index')


@section('content')

    <div class="p-12 relative">
        <h1 class="font-bold text-center text-3xl underline mb-4">Notes : {{$show->title}}</h1>
        <div>
            <div class="border shadow-md rounded-md p-5 relative">
                <div class="absolute top-2 right-2 flex">
                    <p class="mx-2">{{$show->like}} likes</p>
                    <button>
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                <div class="p-10">
                    <p class="py-3">{{$show->content}}</p>
                </div>
                @foreach ($show->tags as $tag)
                    <span class="rounded-full bg-gray-400 text-white px-2 py-1">{{$tag->tag}}</span>
                @endforeach
            </div>
        </div>
    </div>
@endsection