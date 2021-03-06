<?php

/**
 *
 * @author animir
 */

namespace Animir\Alltables\Parser;

use Animir\Alltables\ParserFactory;
use Animir\Alltables\ProjectOptions;

class UnicodeTest extends \PHPUnit_Framework_TestCase {
    private $parser;
    
    public function setUp() {
        $this->parser =  $parser = ParserFactory::factory('unicode');
    }
    
    public function testData() {
        $data = $this->parser->getArray();
        $this->assertNotEmpty($data);
    }
    public function tearDown() {
        unset($this->parser);
    }

}
