<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    // Show all posts
    public function index() {
        return view('posts.index', [
            'posts' => post::latest()
                        ->filter(request(['tag', 'search', 'category']))
                        ->with('categories')
                        ->paginate(6)
        ]);
    }
    

    // Show single post
public function show(post $post) {
    $categories = $post->categories->pluck('name')->toArray();
    
    

    return view('posts.show', [
        'post' => $post,
        'categories' => $categories
    ]);
}


    // Show Create Form
    public function create() {
        $categories = Categories::all();
    
        return view('posts.create', compact('categories'));
    }

    // Store post Data
    public function store(Request $request) {
        $formFields = $request->validate([
            'title' => 'required',
            'tags' => 'required',
            'description' => 'required'
        ]);
    
        $post = new Post($formFields);
    
        if($request->hasFile('logo')) {
            $post->logo = $request->file('logo')->store('logos', 'public');
        }
    
        $post->user_id = auth()->id();
        $post->save();
    
        $post->categories()->attach($request->categories);
    
        return redirect('/')->with('message', 'Post created successfully!');
    }
    

    // Show Edit Form
    public function edit(post $post) {
        $categories = Categories::all();
        return view('posts.edit', ['post' => $post], compact('categories'));
    }

   

    public function update(Request $request, post $post) {
        // Make sure logged in user is owner
        if($post->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }
        
        $formFields = $request->validate([
            'title' => 'required',
            'tags' => 'required',
            'description' => 'required',
            'categories' => 'required|array'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        
        
        $post->categories()->sync($request->categories);

        $post->update($request->only('title', 'description'));

        
        return redirect('/')->with('message', 'Post Modified successfully!');
    }

    // Delete post
    public function destroy(post $post) {
        // Make sure logged in user is owner
        if($post->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }
        
        $post->delete();
        return redirect('/')->with('message', 'post deleted successfully');
    }

    // Manage posts
    public function manage() {
        return view('posts.manage', ['posts' => auth()->user()->posts()->get()]);
    }
}
