<?php

namespace Animir\Alltables\Parser;

use Prewk\XmlStringStreamer;
use Animir\Alltables\ProjectOptions;

class Unicode extends AbstractParser {

    public function parse() {
        $htmlTransTable = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES | ENT_HTML5);

        $options = [
            'uniqueNode' => 'char',
            'checkShortClosing' => true
        ];
        $resource = $this->getResource()->getHandler();

        $parser = XmlStringStreamer::createUniqueNodeParser($resource, $options);
        $i = 1;
        $resultArray = [ProjectOptions::getSpecOptions('unicode')['header']];
        while (($charInfo = $parser->getNode()) && $i <= 512) {
            $i++;
            $simpleXmlNode = simplexml_load_string($charInfo);
            $attrs = $simpleXmlNode->attributes();
            $data = [];
            foreach($attrs as $k => $attr) {
                $data[$k] = $attr->__toString();
            }
            
            $data['sym'] = mb_convert_encoding('&#' . hexdec($data['cp']) . ';', 'UTF-8', 'HTML-ENTITIES');
            $data['htmldec'] = htmlentities('&#' . hexdec($data['cp']) . ';');
            $data['html'] = isset($htmlTransTable[$data['sym']]) ? htmlentities($htmlTransTable[$data['sym']]) : '';
            $data['url'] = bin2hex(ltrim(hex2bin($data['cp']))) != '' ? htmlentities('%' . bin2hex(ltrim(hex2bin($data['cp'])))) : '';
            
            $resultArray[] = $this->filterRowByConfig($data);
        }
        
        return $resultArray;
    }

}
