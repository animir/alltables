<?php
/**
 * @author Animir
 */
namespace Animir\Alltables\Resource;

use Animir\Alltables\Options;

class Resource {
    /**
     * @var \Animir\Alltables\Options
     */
    protected $options;
    /**
     * @var resource
     */
    protected $handler;
     
    public function getHandler() {
        $srcPrefix = is_null($this->options->wrapper) ? '' : $this->options->wrapper . '://';
        if (!is_resource($this->handler)) {
            $this->handler = fopen( $srcPrefix . $this->options->src, 'r');
        }
        return $this->handler;
    }
    
    public function __construct(Animir\Alltables\Options $options) {
        $this->options = $options;
    }
    public function __destruct() {
        fclose($this->handler);
    }
    public function close() {
        fclose($this->handler);
    }
}
