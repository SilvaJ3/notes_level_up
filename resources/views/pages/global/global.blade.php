@extends('welcome')

@section('content')
        
    {{-- Partie concours --}}
    @if (Auth::user())
        <div class="flex flex-col justify-center items-center bg-red-400 py-2">
            <h1 class="text-black text-2xl">Le concours se termine le {{date('d/m/Y', $end)}} à {{date('H:i:s', $end)}}</h1>
            <span>Participez au concours en soumettant votre note</span>
        </div>
    @endif
    <div class="container w-full mx-auto py-10 px-44 sm:px-8 flex">
        <div class="py-8 w-5/6">
            <div class="grid xl:grid-cols-3 lg:grid-cols-2 gap-4 grid-cols-1">
                @foreach ($notes as $note)
                        <!-- card -->
                        <div class="overflow-hidden shadow-lg transition duration-500 ease-in-out transform hover:-translate-y-5 hover:shadow-2xl rounded-lg h-full w-60 md:w-80 m-auto bg-white">
                                <div class="w-full p-4 relative">
                                    <div class="absolute top-2 right-2 flex">
                                        @if (Auth::user())
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900">
                                            @php
                                                // On vérifie si l'user a déjà liké cette note
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
                                        $user_id = $pivot->where("note_id", $note->id)->where("role_notes_id", 1)->first()->user_id;
                                        $user = $users->where("id", $user_id)->first();
                                    @endphp
                                    <div class="flex items-center mt-2">
                                        <img class='w-10 h-10 object-cover rounded-full' alt='User avatar' src='{{asset("img/".$user->image)}}'>
                            
                                        <div class="pl-3">
                                            <div class="font-medium">
                                                {{$user->name}}
                                                @if ($note->contest == True)
                                                    🎫
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        
                @endforeach
            </div>
            {{-- Pagination --}}

            <div>
                {{$notes->links("vendor.pagination.custom")}}
            </div>
        </div>
        <div class="py-8 ml-10 w-1/6">
            <h1 class="underline mb-3 text-center text-xl">Tags</h1>
            <div class="border p-5 w-44 h-96 overflow-y-auto">
                <ul>
                    @foreach ($tags as $tag)
                        @if (count($tag_pivot->where("tag_id", $tag->id)) > 0)
                            <li>
                                <a href="/tags/{{$tag->id}}" class="hover:text-blue-700">
                                    > {{ Str::limit($tag->tag, 10) }} - {{count($tag_pivot->where("tag_id", $tag->id))}} 
                                </a>
                            </li>
                        @endif
                    @endforeach
                    @if (Auth::user())
                        <hr class="my-3">

                        <li class="text-center">
                            <a href="/tags/create" class="hover:text-blue-900">
                                Ajouter un tag
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

    </div>
@endsection