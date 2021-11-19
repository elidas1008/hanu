<?php

namespace server;

class Router {

    private $routes = null; //[path][method]

    private static ?Router $router = null;
    protected function __construct() {}
    protected function __clone() {}

    public static function getInstance(): Router
    {
        if (null == self::$router) {
            self::$router = new static();
        }
        return self::$router;
    }

    public function getHandler(Request $request) {
        if(!array_key_exists($request->getTarget(), $this->routes)) throw new CannotFindException("cannot find ". $request->getTarget());
        return $this->routes[$request->getTarget()][$request->getMethod()];
    }

    public function add(string $method, string $path, callable $handler) {

        $method = strtoupper($method);

        $this->routes[$path][$method] = $handler;
    }

}
