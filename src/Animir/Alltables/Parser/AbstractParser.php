<?php
namespace \Animir\Alltables\Parser;
abstract class AbstractParser {
    /**
     *
     * @var Animir\Alltables\Options
     */
    protected $options;
    
    /**
     *
     * @var Animir\Alltables\Resource\Resource
     */
    protected $resource;
    
    public function parse();
    
    public function getResource() {
        return $this->resource;
    }
    public function setResource(Animir\Alltables\Resource\Resource $resource){
        $this->resource = $resource;
    }
    public function getOptions() {
        return $this->options;
    }
    public function setOptions(Animir\Alltables\Options $options) {
        $this->options = $options;
    }
}

