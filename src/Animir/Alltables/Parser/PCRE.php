<?php

/**
 * PCRE parse from man
 *
 * @author animir
 */

namespace Animir\Alltables\Parser;

use Animir\Alltables\ProjectOptions;
use Groff\Groff;
use HtmlToArray\Translator;
use Animir\Alltables\Table\TableArray;

class PCRE extends AbstractParser {

    public function parse() {
        $tableArray = new TableArray();
        $tableArray->addRow(ProjectOptions::getSpecParserOptions('PCRE')['header']);
        $resource = $this->getResource()->getHandler();
        $mandoc = stream_get_contents($resource);
        $groff = new Groff();
        
        $mandocHeaders = [];
        $mandocHeaders['QUOTING'] = '\x         where';
        $mandocHeaders['CHARACTERS'] = '\a         alarm';
        $mandocHeaders['CHARACTER TYPES'] = '.          any character';
        $mandocHeaders['CHARACTER CLASSES'] = [
                '[...]       positive', 
                'alnum       alphanumeric'
                ];
        $mandocHeaders['QUANTIFIERS'] = '?           0 or 1, greedy';
        $mandocHeaders["ANCHORS AND SIMPLE ASSERTIONS"] = '\b          word boundary';
        $mandocHeaders["CAPTURING"] = '(...)           capturing';
        $mandocHeaders["OPTION SETTING"] = '(?i)            caseless';
        $mandocHeaders["NEWLINE CONVENTION"] = '(*CR)           carriage';
        $mandocHeaders["BACKREFERENCES"] = '\n              reference';
        $mandocHeaders["SUBROUTINE REFERENCES (POSSIBLY RECURSIVE)"] = '(?R)            recurse';
        $mandocHeaders["CONDITIONAL PATTERNS"] = '(?(n)...        absolute';
        
        foreach ($mandocHeaders as $header => $firstRows) {
            if (!is_array($firstRows)) {
                $firstRows = (array) $firstRows;
            }
            $tableArray->addSubHeader($header);
            foreach ($firstRows as $firstRow) {
                $manPart = $groff->getManPart($mandoc, $header);
                $tableString = $groff->getTable($manPart, $firstRow);
                if (is_null($tableString)) {
                    throw new \Exception("PCRE something wrong with part mandoc ('$header' -> '$firstRow')");
                }
                $tableArray->addRows($groff->getArrayFromTable($tableString));
            }
        }


        return $tableArray->getArray();
    }

}
