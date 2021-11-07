<?php

require_once("Log.php");

require_once("Server.php");


Log::info("System started");

$server = new Server();
$server->run();

/*
TODO:
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
