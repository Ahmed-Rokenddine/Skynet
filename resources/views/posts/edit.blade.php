<x-layout>
  <x-card class="p-10 max-w-lg mx-auto mt-24">
    <header class="text-center">
      <h2 class="text-2xl font-bold uppercase mb-1">Edit Post</h2>
      <p class="mb-4">Edit: {{$post->title}}</p>
    </header>

    <form method="POST" action="/posts/{{$post->id}}" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      

      <div class="mb-6">
        <label for="title" class="inline-block text-lg mb-2">Postii Title</label>
        <input type="text" class="border border-gray-200 rounded p-2 w-full" name="title"
          placeholder="Example: Senior Laravel Developer" value="{{$post->title}}" />

        @error('title')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      </div>

      <div class="mb-6">
        <label for="categories" class="inline-block text-lg mb-2">Categories</label>
        <select name="categories[]" multiple class="border border-gray-200 rounded p-2 w-full">
          @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ $post->categories->contains($category->id) ? 'selected' : '' }}>
              {{ $category->name }}
            </option>
          @endforeach
        </select>
      
        @error('categories')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-6">
        <label for="tags" class="inline-block text-lg mb-2">
          Tags (Comma Separated)
        </label>
        <input type="text" class="border border-gray-200 rounded p-2 w-full" name="tags"
          placeholder="Example: Laravel, Backend, Postgres, etc" value="{{$post->tags}}" />

        @error('tags')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      </div>

      <div class="mb-6">
        <label for="logo" class="inline-block text-lg mb-2">
          Company Logo
        </label>
        <input type="file" class="border border-gray-200 rounded p-2 w-full" name="logo" />

        <img class="w-48 mr-6 mb-6"
          src="{{$post->logo ? asset('storage/' . $post->logo) : asset('/images/no-image.png')}}" alt="" />

        @error('logo')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      </div>

      <div class="mb-6">
        <label for="description" class="inline-block text-lg mb-2">
          Postii Description
        </label>
        <textarea class="border border-gray-200 rounded p-2 w-full" name="description" rows="10"
          placeholder="Include tasks, requirements, salary, etc">{{$post->Description}}</textarea>

        @error('description')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      </div>

      <div class="mb-6">
        <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
          Update Post
        </button>

        <a href="/" class="text-black ml-4"> Back </a>
      </div>
    </form>
    
  </x-card>
</x-layout>
