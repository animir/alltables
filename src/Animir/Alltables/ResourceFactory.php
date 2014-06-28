<?php
namespace \Animir\Alltables\Resource;

class ResourceFactory {
    static function factory(array $config) {
        $resource = new Resource($config);
        return $resource->get();
    }
}

