<?php

namespace Chr15k\App\Controllers;

use Chr15k\App\Models\Post;
use Chr15k\Core\View\View;
use Chr15k\Core\Routing\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
    	$queries = $this->request->queries;

    	$posts = Post::all();

        View::make('Home/index.html', [
        	'posts'   => $posts,
        	'queries' => $queries
        ]);
    }
}