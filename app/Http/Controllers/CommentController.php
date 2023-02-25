<?php

namespace App\Http\Controllers;


use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;



class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::all();
        return view('posts.show', ['comments' => $comments]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required',
            'post_id' => 'required|exists:posts,id',
        ]);

        $comment = new Comment([
            'body' => $request->input('body'),
            'user_id' => auth()->id(),
            'post_id' => $request->input('post_id'),
        ]);
        $comment->save();

        return redirect()->back()->with('success', 'Comment added successfully!');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
{
    
    $comments = $post->comments()->with('user')->get();
    


    return view('posts.show', [
        'post' => $post,
        'comments' => $post->comments,
        'post_id' => $post->id, // pass the post id to the view
    ], compact('post', 'comments'));
}


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
{
    $request->validate([
        'body' => 'required|string|max:255',
    ]);

    $comment->update([
        'body' => $request->input('body'),
    ]);

    return redirect()->back()->with('success', 'Comment updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
{
    $comment->delete();

    return redirect()->back()->with('success', 'Comment deleted successfully.');
}

}
