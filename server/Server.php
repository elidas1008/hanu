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


        // middleware before and after handler
        // $middleware->executePriors($request->getTarget());
        $handler = $this->router->getHandler($request);
        $response = $this->runHandler($handler, $request);

        socket_write($newSock, $response->getMessage());
        socket_close($newSock);
        return;

        // $result = $handler->run($request);
        // if (!is_a($result, 'Response') {
        //     $response = new Response();
        //     $response->setBody($result);
        //     // ...
        // } else {
        //     $response = $result;
        // }

        // hmmm, what with response obj?
        // $middleware->executePosteriors($request->getTarget(), $response);

        // if ($request->getTarget() == '/') {
        //     $filepath = getcwd() ."/public/index.html";
        // } else {
        //     $filepath = getcwd() ."/public/". $request->getTarget();
        // }

        // assume the request asks a file to be read
        // $response = new Response();
        // $response->setContentType('text/html');

        // if(file_exists($filepath)) {
        //     $body = file_get_contents($filepath);
        //     $response->setResponseCode(200);
        //     $response->setHeaders(["Set-Cookie" => "test"]);
        //     $response->setBody($body);
        // } else {
        //     $response->setResponseCode(404);
        // }

        // socket_write($newSock, $response->getMessage());
        // socket_close($newSock);
    }

    private function runHandler(callable $handler, Request $request) {

        $handlerResult = call_user_func($handler, $request);

        // assume the request asks a file to be read
        $response = new Response();
        $response->setContentType('text/html');
        $response->setResponseCode(200);
        $response->setBody($handlerResult);

        return $response;
    }


}
