
<!-- Navigation Links -->
    <header class=" bg-gray-100">
        <nav class="flex items-center justify-between p-6 h-20 bg-white shadow-sm">
        <div class="py-5 px-3 rounded-md bg-gradient-to-r from-black to-gray-500 text-sm text-white font-semibold shadow-lg hover:cursor-pointer hover:shadow-lg">LEVEL NOTE</div>
        <ul>
            <li class="space-x-5 text-xl">
                <a href="/notes" class="hidden sm:inline-block text-gray-700 hover:text-indigo-700">Home</a>
                <a href="/perso" class="hidden sm:inline-block text-gray-700 hover:text-indigo-700">Vos notes</a>
                <a href="/liked" class="hidden sm:inline-block text-gray-700 hover:text-indigo-700">Notes likées</a>
                <a href="/shared" class="hidden sm:inline-block text-gray-700 hover:text-indigo-700">Notes partagées</a>
                <form method="POST" action="{{ route('logout') }}" class="hidden sm:inline-block text-gray-700 hover:text-indigo-700">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                    this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </li>
            <div class="sm:hidden space-y-1 hover:cursor-pointer">
            <span class="w-10 h-1 bg-gray-600 rounded-full block"></span>
            <span class="w-10 h-1 bg-gray-600 rounded-full block"></span>
            <span class="w-10 h-1 bg-gray-600 rounded-full block"></span>
            </div>
        </ul>
        </nav>

    </header>
