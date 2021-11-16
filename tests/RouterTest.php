<?php
use PHPUnit\Framework\TestCase;
use server\Router;
use server\Request;

final class RouterTest extends TestCase {
    public function testAddGet()
    {
        $request = new Request();
        $request->setTarget("/");
        $request->setMethod("GET");

        $router = Router::getInstance();
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
