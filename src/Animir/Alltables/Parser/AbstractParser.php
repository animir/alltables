<?php
namespace \Animir\Alltables\Parser;
abstract class AbstractParser {
    public function parse();
    
    protected function getResource(array $config, $altName = 'default') {
        $name = null;
        if (array_key_exists(strtolower(get_class()), $config)) {
            $name = strtolower(get_class());
        } elseif (array_key_exists($altName, $config)) {
            $name = $altName;
        }
        
        if (is_null($name)) return null;
        
        return ResourceFactory::factory($config[$name]);
    }
}

