<?php
namespace Animir\Alltables\Parser;

use Animir\Alltables\ProjectOptions;

/**
 * Interface for parser
 * @package alltables
 * @author animir <animir@ya.ru>
 */

interface iParser {
    public static function getDefaultOptions();
}

/**
 * Abstract class for any parser
 * 
 * @package alltables
 * @author animir <animir@ya.ru>
 */

abstract class AbstractParser implements iParser{

    protected $options;
    
    /**
     * @var Animir\Alltables\Resource\Resource
     */
    protected $resource;
    
    
    /**
     * Parse resource with config from ProjectOptions class and return data
     * 
     * @return array
     */
    abstract public function parse();
        
    /**
     * Filter $array according to 'header' param in ProjectOptions
     * If option 'header' is not set, all $data return
     * 
     * @param array $data
     * @return array
     */
    protected function filterRowByConfig(array $data) {
        if (!isset($this->options['header'])) return $data;
        
        $resultArray = [];
        foreach($this->options['header'] as $field => $val ) {
            $resultArray []= isset($data[$field]) ? $data[$field] : null ;            
        }

        return $resultArray;
    }
    
    /**
     * Store $data to file with filename from ProjectOptions
     * 
     * @param array $data
     * @return bool
     */
    public function store(array $data) {
        $file = fopen($this->getStoreFilename(), 'wb');
        foreach ($data as $row) {
            fputcsv($file, $row);
        }
        fclose($file);
        return true;
    }
    
    /**
     * Load data from file with filename from ProjectOptions
     * 
     * @return array
     */
    
    public function load() {
        $data = [];
        $file = fopen($this->getStoreFilename(), 'rb');
        while (($row = fgetcsv($file, 0, ',', '"', '"')) !== false) {
            $data[] = $row;
        }
        fclose($file);
        return $data;
    }
    /**
     * Check is stored data actual or not
     * 
     * @return boolean
     */
    public function isFileActual() {
        $expire = isset($this->options['expire']) ? $this->options['expire'] : ProjectOptions::getProjectOptions()['expire'];
        
        if ($this->parsedDataExists() === false || (filemtime($this->getStoreFilename()) + $expire) < time()) {
            return false;
        }
        return true;
    }

    /**
     * Get filename for storing data
     * 
     * @return string
     */
    public function getStoreFilename() {
        return ProjectOptions::getProjectOptions()['save_path'] . 
               $this->options['name'] . 
               '.' . ProjectOptions::getProjectOptions()['file_ext'];
    }
    
    /**
     * Get array with parsed data
     * which loaded from file if it exists
     * 
     * @return array
     */
    public function getArray() {
        if ($this->isFileActual() === false) {
            $data = $this->parse();
            $this->store($data);
        } else {
            $data = $this->load();
        }
        return $data;
    }
    
    /**
     * Exists or not file with parsed data
     * 
     * @return bool
     */
    
    public function parsedDataExists() {
        return file_exists(ProjectOptions::getProjectOptions()['save_path'] . $this->options['name'] . '.allt');
    }
    
    /**
     * Return resource
     * @return \Animir\Alltables\Resource\Resource
     */
    public function getResource() {
        return $this->resource;
    }
    
    /**
     * Set resource
     * @param \Animir\Alltables\Resource\Resource $resource
     */
    public function setResource(\Animir\Alltables\Resource\Resource $resource){
        $this->resource = $resource;
    }
    
    /**
     * Get parser options
     * 
     * @return array
     */
    public function getOptions() {
        return $this->options;
    }
    
    /**
     * Set options for parser
     * 
     * @param array|string $options
     */
    
    public function setOptions($options) {
        if (!is_array($options)) {
            $this->options = (array)$options;
        } else {
            $this->options = $options;            
        }
    }
    
    /**
    * Get positions of important fields in array
    * 
    * @return array
    */
    public function getImpFieldsPositions() {
        if (isset($this->getOptions()['imp_fields'])) {
            $fields = array_keys($this->getOptions()['header']);
            $impFieldsNumArray = [];
            foreach ($this->getOptions()['imp_fields'] as $impField) {
                if (($pos = array_search($impField, $fields)) !== false) {
                    $impFieldsNumArray[] = $pos;
                }
            }
            return $impFieldsNumArray;
        }
        return [];
    }

}

