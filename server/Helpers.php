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
