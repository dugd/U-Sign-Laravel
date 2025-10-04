<nav class="px-4 py-3">
    <ul class="flex space-x-4">
        @foreach ($menuItems as $item)
            <li><a class="hover:text-indigo-600" href="{{ $item['url'] }}">{{ $item['title'] }}</a></li>
        @endforeach
    </ul>
</nav>
