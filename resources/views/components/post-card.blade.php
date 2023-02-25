@props(['post'])

<x-card>
  <div class="flex">
    <img class="hidden w-48 mr-6 md:block"
      src="{{$post->logo ? asset('storage/' . $post->logo) : asset('/images/no-image.png')}}" alt="" />
    <div>
      <h3 class="text-2xl">
        <a href="/posts/{{$post->id}}" >{{$post->title}}</a>
      </h3>
      <div class="text-xl font-bold mb-4">{{$post->company}}</div>
      <x-post-tags :tagsCsv="$post->tags"        />
      <ul>
          @foreach($post->categories as $category)
              <li>{{ $category->name }}</li>
          @endforeach
      </ul>
  
      
      <div class="text-lg mt-4">
        <i class="fa-solid fa-user"></i> {{$post->user->name}}
      </div>
      
    </div>
  </div>
</x-card>