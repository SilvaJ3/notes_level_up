
@extends('layouts.index')


@section('content')
        
    <div class="py-12 lg:px-44 md:px-36 px-10">
        <div class="grid xl:grid-cols-3 lg:grid-cols-2 gap-4 grid-cols-1">
                @foreach ($filter as $note)
                        <!-- card -->
                        <div class="overflow-hidden shadow-lg transition duration-500 ease-in-out transform hover:-translate-y-5 hover:shadow-2xl rounded-lg h-full w-60 md:w-80 m-auto bg-white">
                                <div class="w-full p-4 relative">
                                    <div class="absolute top-2 right-2 flex">
                                        @if (Auth::user())
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
                                                            <i class="far fa-heart text-gray-700 hover:text-red-700"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </a>
                                        @endif
                                        <p class="mx-2">
                                            @if ($note->like <= 1)
                                                {{$note->like}} like
                                            @else
                                                {{$note->like}} likes
                                            @endif
                                        </p>
                                    </div>
                                    <p class="text-indigo-500 text-2xl font-medium">
                                        {{$note->title}}
                                    </p>
                                    <p class="text-gray-600 font-light text-md">
                                        {!!Str::limit($note->content, 100)!!}
                                    </p>
                                    <a class="inline-flex text-indigo-500 font-light" href="/notes/{{$note->id}}">Read More</a>
                                    <div class="flex flex-wrap justify-starts items-center py-3 border-b-2 text-xs text-white font-medium">
                                        @foreach ($note->tags as $tag)
                                            <a href="/tags/{{$tag->id}}" class="m-1 px-2 py-1 rounded bg-indigo-500">
                                                #{{Str::limit($tag->tag, 10)}}
                                            </a>
                                        @endforeach
                                    </div>
                                    @php
                                        $user_id = $pivot->where("user_id", Auth::user()->id)->first()->user_id;
                                        $user = $users->where("id", $user_id)->first();
                                    @endphp
                                    <div class="flex items-center mt-2">
                                        <img class='w-10 h-10 object-cover rounded-full' alt='User avatar' src='{{asset("img/".$user->image)}}'>
                            
                                        <div class="pl-3">
                                            <div class="font-medium">
                                                {{$user->name}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        
                @endforeach
            </div>
        </div>
    </div>    

@endsection

