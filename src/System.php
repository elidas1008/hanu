<?php

require_once("Log.php");

require_once("Server.php");


Log::init(true);
Log::info("System started");

$server = new Server();
$server->run();



Log::destruct()
?>
