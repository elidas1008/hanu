<?php

namespace core\server;
use \Exception;

class Request {

    private $raddr = null;
    private $rport = null;
    private $method = null;
    private $target = null;
    private $httpVersion = null;
    private $headers = null;

    public function setRemoteInfo($raddr, $rport) {
        $this->raddr = $raddr;
        $this->rport = $rport;
    }

    public function parseRawRequest($rawRequest) {

        $rawLines = preg_split('/\R/', $rawRequest);

        $startline = explode(' ', $rawLines[0]);
        if (count($startline) != 3) throw new Exception('startline should contain 3 parts :'. json_encode($startline));

        $this->setMethod($startline[0]);
        $this->setTarget($startline[1]);
        $this->setHttpVersion($startline[2]);
        $this->setHeaders(array_splice($rawLines, 1));
    }


    public function setHttpVersion($httpVersion) {
        $this->httpVersion = $httpVersion;
    }

    public function setTarget($target) {
        if (substr($target, 0, 1) !== '/') throw new Exception("target not formed properly: '".$startline[1]."'");
        $this->target = $target;
    }

    public function setMethod($method) {
        $method = strtoupper($method);
        switch ($method) {
            case 'GET':
            case 'HEAD':
            case 'POST':
            case 'PUT':
            case 'DELETE':
            case 'CONNECT':
            case 'OPTIONS':
            case 'TRACE':
            case 'PATCH':
                $this->method = $method;
                break;
            default:
                throw new Exception("Method is not known: $method");
                break;
        }
    }

    public function setHeaders(array $headers) {
        if (!isset($headers)) throw new Exception("no headers received");
        foreach($headers as $header) {
            if(empty($header)) continue;
            $h = explode(": ", $header,  2);
            if (count($h) < 2) throw new Exception("Couldn't parse header: $header");
            $this->headers[$h[0]] = $h[1];
        }
    }

    public function getRaddr() { return $this->raddr; }
    public function getRport() { return $this->rport; }
    public function getMethod() { return $this->method; }
    public function getTarget() { return $this->target; }
    public function getHttpVersion() { return $this->httpVersion; }
    public function getHeaders() { return $this->headers; }

    public function getHeader(string $headerName) {
        if (!array_key_exists($headerName, $this->headers)) return null;
        return $this->headers[$headerName];
    }
}
