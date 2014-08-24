<?php

namespace Animir\Alltables\Parser;

use Animir\Alltables\ProjectOptions;
use HtmlToArray\Translator;

class PhpFopenMode extends AbstractParser {

    public function parse() {
        $resultArray = [ProjectOptions::getSpecParserOptions('PhpFopenMode')['header']];
        $resource = $this->getResource()->getHandler();

        $translator = new Translator;
        $pageDataXml = $translator->getXmlFromString(stream_get_contents($resource));
        $table = $pageDataXml->xpath("//div[@id='refsect1-function.fopen-parameters']//table[@class='doctable table']");
        $tableDataArray = $translator->xml2array($table[0]);
        foreach($tableDataArray['tbody']['tr'] as $row) {
            $resultArray[]= [ $row['td'][0]['em']['text'], trim($row['td'][1]['text']) ];
        }
        return $resultArray;
    }

}
