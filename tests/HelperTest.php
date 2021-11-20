<?php
use PHPUnit\Framework\TestCase;
use core\server\Helper;
use core\server\Response;

final class HelperTest extends TestCase {
    public function testHtml()
    {

        $expResponse = new Response();
        $expResponse->setContentType('text/html');
        $expResponse->setResponseCode(200);
        $expResponse->setBody(implode(PHP_EOL, [
            "<html>",
            "<title>test</title>",
            "<body>",
            "    <h1>hello</h1>",
            "    <p> this is the content of the file</p>",
            "    <p> olia's story on her friend</p>",
            "</body>",
            "</html>"
        ]));

        $actResponse = Helper::html('index.html');

        $this->assertEquals($expResponse->getMessage(), $actResponse->getMessage());
    }
}
