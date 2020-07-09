<?php

namespace App\Controllers;

use App\Models\Post;
use Chr15k\Core\View\View;
use Chr15k\Core\Routing\Controller;

class PostController extends Controller
{
    public function indexAction()
    {
        $queries = $this->request->queries;

        $posts = Post::all();

        View::make('Post/index.html', [
            'posts'   => $posts,
            'queries' => $queries
        ]);
    }

    public function showAction()
    {
        $post = Post::find($this->params['id']);

        View::make('Post/show.html', [
            'post'  => $post
        ]);
    }
}