@extends('layouts.flash')
@extends('layouts.index')

@section('content')

    <div class="flex flex-col min-h-full items-center justify-center py-36">

            <div class="border rounded-md bg-gray-800 w-96 h-44 p-3 text-white relative flex">
                <div class="w-2/5">
                    <img src="{{asset("/img/" . Auth::user()->image )}}" alt="" class="rounded-full border-4 border-white w-36 h-36">
                </div>
                <div class="w-3/5 px-3">
                    <h1>Nom : {{Auth::user()->name}}</h1>
                    <h1>Email : {{Auth::user()->email}}</h1>
                    <h1>Likes : 
                        @if (Auth::user()->likes > 0)
                            {{Auth::user()->likes}}
                            <i class="fas fa-heart text-red-700"></i>
                        @else
                            {{Auth::user()->likes}}
                            <i class="far fa-heart text-gray-700"></i>
                        @endif
                    </h1>
                    <h1>Crédits : {{Auth::user()->credits}} 🪙</h1>
                </div>
            </div>

            <div class="pt-5">
                <h1 class="text-center text-black font-bold text-2xl mb-4">ShopiyShop</h1>
                <div class="grid grid-cols-3 gap-4">
                    <div class="border flex flex-col justify-center items-center p-5">
                        <h1>Acheter un <i class="fas fa-heart text-red-600"></i></h1>
                        @if (Auth::user()->credits >= 2)
                            <form action="/shop/{{Auth::user()->id}}/like" method="POST" class="flex justify-center mt-3">
                                @csrf
                                @method("POST")
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-3 py-2 text-white">
                                    BUY - 2 🪙
                                </button>
                            </form>
                        @else
                            
                        @endif
                    </div>
                </div>
            </div>

    </div>
@endsection