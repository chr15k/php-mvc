<?php

namespace Chr15k\Core\Routing;

use Exception;
use Chr15k\Core\Http\Request;

abstract class Controller
{
    protected $params = [];
    protected $request;

    public function __construct($params, Request $request)
    {
        $this->params = $params;
        $this->request = $request;
    }

    public function __call($name, $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            throw new Exception("Method $method not found in controller " . get_class($this));
        }
    }

    protected function before()
    {
    }

    protected function after()
    {
    }
}