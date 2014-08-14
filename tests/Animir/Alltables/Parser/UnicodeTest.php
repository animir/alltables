<?php

/**
 *
 * @author animir
 */

namespace Animir\Alltables\Parser;

use Animir\Alltables\ParserFactory;
use Animir\Alltables\ProjectOptions;

class UnicodeTest extends \PHPUnit_Framework_TestCase {

    public function testParseNode() {
        $parser = ParserFactory::factory('unicode', ProjectOptions::getOptions());
        print_r($parser->parse());
    }

}
