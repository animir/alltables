<?php
/**
 * Description of ParserFactory
 *
 * @author Animir
 */
namespace Animir\Alltables;

use Animir\Alltables\Parser as Parser;
use Animir\Alltables\Options;

class ParserFactory {
    /**
     * 
     * @param string $name
     * @param array $allOptions
     * @return \Animir\Alltables\AbstractParser|null
     * @throws Exception
     */
    static public function factory($name, $allOptions) {        
        if (!is_array($allOptions)) {
            $allOptions = (array) $allOptions;
        }
        if (!is_string($name)) {
            return null;
        }
        
        if (!isset($allOptions[$name])) {
            throw new \Exception('Options for parser ' . $name . ' not exists.');
        }
        
        $className = ucfirst($name);   
        if (!class_exists('Animir\\Alltables\\Parser\\' . $className)) {
            throw new \Exception('Parser with class name ' . $className . ' not exists');
        }
        
        $parserClassName = __NAMESPACE__ . '\\Parser\\' . $className;
        $parser = new $parserClassName();
        $parser->setOptions($allOptions[$name]);
        $parser->setResource(ResourceFactory::factory($parser->getOptions()));

        return $parser;
    }
}
