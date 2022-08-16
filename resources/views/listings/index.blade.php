<x-layout>
    @include('partials._hero')
    @include('partials._search')
    <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">
        @if (count($listings) == 0)
            <h3><i>No list found</i></h3>
        @endif
        @foreach ($listings as $listing)
            {{-- using component --}}
            <x-listing-card :listing="$listing" /> {{-- :listing="$listing"  for passing variable propety but for string listing="$listing" --}}
        @endforeach
    </div>

    <div class="mt-6 pt-4">
        {{ $listings->links() }} {{-- php artisan vendor:publish -> choose paginate -> edit css --}}
    </div>
</x-layout>
