<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Session\Store;

class PostController extends Controller
{
    // public function getIndex(Store $session)
    // {
    //     $post = new Post();
    //     $posts = $post->getPosts($session);
    //     return view('blog.index', ['posts' => $posts]);
    // }

    // This pulls all posts ordered by their created date in a descending order.
    public function getIndex()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('blog.index', ['posts' => $posts]);
    }

    // public function getAdminIndex(Store $session)
    // {
    //     $post = new Post();
    //     $posts = $post->getPosts($session);
    //     return view('admin.index', ['posts' => $posts]);
    // }

    // This pulls all posts ordered by their title.
    public function getAdminIndex()
    {
        $posts = Post::orderBy('title', 'asc')->get();
        return view('admin.index', ['posts' => $posts]);
    }

    // public function getPost(Store $session, $id)
    // {
    //     $post = new Post();
    //     $post = $post->getPost($session, $id);
    //     return view('blog.post', ['post' => $post]);
    // }

    // This finds a post by its ID using where statement.
    public function getPost($id)
    {
        $post = Post::where('id', $id)->first();
        return view('blog.post', ['post' => $post]);
    }

    public function getAdminCreate()
    {
        $tags = Tag::all();
        return view('admin.create', ['tags' => $tags]);
    }

    // public function getAdminEdit(Store $session, $id)
    // {
    //     $post = new Post();
    //     $post = $post->getPost($session, $id);
    //     return view('admin.edit', ['post' => $post, 'postId' => $id]);
    // }

    // This finds a post by its ID
    public function getAdminEdit($id)
    {
        $post = Post::find($id);
        $tags = Tag::all();
        return view('admin.edit', ['post' => $post, 'postId' => $id, 'tags' => $tags]);
    }

    // public function postAdminCreate(Store $session, Request $request)
    // {
    //     $this->validate($request, [
    //         'title' => 'required|min:5',
    //         'content' => 'required|min:10'
    //     ]);
    //     $post = new Post();
    //     $post->addPost($session, $request->input('title'), $request->input('content'));
    //     return redirect()->route('admin.index')->with('info', 'Post created, Title is: ' . $request->input('title'));
    // }

    // This creates a new post object and saves it in database .
    public function postAdminCreate(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:5',
            'content' => 'required|min:10'
        ]);
        // $post = new Post([
        //     'title' => $request->input('title'),
        //     'content' => $request->input('content')
        // ]);
        // $post->save();
        $post = resolve('App\Post');
        $post->addPost($request->input('title'), $request->input('content'));
        $post->tags()->attach($request->input('tags') === null ? [] : $request->input('tags'));

        return redirect()->route('admin.index')->with('info', 'Post created , Title is: ' . $request->input('title '));
    }

    // public function postAdminUpdate(Store $session, Request $request)
    // {
    //     $this->validate($request, [
    //         'title' => 'required|min:5',
    //         'content' => 'required|min:10'
    //     ]);
    //     $post = new Post();
    //     $post->editPost($session, $request->input('id'), $request->input('title'), $request->input('content'));
    //     return redirect()->route('admin.index')->with('info', 'Post edited, new Title is: ' . $request->input('title'));
    // }

    // This finds a post by its ID, sets its fields to given values and submits changes to database.
    public function postAdminUpdate(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:5',
            'content' => 'required|min:10'
        ]);
        $post = Post::find($request->input('id'));
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->save();
        $post->tags()->sync($request->input('tags') === null ? [] : $request->input('tags'));

        return redirect()->route('admin.index')
            ->with('info', 'Post edited , new Title is: ' . $request->input('title'));
    }

    // handles post deletes
    public function getAdminDelete($id)
    {
        $post = Post::find($id);
        $post->likes()->delete();
        $post->tags()->detach();
        $post->delete();
        return redirect()->route('admin.index')->with('info', 'Post deleted!');
    }


    // Above you create new instance of Like class and save it directly inside the property of corresponding
    // $post object. This will automatically link newly created $like object to $post.
    public function getLikePost($id)
    {
        $post = Post::where('id', $id)->first();
        $like = new Like();
        $post->likes()->save($like);
        return redirect()->back();
    }
}
