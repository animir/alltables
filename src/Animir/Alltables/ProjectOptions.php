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
            'expire' => 86400, // 60*60*24
            'test_url' => 'alltables.info/test',
            'test_site' => 'alltables.info'
    ];
    static protected $parsers = [
        'Unicode',
        'PhpFopenMode',
        'PhpDateFormat',
        'PhpCurlOptions',
        'PCRE'
    ];
    /**
     * Get all options
     * @return array
     */
    public static function getAllParsers() {       
        return self::$parsers;
    }
    /**
     * Is parser active or not
     * 
     * @return boolean
     */
    public static function isParserActive($name) {
       return in_array(ucfirst($name), self::$parsers); 
    }
    
     /**
     * Get project option
     * 
     * @return mixed
     */   
    public static function getProjectOption($name) {
        return isset(self::$projectOptions[$name]) ? self::$projectOptions[$name] : null;
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
        foreach (self::$parsers as $parser) {
            $parserClassName = __NAMESPACE__ . '\\Parser\\' . ucfirst($parser);
            $options = $parserClassName::getDefaultOptions();
            $result[$parser] = ['title' => $options['title']];
        }
        
        return $result;
    }
    
}
