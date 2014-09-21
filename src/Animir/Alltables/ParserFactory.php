<?php
/**
 * Description of ParserFactory
 *
 * @author Animir
 */
namespace Animir\Alltables;

class ParserFactory {
    /**
     * 
     * @param string $name
     * @return \Animir\Alltables\AbstractParser|null
     * @throws Exception
     */
    static public function factory($name) {        
        if (!is_string($name)) {
            return null;
        }
        
        if (!ProjectOptions::isParserActive($name)) {
            throw new \Exception('Parser ' . $name . ' unable.');
        }
        
        $className = ucfirst($name);   
        if (!class_exists('Animir\\Alltables\\Parser\\' . $className)) {
            throw new \Exception('Parser with class name ' . $className . ' not exists');
        }
        
        $parserClassName = __NAMESPACE__ . '\\Parser\\' . $className;
        $parser = new $parserClassName();
        $parser->setOptions($parserClassName::getDefaultOptions());
        $parser->setResource(ResourceFactory::factory($parser->getOptions()));

        return $parser;
    }
}
