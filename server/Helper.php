<?php

namespace server;

class Helper {

    static public function CannotFindResource($name) {
        $response = new Response();
        $response->setContentType('text/html');
        $response->setResponseCode(404);
        $response->setBody("cannot find $name");
        return $response;
    }

    static public function redirect($url) {

        $response = new Response();
        $response->setResponseCode(302); // ?? which 3xx?
        // ...

        return $response->getMessage();
    }

    static public function view($view) {

        $response = new Response();

        // load view into response...
        return $resonse->getMessage();
    }

    static public function html($filePath) {
        $response = new Response();
        $response->setContentType('text/html'); // this should be checked

        $filePath = self::getPublicResourcePath($filePath);
        if(file_exists($filePath)) {
            $body = file_get_contents($filePath);
            $response->setResponseCode(200);
            $response->setBody($body);
        } else {
            $response->setResponseCode(404);
        }

        return $response;
    }

    static public function getPublicResourcePath($path) {
        return "./public/$path";
    }
}
