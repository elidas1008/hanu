<?php

namespace server;

function redirect($url) {

    $response = new Response();
    $response->setResponseCode(302); // ?? which 3xx?
    // ...

    return $response->getMessage();
}

function view($view) {

    $response = new Response();

    // load view into response...
    return $resonse->getMessage();
}

function html($filepath) {
    $response = new Response();
    $response->setContentType('text/html');

    if(file_exists($filepath)) {
        $body = file_get_contents($filepath);
        $response->setResponseCode(200);
        $response->setBody($body);
    } else {
        $response->setResponseCode(404);
    }

    return $response;
}
