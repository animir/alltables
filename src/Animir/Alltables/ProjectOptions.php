<?php

/**
 * All options in array
 *
 * @author animir
 */
namespace Animir\Alltables;

class ProjectOptions {
    static protected $instance;
    static protected $options = [
        'alltables' => [
            'save_path' => '/tmp/'
        ],
        'unicode' => [
            'name' => 'unicode',
            'type' => 'ftp',
            'wrapper' => 'zip',
            'src_name' => 'www.unicode.org',
            'src_dir' => 'Public/UCD/latest/ucdxml',
            'filename' => 'ucd.nounihan.flat.zip',
            'filename_in_arch' => 'ucd.nounihan.flat.xml',
            'header' => ['cp' => 'Code point', 'na' => 'Name', 'na1' => 'Alt name']
        ]
    ];
    /**
     * Get all options
     * @return array
     */
    public static function getOptions() {       
        return self::$options;
    }
    /**
     * Get options with $blockName key
     * 
     * @param sstring $blockName
     * @return array
     */

    public static function getSpecOptions($blockName) {
        if (!isset(self::$options[$blockName])) {
            return array();
        }
        return self::$options[$blockName];
    }
}
