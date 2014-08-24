<?php
/**
 * Description of AllParsersSaveDataTest
 *
 * @author animir
 */


namespace Animir\Alltables\Parser;

use Animir\Alltables\ParserFactory;
use Animir\Alltables\ProjectOptions;

class AllParsersSaveDataTest extends \PHPUnit_Framework_TestCase {

    public function testSaveFiles() {
        foreach(ProjectOptions::getAllParsersShortInfo() as $name => $options) {
            $parser = ParserFactory::factory($name, ProjectOptions::getAllParsersOptions());
            $this->assertNotEmpty($parser->getArray(), 'Parser ' . $name . ' get empty data');
            
            $filename = $parser->getStoreFilename();
            $this->assertTrue(file_exists($parser->getStoreFilename()) 
                                && filesize($parser->getStoreFilename()) != false,
                              'Parser ' . $name . 'not save data');            
        }                
    }       
}

