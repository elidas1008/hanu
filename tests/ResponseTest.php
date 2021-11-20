<?php
use PHPUnit\Framework\TestCase;
use core\server\Response;

final class ResponseTest extends TestCase {
    public function testSetHeaders()
    {
        $expCookie = ['Cookie' => 'test'];
        $expMsg = implode(PHP_EOL, [
            "HTTP/1.1 404 NOT FOUND",
            "Content-Type: text/html",
            "Content-Length: 0",
            "Cookie: " .$expCookie['Cookie'],
            ""
        ]);

        $r = new Response();
        $r->setContentType('text/html');
        $r->setResponseCode(404);
        $r->setHeaders($expCookie);

        $this->assertEquals($expMsg, $r->getMessage());
    }

    public function testSetHeaders_empty()
    {
        $expMsg = implode(PHP_EOL, [
            "HTTP/1.1 404 NOT FOUND",
            "Content-Type: text/html",
            "Content-Length: 0",
            ""
        ]);

        $r = new Response();
        $r->setContentType('text/html');
        $r->setResponseCode(404);

        $this->assertEquals($expMsg, $r->getMessage());
    }
}
