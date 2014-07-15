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
     * @param \Animir\Alltables\Options $allOptions
     * @return \Animir\Alltables\AbstractParser|null
     * @throws Exception
     */
    static public function factory($name, \Animir\Alltables\Options $allOptions) {        
        if (!is_string($name)) {
            return null;
        }
        
        if (!isset($allOptions->$name)) {
            throw new Exception('Options for parser ' . $name . 'not exists.');
        }
        
        $className = ucfirst($name);
        if (!class_exists('Animir::Alltables::Parser::' . $className)) {
            throw new Exception('Parser with class name ' . $className . ' not exists');
        }
        
        $parserClassName = 'Parser\\' . $className;
        
        $parser = new $parserClassName();
        $parser->setOptions(new Options($allOptions->$name));
        $parser->setResource(\ResourceFactory::factory($parser->getOptions()));

        return $parser;
    }
}
