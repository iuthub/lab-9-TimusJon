<?php

namespace App;

class Post extends Model
{
    protected $fillable = ['title', 'content'];

    public function likes()
    {
        // This allows an instance of Post class to retrieve all associated Like objects upon request.
        return $this->hasMany('App\Like', 'post_id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'post_tag', 'post_id', 'tag_id')->withTimestamps();
    }

    // public function getPosts($session)
    // {
    //     if (!$session->has('posts')) {
    //         $this->createDummyData($session);
    //     }
    //     return $session->get('posts');
    // }

    // public function getPost($session, $id)
    // {
    //     if (!$session->has('posts')) {
    //         $this->createDummyData();
    //     }
    //     return $session->get('posts')[$id];
    // }

    // public function addPost($session, $title, $content)
    // {
    //     if (!$session->has('posts')) {
    //         $this->createDummyData();
    //     }
    //     $posts = $session->get('posts');
    //     array_push($posts, ['title' => $title, 'content' => $content]);
    //     $session->put('posts', $posts);
    // }

    // public function editPost($session, $id, $title, $content)
    // {
    //     $posts = $session->get('posts');
    //     $posts[$id] = ['title' => $title, 'content' => $content];
    //     $session->put('posts', $posts);
    // }

    // private function createDummyData($session)
    // {
    //     $posts = [
    //         [
    //             'title' => 'Learning Laravel',
    //             'content' => 'This blog post will get you right on track with Laravel!'
    //         ],
    //         [
    //             'title' => 'Something else',
    //             'content' => 'Some other content'
    //         ]
    //     ];
    //     $session->put('posts', $posts);
    // }
}
