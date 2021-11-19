<?php

namespace server;

class Server {

    private $router = null;

    public function __construct($router){
        Log::debug("server starting");
        $this->router = $router;

    }

    public function run() {
        $sock = socket_create_listen(80);
        while(1)
        {
            $newSock = socket_accept($sock);
            $this->handleNewSock($newSock);
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

        try {
            $handler = $this->router->getHandler($request);
            $response = $this->runHandler($handler, $request);
        } catch (CannotFindException $e) {
            $response = Helper::CannotFindResource($e->getMessage());
        }

        socket_write($newSock, $response->getMessage());
        socket_close($newSock);
    }

    private function runHandler(callable $handler, Request $request) {

        $handlerResult = call_user_func($handler, $request);

        if ($handlerResult instanceof Response) return $handlerResult;

        $response = new Response();
        $response->setContentType('text/html');
        $response->setResponseCode(200);
        $response->setBody($handlerResult);

        return $response;
    }


}
