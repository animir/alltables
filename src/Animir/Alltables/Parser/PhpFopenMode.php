<?php

namespace Animir\Alltables\Parser;

use Animir\Alltables\ProjectOptions;
use HtmlToArray\Translator;

class PhpFopenMode extends AbstractParser {
    
    public static function getDefaultOptions() {
        return [
            'name' => 'PhpFopenMode',
            'type' => 'http',
            'wrapper' => 'html',
            'src_name' => 'php.net',
            'src_dir' => 'manual/en',
            'filename' => 'function.fopen.php',
            'header' => [
                        'mode' => 'Mode',
                        'description' => 'Description'
            ],
            'title' => 'PHP. Possible modes for fopen()'
        ];
    }

    public function parse() {
        $resultArray = [$this->getOptions()['header']];
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
