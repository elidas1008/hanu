<?php

namespace server;
use \Exception;

class Response {

    private $rawResponse = null;
    private $startline = null;
    private $contentType = null;
    private $body = null;
    private $headers = null;

    public function __construct() {
    }

    public function setHeaders(array $headers) {
        $this->headers = $headers;
    }

    public function setContentType($type) {
        $this->contentType = 'text/html';

    }

    public function setResponseCode($code) {
        $this->startline = 'HTTP/1.1 ';

        $this->code = $code;
        $this->startline .= $code;

        switch ($code) {
            case '200':
                $this->startline .= " OK";
                break;

            case '404':
                $this->startline .= " NOT FOUND";
                break;

            case '500':
            default:
                $this->code = $code;
                $this->startline .= $code ." Internal Server Error";
                break;
        }

    }
    public function setBody($body) {
        if (!$this->code == 200) throw new Exception("can't set body on a non 200 status code");
        $this->body = $body;
    }

    public function getMessage() {
        $rawResponse = [
            $this->startline,
            'Content-Type: '. $this->contentType,
            'Content-Length: '. strlen($this->body),
        ];
        Log::debug('this.headers', $this->headers);
        foreach((array) $this->headers as $name => $header) {
            $rawResponse[] = "$name: $header";
        }
        $rawResponse[] = ""; //header-body separator
        if (0 < strLen($this->body)) {
            $rawResponse[] = $this->body;
        }

        return implode(PHP_EOL, $rawResponse);
    }
}
