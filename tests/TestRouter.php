<?php
use PHPUnit\Framework\TestCase;

final class TestRouter extends TestCase {
    public function testSetHeaders()
    {
        $request = new Request();
        $request->setTarget("/");
        $request->setMethod("GET");

        $router = new Router();
        $router->add("GET","/", function(Request $request) {
            return "OK";
        });

        $handler = $router->getHandler($request);

        $this->assertNotEquals(null, $handler);
        $this->assertTrue(is_callable($handler));
        $this->assertEquals(
            "OK",
            call_user_func($handler, $request)
        );
    }
}
