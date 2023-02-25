<x-layout>
  <a href="/" class="inline-block text-black ml-4 mb-4"><i class="fa-solid fa-arrow-left"></i> Back
  </a>
  <div class="mx-4">
    <x-card class="p-10">
      <div class="flex flex-col items-center justify-center text-center">
        <img class="w-48 mr-6 mb-6"
          src="{{$post->logo ? asset('storage/' . $post->logo) : asset('/images/no-image.png')}}" alt="" />

        <h3 class="text-2xl mb-2">
          {{$post->title}}
        </h3>
        <div class="text-xl font-bold mb-4">{{$post->company}}</div>

        <x-post-tags :tagsCsv="$post->tags" />

        <div class="text-lg my-4">
          <i class="fa-solid fa-user"></i> {{$post->user->name}}
        </div>
        <div class="border border-gray-200 w-full mb-6">
          @foreach($post->Categories as $category)
          <li>{{ $category->name }}</li>
          @endforeach
        </div>
        <div>
          
          <div class="text-lg space-y-6">
            {{$post->Description}}


          </div>
        </div>
      </div>
      


<!-- Comments section -->

   <!-- Edit comment modal -->
<div class="modal hidden fixed z-10 top-0 left-0 w-full h-full bg-gray-800 bg-opacity-50">
  <div class="modal-dialog bg-white rounded-md w-11/12 md:w-1/2 mx-auto my-16">
    <div class="modal-content">
      <form id="comment-edit-form" class="w-full px-6 pt-5 pb-8 mb-4">
        @csrf
        @method('PUT')
        <input type="hidden" id="comment_id" name="comment_id" value="">
        <div class="flex flex-wrap mb-6">
          <div class="w-full md:w-full px-3 mb-6 md:mb-0">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="comment_body">
              Comment
            </label>
            <textarea id="comment_body" name="comment_body" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" rows="5"></textarea>
          </div>
        </div>
        <div class="flex items-center justify-end">
          <button id="comment-save-btn" type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline push-comment">
            Save
          </button>
          <button class="modal-close ml-3 py-2 px-4 bg-gray-500 hover:bg-gray-700 focus:outline-none focus:shadow-outline rounded cancel-comment">
            Cancel
          </button>
          
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Comments section -->
<h3>Comments</h3>
<div id="comments-container">
@foreach($post->comments as $comment)
  <div class="flex items-start mb-4 comment-container" data-user-id="{{ $comment->user_id }}">
    <div class="ml-4">
      <h4 class="font-bold">{{ $comment->user->name }}</h4>
      <p id="{{ $comment->id }}" class="text-gray-600">{{ $comment->Body }}</p>
      @if(Auth::check() && $comment->user_id == Auth::user()->id)
        <div class="flex items-center mt-2">
          <button class="edit-comment mr-2 text-blue-500 hover:text-blue-700" data-comment-id="{{ $comment->id }}" data-comment-body="{{ $comment->Body }}">Edit</button>
          <form action="{{ route('comments.destroy', $comment->id) }}" method="post" >
            @csrf
            @method('DELETE')
            <button type="submit" class=" delete-comment text-red-500 hover:text-red-700" data-comment-id="{{ $comment->id }}">Delete</button>
            {{-- <button type="button" class=" delete-comment text-red-500 hover:text-red-700" data-comment-id="{{ $comment->id }}">Delete</button> --}}
          </form>
        </div>
      @endif
    </div>
  </div>
@endforeach
</div>


   <script>
    
      $(document).ready(function() {
        
    // Open edit comment modal and fill it with current comment data
    $(document).on('click', '.edit-comment', function() {
        var commentId = $(this).data('comment-id');
        var commentBody = $(this).data('comment-body');

        $('#comment_id').val(commentId);
        $('#comment_body').html(commentBody);

        $('.modal').css('display', 'flex');
    });

    // Submit edited comment
    // Cancel editing comment
   
        
    
      $(document).on('click', '.push-comment', function(e) {
        e.preventDefault();

        var commentId = $('#comment_id').val();
        var commentBody = $('#comment_body').val();

        $.ajax({
            url: '/comments/' + commentId,
            type: 'PUT',
            data: {
                '_token': $('input[name=_token]').val(),
                'body': commentBody
            },
            error: function(data) {
                $('.modal').hide();
                var commentiBody = $('#comment_body').val();
                 $('#'+commentId).html(commentiBody);
                
                
                
            },
           
        });
    });
 
    // Cancel editing comment
    $(document).on('click', '.cancel-comment', function(e) {
        e.preventDefault();
        $('.modal').hide();
    });
    
   // Delete comment
    // $(document).on('click', '.delete-comment', function(e) {
    //   e.preventDefault();
    //   var commentId = $(this).data('comment-id');

    //   $.ajax({
    //     url: '/comments/' + commentId,
    //     type: 'DELETE',
    //     data: {
    //       '_token': $('input[name=_token]').val()
    //     },
    //     error: function(data) {
    //       console.log("hello world");
    //       $('#' + commentId).parent().remove();

    //             },
                
    //         });
        
    // });

  
});


   </script>






      <div class="mt-8">
        <form id="comment-form" method="POST" action="{{ route('comments.store') }}">
          @csrf
          <input type="hidden" name="post_id" value="{{ $post->id }}">
          <div>
            <label for="body" class="block text-lg font-medium text-gray-700 mb-2">Comment</label>
            <textarea name="body" id="body" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-300"></textarea>
          </div>
          <div class="mt-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Submit</button>
          </div>
        </form>
      </div>
    </x-card>
    <script>
      
    </script>

    {{-- <x-card class="mt-4 p-2 flex space-x-6">
      <a href="/posts/{{$post->id}}/edit">
        <i class="fa-solid fa-pencil"></i> Edit
      </a>

      <form method="POST" action="/posts/{{$post->id}}">
        @csrf
        @method('DELETE')
        <button class="text-red-500"><i class="fa-solid fa-trash"></i> Delete</button>
      </form>
    </x-card> --}}
  </div>
</x-layout>
