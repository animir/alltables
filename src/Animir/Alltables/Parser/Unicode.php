<?php

namespace Animir\Alltables\Parser;

use Prewk\XmlStringStreamer;
use Animir\Alltables\ProjectOptions;

class Unicode extends AbstractParser {

    public function parse() {

        $options = [
            "uniqueNode" => "char",
            'checkShortClosing' => true
        ];
        $resource = $this->getResource()->getHandler();

        $parser = XmlStringStreamer::createUniqueNodeParser($resource, $options);
        $i = 1;
        $resultArray = [ProjectOptions::getSpecOptions('unicode')['header']];
        while (($charInfo = $parser->getNode()) && $i <= 1) {
            $i++;
            $simpleXmlNode = simplexml_load_string($charInfo);
            $attrs = $simpleXmlNode->attributes();
            $data = [];
            foreach($attrs as $k => $attr) {
                $data[$k] = $attr->__toString();
            }

            $resultArray[] = $this->filterRowByConfig($data);
        }
        
        return $resultArray;
    }
    
    public function prepareToStore($data) {
        
    }
    

}
