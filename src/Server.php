<?php

class Server {

    public function __construct(){
        Log::debug("server starting");

        $this->data = "<html><title>test</test><body><h1>hello</h1></body></html>";

    }

    public function listen() {
        $sock = socket_create_listen(80);
        // socket_getsockname($sock, $addr, $port);
        // print "Server Listening on $addr:$port\n";
        // $fp = fopen($port_file, 'w');
        // fwrite($fp, $port);
        // fclose($fp);
        while($c = socket_accept($sock)) {
            /* do something useful */
            $raddr = null;
            $rport = null;
            socket_getpeername($c, $raddr, $rport);
            Log::debug("Received Connection from $raddr:$rport\n");
            socket_write($c, $this->data);
            // break;
        }
        socket_close($sock);

    }

}
