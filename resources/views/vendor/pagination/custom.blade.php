@if ($paginator->hasPages())
    <ul class="flex justify-center mt-5">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <span class="flex items-center px-4 py-2 mx-1 text-gray-500 bg-white rounded-md dark:bg-gray-800 dark:text-gray-600">Précédent</span>
            </li>
        @else
            <li class="page-item">
                <a href="{{$paginator->previousPageUrl()}}" class="flex items-center px-4 py-2 mx-1 text-gray-500 bg-white hover:bg-gray-200 hover:text-white rounded-md dark:bg-gray-800 dark:text-gray-600" rel="prev">Précédent</a>
            </li>
        @endif

        {{-- number page --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link">{{$element}}</span></li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active my-active">
                            <span class="flex items-center px-4 py-2 mx-1 text-white transition-colors duration-200 transform bg-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-indigo-500 hover:text-white dark:hover:text-gray-200">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a href="{{ $url }}" class="flex items-center px-4 py-2 mx-1 text-gray-700 transition-colors duration-200 transform bg-white rounded-md dark:bg-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-indigo-500 hover:text-white dark:hover:text-gray-200">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- next --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a href="{{$paginator->nextPageUrl()}}" class="flex items-center px-4 py-2 mx-1 text-gray-500 bg-white hover:bg-gray-200 hover:text-white rounded-md dark:bg-gray-800 dark:text-gray-600" rel="next">Suivant</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="flex items-center px-4 py-2 mx-1 text-gray-500 bg-white rounded-md dark:bg-gray-800 dark:text-gray-600">Suivant</span>
            </li>
        @endif

    </ul>
@endif