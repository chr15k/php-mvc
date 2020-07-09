<?php

namespace Chr15k\Core\Routing;

use Exception;
use Chr15k\Core\Http\Request;
use Chr15k\Core\Support\Str;

class Router
{
    private $routes = [];
    private $params = [];

    public function getRoutes()
    {
        return $this->routes;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function setRoute($route, $params)
    {
        $this->routes[$route] = $params;
    }

    public function register($route, array $params = [])
    {
        $route = $this->sanitiseRoute($route);

        $this->setRoute($route, $params);
    }

    public function dispatch(Request $request)
    {
        if (! $this->match($request->url)) {
            throw new Exception('No route matched.', 404);
        }

        $controller = $this->getRouteControllerNamespace();

        if (! class_exists($controller)) {
            throw new Exception("Controller class $controller not found");
        }

        $instance = new $controller($this->params, $request);

        $action = Str::camel($this->params['action']);

        if (preg_match('/action$/i', $action) != 0) {
            throw new Exception("Remove the Action suffix to call this method");
        }

        return $instance->$action();
    }

    /**
     * Get the Controller class, and append optional 'namespace' param.
     *
     * @return string $namespace
     */
    private function getBaseControllerNamespace()
    {
        $namespace = 'App\\Controllers';

        if (array_key_exists('namespace', $this->params)) {
            $namespace .= '\\' . $this->params['namespace'];
        }

        return $namespace;
    }

    /**
     * Build the route's controller class.
     *
     * @return string
     */
    private function getRouteControllerNamespace()
    {
        return sprintf(
            "%s\\%s%s",
            $this->getBaseControllerNamespace(),
            Str::studly($this->params['controller']),
            'Controller'
        );
    }

    private function match($url)
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }

                $this->setParams($params);

                return true;
            }
        }
    }

    private function sanitiseRoute($route)
    {
        // Escape forward slashes
        $route = preg_replace('/\//', '\\/', $route);

        // Convert variables e.g. {id}
        $route = preg_replace('/\{([^\/]+)\}/', '(?P<\1>[^\/]+)', $route);

        // Start and end delimiters
        $route = '/^' . $route . '$/i';

        return $route;
    }
}