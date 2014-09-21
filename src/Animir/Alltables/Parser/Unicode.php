<?php

namespace Animir\Alltables\Parser;

use Prewk\XmlStringStreamer;
use Animir\Alltables\ProjectOptions;

class Unicode extends AbstractParser {

    public static function getDefaultOptions() {
        return [
            'name' => 'unicode', // *
            'type' => 'ftp', // *
            'wrapper' => 'zip', // *
            'src_name' => 'www.unicode.org', // *
            'src_dir' => 'Public/UCD/latest/ucdxml',
            'filename' => 'ucd.nounihan.flat.zip',
            'filename_in_arch' => 'ucd.nounihan.flat.xml',
            'cnt_rows' => 512,
            'header' /* * */ => ['cp' => 'Code point', 
                         'sym' => 'Symbol', 
                         'html' => 'HTML spec', 
                         'htmldec' => 'HTML numerical', 
                         'url' => 'URL encode' ,
                         'na' => 'Name'
                                ],
            'imp_fields' => ['sym'],// *
            'title' => 'Unicode', // *
            //'expire' => 
        ];
    }

    public function parse() {
        $htmlTransTable = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES | ENT_HTML5);

        $options = [
            'uniqueNode' => 'char',
            'checkShortClosing' => true
        ];
        $resource = $this->getResource()->getHandler();

        $parser = XmlStringStreamer::createUniqueNodeParser($resource, $options);
        $i = 1;
        $resultArray = [$this->getOptions()['header']];
        while (($charInfo = $parser->getNode()) && $i <= $this->getOptions()['cnt_rows']) {
            $i++;
            $simpleXmlNode = simplexml_load_string($charInfo);
            $attrs = $simpleXmlNode->attributes();
            $data = [];
            foreach($attrs as $k => $attr) {
                $data[$k] = $attr->__toString();
            }
            
            if (trim($data['na']) == '') {
                $data['na'] = $data['na1'];
            }
            
            $data['sym'] = trim(mb_convert_encoding('&#' . hexdec($data['cp']) . ';', 'UTF-8', 'HTML-ENTITIES'));
            $data['htmldec'] = htmlentities('&#' . hexdec($data['cp']) . ';');
            $data['html'] = isset($htmlTransTable[$data['sym']]) ? htmlentities($htmlTransTable[$data['sym']]) : '';
            $data['url'] = bin2hex(ltrim(hex2bin($data['cp']))) != '' ? htmlentities('%' . bin2hex(ltrim(hex2bin($data['cp'])))) : '';
            
            $resultArray[] = $this->filterRowByConfig($data);
        }
        
        return $resultArray;
    }
    
}
