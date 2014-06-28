<?php
/**
 * Description of Resource
 *
 * @author Animir
 */
namespace Animir\Alltables\Resource;

use Options;

class Resource {
    /**
     * @var \Animir\Alltables\Resource\Options
     */
    protected $options;
    protected $resource;
     
    public function get() {
        $srcPrefix = is_null($this->options->handler) ? '' : $this->options->handler . '://';
        if (!is_resource($this->resource)) {
            $this->resource = fopen( $srcPrefix . $this->getSrc(), 'r');
        }
        return $this->resource;
    }
    
    public function __construct(array $config) {
        $this->options = new Options($config);
    }
}
