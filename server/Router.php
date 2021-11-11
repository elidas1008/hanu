<?php

namespace server;
use \Exception;

class Router {

    private $routes = null; //[path][method]

    public function __construct() {

    }

    public function getHandler(Request $request) {
        if(!array_key_exists($request->getTarget(), $this->routes)) throw new Exception("cannot find route");
        return $this->routes[$request->getTarget()][$request->getMethod()];
    }

    public function add(string $method, string $path, callable $handler) {

        $this->routes[$path][$method] = $handler;
    }
}
