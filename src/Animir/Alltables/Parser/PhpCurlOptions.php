<?php
namespace Animir\Alltables\Parser;

use Prewk\XmlStringStreamer;
use Animir\Alltables\ProjectOptions;
use Animir\Alltables\Table\TableArray;
use HtmlToArray\Translator;

class PhpCurlOptions extends AbstractParser {

    public static function getDefaultOptions() {
        return [
            'name' => 'PhpCurlOptions',
            'type' => 'http',
            'wrapper' => 'html',
            'src_name' => 'php.net',
            'src_dir' => 'manual/en',
            'filename' => 'function.curl-setopt.php',
            'header' => [
                'option' => 'Option',
                'value' => 'Set value to',
                'note' => 'Notes'
            ],
            'title' => 'PHP. Curl options.'
        ];
    }

    public function parse() {
        $tableArrayClass = new TableArray();
        $tableArrayClass->addRow($this->getOptions()['header']);

        $resource = $this->getResource()->getHandler();
        $translator = new Translator;
        $sourceContent = stream_get_contents($resource);
        $sourceContent = Helper::removeTags($sourceContent, ["strong", "code", "em"]);
        $pageDataXml = $translator->getXmlFromString($sourceContent);
        $tables = $pageDataXml->xpath("//div[@id='refsect1-function.curl-setopt-parameters']//table[@class='doctable informaltable']");
        foreach ($tables as $table) {
            $tableDataArray = $translator->xml2array($table);
            foreach ($tableDataArray['tbody']['tr'] as $row) {
                $array = [
                    trim($row['td'][0]['text']),
                    trim($row['td'][1]['text']),
                    trim($row['td'][2]['text'])
                ];
                $tableArrayClass->addRow($array);
            }
        }

        return $tableArrayClass->getArray();
    }

}
