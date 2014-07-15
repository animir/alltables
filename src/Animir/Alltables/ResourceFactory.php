<?php
namespace \Animir\Alltables\Resource\REsource;

class ResourceFactory {
    static function factory(Animir\Alltables\Options $config) {
        return new Resource($config);
    }
}

