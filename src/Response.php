<?php

class Response {

    private $rawResponse = null;
    private $startline = null;
    private $contentType = null;
    private $body = null;

    public function __construct() {
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
            '',
            $this->body
        ];

        Log::debug("rawResponse: ", $rawResponse);
        return implode(PHP_EOL, $rawResponse);
    }
}
