<?php

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
        Log::info("Received Connection from $raddr:$rport\n");

        $request['raddr'] = $raddr;
        $request['rport'] = $rport;

        $rawRequest = socket_read($newSock, 1024);
        Log::debug("rawRequest:$rawRequest");


        $rawLines = preg_split('/\R/', $rawRequest);
        Log::debug('rawLines:', $rawLines);

        $startline = explode(' ', $rawLines[0]);
        if (count($startline) != 3) throw new Exception('startline should contain 3 parts'. json_encode($startline));

        // method
        $startline[0] = strtoupper($startline[0]);
        switch ($startline[0]) {
            case "GET":
                $request['method'] = $startline[0];
                break;
            default:
                throw new Exception("non supported method: ". $startline[0]);
                break;
        }

        // target
        if (substr($startline[1], 0, 1) !== '/') throw new Exception("target not formed properly: '".$startline[1]."'");
        $request['target'] = $startline[1];

        // http version
        $request['httpVersion'] = $startline[2];

        // headers
        $request['headers'] = array_splice($rawLines, 1);

        Log::debug('request', $request);


        // assume it's a file to be read
        $filepath = getcwd() . $request['target'];
        if(!file_exists($filepath)) {
            throw new Exception("File can't be found: $filepath");
        }

        $fileContents = file_get_contents($filepath);

        $rawResponse = [
            'HTTP/1.1 200 OK',
            'Content-Type: text/html',
            'Content-Length: '. strlen($fileContents),
            '',
            $fileContents
        ];

        Log::debug("rawResponse: $rawResponse");
        socket_write($newSock, implode(EOL_PHP, $rawResponse));
        socket_close($newSock);
    }


}
