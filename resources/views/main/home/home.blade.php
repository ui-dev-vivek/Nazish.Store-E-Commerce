<x-layout.main.base>

    @foreach ($categories as $category)
        {{ $category->name }} <br>
        @foreach ($category->children as $subCategory)
            ---{{ $subCategory->name }} <br>
        @endforeach
    @endforeach

</x-layout.main.base>
