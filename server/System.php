<?php

namespace server;
require_once('vendor/autoload.php');

// include "Log.php";
// include "Server.php";

// use Helpers;

// require_once("Log.php");
// require_once("Server.php");
// require_once("Router.php");


// Log::info("System started");
$router = new Router();
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
