<?php

namespace core\server;
use \Exception;

class DependencyInjector {

    private array $objects = null;

    public function add(string $name, object $object) {
        if (array_has_key($name)) throw new Exception("dependency already exists: $name");
        $this->objects[$name] = $object;
    }

    public function get(string $name){
        if (!array_has_key($name)) throw new Exception("dependency doesn't exists: $name");
        return $this->objects[$name];
    }
}
