<?php

/**
 * All options in array
 *
 * @author animir
 */
namespace Animir\Alltables;

class ProjectOptions {
    static protected $instance;
    static protected $projectOptions = [
            'save_path' => '/tmp/',
            'file_ext' => 'allt',
            'expire' => 86400 // 60*60*24
    ];
    static protected $options = [
        'unicode' => [
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
        ],
        'PhpFopenMode' => [
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
        ],
        'PCRE' => [
            'name' => 'PCRE',
            'type' => 'http',
            'wrapper' => 'txt',
            'src_name' => 'pcre.org',
            'src_dir' => '',
            'filename' => 'pcre.txt',
            'header' => [
                'char' => 'Character | Quantifier',
                'legend' => 'Legend'
            ],
            'title' => 'PCRE'
        ]
    ];
    /**
     * Get all options
     * @return array
     */
    public static function getAllParsersOptions() {       
        return self::$options;
    }
    /**
     * Get options with $blockName key
     * 
     * @param sstring $blockName
     * @return array
     */

    public static function getSpecParserOptions($blockName) {
        if (!isset(self::$options[$blockName])) {
            return array();
        }
        return self::$options[$blockName];
    }
    
    /**
     * Get project options
     * 
     * @return array
     */
    public static function getProjectOptions() {
        return self::$projectOptions;
    }
    
    
    /**
     * Get short info about exist parsers
     * 
     * @return array
     */
    public static function getAllParsersShortInfo() {
        $result = [];
        foreach (self::$options as $option) {
            $result[$option['name']] = ['title' => $option['title']];
        }
        
        return $result;
    }
    
    /**
     * Get positions of important fields in array
     * 
     * @param string $blockName
     * @return array
     */
    public static function getSpecParserImpFieldsPositions($blockName) {
        if (isset(self::$options[$blockName]) && isset(self::$options[$blockName]['imp_fields'])) {
            $fields = array_keys(self::$options[$blockName]['header']);
            $impFieldsNumArray = [];
            foreach (self::$options[$blockName]['imp_fields'] as $impField) {
                if (($pos = array_search($impField, $fields)) !== false) {
                    $impFieldsNumArray[] = $pos;
                }
            }
            return $impFieldsNumArray;
        }
        return [];
    }

}
