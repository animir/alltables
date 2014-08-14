<?php
namespace Animir\Alltables;

use Animir\Alltables\Resource\Resource;

class ResourceFactory {
    /**
     * 
     * @param array $options
     * @return \Animir\Alltables\Resource\Resource
     */
    static function factory($options) {
        return new Resource($options);
    }
}

