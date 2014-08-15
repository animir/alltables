<?php
namespace Animir\Alltables\Parser;

use Animir\Alltables\ProjectOptions;

abstract class AbstractParser {

    protected $options;
    
    /**
     * @var Animir\Alltables\Resource\Resource
     */
    protected $resource;
    
    abstract public function parse();
    
    protected function filterRowByConfig($array) {
        if (!isset($this->options['header'])) return $array;
        
        $resultArray = [];
        foreach($this->options['header'] as $field => $val ) {
            $resultArray []= isset($array[$field]) ? $array[$field] : null ;            
        }

        return $resultArray;
    }
    
    public function store(array $data) {
        $options = ProjectOptions::getSpecOptions('alltables');
        $file = fopen($options['save_path'] . $this->options['name'] . '.allt', 'wb');
        foreach ($data as $row) {
            fputcsv($file, $row);
        }
        fclose($file);
    }
    
    public function load() {
        $data = [];
        $options = ProjectOptions::getSpecOptions('alltables');
        $file = fopen($options['save_path'] . $this->options['name'] . '.allt', 'rb');
        while (($row = fgetcsv($file)) !== false ) {
            $data[]=$row;
        }
        fclose($file);
        return $data;
    }
    
    public function getArray() {
        if ($this->parsedDataExists() === false) {
            $data = $this->parse();
            $this->store($data);
        } else {
            $data = $this->load();
        }
        return $data;
    }
    
    public function parsedDataExists() {
        return file_exists(ProjectOptions::getSpecOptions('alltables')['save_path'] . $this->options['name'] . '.allt');
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

