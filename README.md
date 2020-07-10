# PHP MVC
Simple PHP MVC with Twig templating.

This is a work in progress, and absolutely isn't a replacement for a proper framework!

This project has 2 dependencies:

- [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) (environment variables)
- [twig/twig](https://github.com/twigphp/Twig) (templating engine)

## Using this framework
* Clone this repo
* Install project dependencies:
```
composer install
```
* Configure your web server to use the public folder as root.
* Create your environment file and enter your database configuration:
```
cp .env.example .env
```

## Config
Add config files to /config directory. Then use the `config()` helper to return the array from the file.
Config files use the `env()` helper which uses `getenv()` to load variables from `.env` file. You can also pass a second argument to `env()` as a default value.

The `config()->get()` method retrieves a value from a deeply nested array using "dot" notation

```php
// config/database.php

config()->get('database');

/**
[
    'host' => '127.0.0.1',
    'port' => 3306,
    'name' => test,
    'user' => test,
    'pass' => test
];
*/
```

```php
config()->get('database.host');

// '127.0.0.1'
```

The `config()->set()` method sets a value within a deeply nested array using "dot" notation. Use this method to set config at runtime:
```php
// pass a single key and value
config()->set('app.debug', 'test');

config()->get('app.debug');
// test

// or pass an array
config()->set([
    'app.debug' => 0,
    'app.foo'   => 'bar'
]);

config()->get('app');

/**
[
    'debug' => 0,
    'foo'   => 'bar',
];
*/
```

The `config()->has()` method checks whether a given item or items exists in an array using "dot" notation:
```php
config()->has('app.debug');

// true
```

## Routing
The routes are registered in `public/index.php`

The following will register `/posts` url to point to `app/Controllers/PostController.php` and action `indexAction()`

```php
// public/index.php

$router = new \Chr15k\Core\Routing\Router();

$router->register('/posts', [
    'controller' => 'Post',
    'action'     => 'index'
]);
```

You can also pass route `variables`:
```php
// public/index.php

$router->register('/posts/{id}', [
    'controller' => 'Post',
    'action'     => 'show'
]);

// The parameter 'id' can be accessed via the $params property 
// available to Controllers extending the Core controller.
$this->params['id'];
```

You can also pass a namespace:
```php
// public/index.php

// app/Controllers/Admin/UserController
$router->register('/users/{id}', [
    'controller' => 'User',
    'action'     => 'show',
    'namespace'  => 'Admin'
]);
```

Query parameters can be accessed via the `$request` instance in the controller.
```php
// /posts?id=123&limit=5

var_dump($this->request->queries);

/**
	[
		'id'    => 123,
		'limit' => 5
	];
*/
```

## Controllers

Controllers extend the Core controller `Core\Routing\Controller` and need to be in the `app\Controllers` namespace. You can add subdirectories like `app\Controllers\Admin` - the namespace will need to be specified in routes as per the example above.

Access route params:
```php
$this->params;
```

Access query params:
```php
$this->request->queries;
```

See `Core\Http\Request` for more information.

## Models
The core model class is `Core\Database\Model`
The app models are in `app\Models`

The static property `$table` is required, and needs to be set to the database table name relating to that model.

```php
<?php

namespace App\Models;

use Chr15k\Core\Database\Model;

class Post extends Model
{
    static $table = 'posts';
}
```

There are 2 default methods available to models extending the core model as above, these are:

```php
Post::all(); // retrieves a listing of all posts.
Post::find(1); // retrieves the post with the id of 1.
```

## Views
Views use the Twig templating engine and live in `app\Views`
Call the make method to render the html file, and pass in the required variables, e.g:
```php
// app\Controllers\PostController

// ...

View::make('Post/index.html', [
    'posts'   => $posts,
    'queries' => $queries
]);
```

## Cache
- Cache is stored in `storage/cache/data`
- View cache is stored in `storage/cache/views/`

- Cache can be accessed in controllers extending the core controller, using $this->cache.

Get cache:
```php
$key = 'posts_all';

$posts = $this->cache->get($key);
```

Set cache by passing a cache key and the value to be stored:
```php
if (! $posts) {
    $posts = Post::all();

    $this->cache->set($key, $posts); 
}
```

## Errors
If `APP_DEBUG` is set to true in `.env`, a full error detail will be shown in the browser. If set to false, a generic message will be shown using the `app/Views/404.html` or `app/Views/500.html` depending on the error code.

## License
The MIT License (MIT). Please see [License File](https://github.com/chr15k/string/blob/master/LICENSE.md) for more information.