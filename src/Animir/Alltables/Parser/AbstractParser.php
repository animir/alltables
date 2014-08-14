<?php
namespace Animir\Alltables\Parser;

use Animir\Alltables\ProjectOptions;

abstract class AbstractParser {
    /**
     *
     * @var Animir\Alltables\Options
     */
    protected $options;
    
    /**
     * @var Animir\Alltables\Resource\Resource
     */
    protected $resource;
    
    abstract public function parse();
    abstract public function prepareToStore($data);
    
    protected function filterRowByConfig($array) {
        if (!isset($this->options['header'])) return $array;
        
        $resultArray = [];
        foreach($this->options['header'] as $field => $val ) {
            $resultArray []= isset($array[$field]) ? $array[$field] : null ;            
        }

        return $resultArray;
    }
    
    public function store() {
        $options = ProjectOptions::getSpecOptions('alltables');
    }
    
    public function getResource() {
        return $this->resource;
    }
    public function setResource(\Animir\Alltables\Resource\Resource $resource){
        $this->resource = $resource;
    }
    public function getOptions() {
        return $this->options;
    }
    public function setOptions($options) {
        if (!is_array($options)) {
            $this->options = (array)$options;
        } else {
            $this->options = $options;            
        }
    }
}

