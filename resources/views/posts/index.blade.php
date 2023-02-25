<x-layout>
  @if (!Auth::check())
    @include('partials._hero')
  @endif

  @include('partials._search')

  <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">

    @unless(count($posts) == 0)

    @foreach($posts as $post)
    <x-post-card :post="$post" />
    @endforeach
   
    @else
    <p>No posts found</p>
    @endunless

  </div>

  <div class="mt-6 p-4">
    {{$posts->links()}}
  </div>
</x-layout>
