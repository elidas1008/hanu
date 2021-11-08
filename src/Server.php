<?php

require_once('Request.php');
require_once('Response.php');


class Server {

    public function __construct(){
        Log::debug("server starting");

        $this->data = "<html><title>test</title><body><h1>hello</h1></body></html>";
    }

    public function run() {
        $sock = socket_create_listen(80);
        while(1)
        {
            $newSock = socket_accept($sock);
            $rawResponse = $this->handleNewSock($newSock);
        }
    }

    private function handleNewSock($newSock) {

        // handle new sock by building up request object
        $raddr = null;
        $rport = null;
        socket_getpeername($newSock, $raddr, $rport);
        $rawRequest = socket_read($newSock, 1024);

        $request = new Request();
        $request->setRemoteInfo($raddr, $rport);
        $request->parseRawRequest($rawRequest);

        if ($request->getTarget() == '/') {
            $filepath = getcwd() ."/public/index.html";
        } else {
            $filepath = getcwd() ."/public/". $request->getTarget();
        }

        // assume the request asks a file to be read
        $response = new Response();
        $response->setContentType('text/html');

        if(file_exists($filepath)) {
            $body = file_get_contents($filepath);
            $response->setResponseCode(200);
            $response->setBody($body);
        } else {
            $response->setResponseCode(404);
        }

        socket_write($newSock, $response->getMessage());
        socket_close($newSock);
    }


}
