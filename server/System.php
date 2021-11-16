<?php

namespace server;
require_once('vendor/autoload.php');

$router = Router::getInstance();
$router->add("GET", "/", function(Request $request) {
    return "OK";
});

$server = new Server($router);
$server->run();

/*
TODO:
    location redirect? view?


    it should be able to run php
    serve images
    serve all methods (post, put)
    all statuses
    serve css
    http caching
    http cookies
    cross origin resource sharing
    session
    compression
    https

*/


Log::destruct()
?>
