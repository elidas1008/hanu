<?php
use PHPUnit\Framework\TestCase;

final class TestRequest extends TestCase {
    public function testSetHeaders()
    {
        $headers = [
            "Host: localhost",
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:94.0) Gecko/20100101 Firefox/94.0",
            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
            "Accept-Language: en-US,en;q=0.5",
            "Accept-Encoding: gzip, deflate",
            "Connection: keep-alive",
            "Upgrade-Insecure-Requests: 1",
            "Sec-Fetch-Dest: document",
            "Sec-Fetch-Mode: navigate",
            "Sec-Fetch-Site: none",
            "Sec-Fetch-User: ?1",
            "Pragma: no-cache",
            "Cache-Control: no-cache",
            ""
        ];
        $expHeaders = [
            "Host" => "localhost",
            "User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:94.0) Gecko/20100101 Firefox/94.0",
            "Accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
            "Accept-Language" => "en-US,en;q=0.5",
            "Accept-Encoding" => "gzip, deflate",
            "Connection" => "keep-alive",
            "Upgrade-Insecure-Requests" => "1",
            "Sec-Fetch-Dest" => "document",
            "Sec-Fetch-Mode" => "navigate",
            "Sec-Fetch-Site" => "none",
            "Sec-Fetch-User" => "?1",
            "Pragma" => "no-cache",
            "Cache-Control" => "no-cache"
        ];

        $r = new Request();
        $r->setHeaders($headers);

        $this->assertEquals($expHeaders, $r->getHeaders(), "header string to header array");
        foreach($expHeaders as $expHeaderKey => $expHeader) {
            $this->assertEquals($expHeader, $r->getHeader($expHeaderKey), "getHeader($expHeaderKey)");
        }
        $this->assertEquals(null, $r->getHeader("headerThatDoesntExist"), "getHeader('headerThatDoesntExist')");
    }

    public function testParseRawRequest()
    {
        $rawRequest = implode(PHP_EOL, [
            "GET / HTTP/1.1",
            "Host: localhost",
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:94.0) Gecko/20100101 Firefox/94.0",
            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
            "Accept-Language: en-US,en;q=0.5",
            "Accept-Encoding: gzip, deflate",
            "Connection: keep-alive",
            "Upgrade-Insecure-Requests: 1",
            "Sec-Fetch-Dest: document",
            "Sec-Fetch-Mode: navigate",
            "Sec-Fetch-Site: none",
            "Sec-Fetch-User: ?1",
            "Pragma: no-cache",
            "Cache-Control: no-cache",
            ""
        ]);
        $expHeaders = [
            "Host" => "localhost",
            "User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:94.0) Gecko/20100101 Firefox/94.0",
            "Accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
            "Accept-Language" => "en-US,en;q=0.5",
            "Accept-Encoding" => "gzip, deflate",
            "Connection" => "keep-alive",
            "Upgrade-Insecure-Requests" => "1",
            "Sec-Fetch-Dest" => "document",
            "Sec-Fetch-Mode" => "navigate",
            "Sec-Fetch-Site" => "none",
            "Sec-Fetch-User" => "?1",
            "Pragma" => "no-cache",
            "Cache-Control" => "no-cache"
        ];

        $r = new Request();
        $r->parseRawRequest($rawRequest);

        $this->assertEquals("GET", $r->getMethod(), "getMethod");
        $this->assertEquals("/", $r->getTarget(), "getTarget");
        $this->assertEquals("HTTP/1.1", $r->getHttpVersion(), "getHttpVersion");
        $this->assertEquals($expHeaders, $r->getHeaders(), "getHeaders");
    }
}
