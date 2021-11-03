<?php

require_once("Log.php");

require_once("Server.php");

Log::init();
Log::info("System started");

$server = new Server();
$server->listen();



Log::destruct()
?>
