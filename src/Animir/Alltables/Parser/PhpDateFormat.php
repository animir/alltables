<?php

namespace Animir\Alltables\Parser;

use Animir\Alltables\ProjectOptions;
use HtmlToArray\Translator;
use Animir\Alltables\Table\TableArray;

class PhpDateFormat extends AbstractParser {
    
    public static function getDefaultOptions() {
        return [
            'name' => 'PhpDateFormat',
            'type' => 'http',
            'wrapper' => 'html',
            'src_name' => 'php.net',
            'src_dir' => 'manual/en',
            'filename' => 'function.date.php',
            'header' => [	
                        'frmtchar' => 'Format character',
                        'description' => 'Description',
                        'example' => 'Example returned values'
            ],
            'title' => 'PHP. Date format characters.'
        ];
    }

    public function parse() {
        $tableArrayClass = new TableArray();
        $tableArrayClass->addRow($this->getOptions()['header']);

        $resource = $this->getResource()->getHandler();
        $translator = new Translator;
        $sourceContent = stream_get_contents($resource);
        $sourceContent = preg_replace('/<em[^>]*>/i', "", $sourceContent);
        $pageDataXml = $translator->getXmlFromString($sourceContent);
        $table = $pageDataXml->xpath("//div[@id='refsect1-function.date-parameters']//table[@class='doctable table']");
        $tableDataArray = $translator->xml2array($table[0]);
        foreach($tableDataArray['tbody']['tr'] as $row) {
            $row = [ trim($row['td'][0]['text']), trim($row['td'][1]['text']), trim($row['td'][2]['text']) ];
            if ($row[1] === '---' && $row[1] === $row[2]) {
                //h2
                $tableArrayClass->addSubHeader($row[0]);
            } else {
                $tableArrayClass->addRow($row);
            }            
        }
        return $tableArrayClass->getArray();
    }
    
}
