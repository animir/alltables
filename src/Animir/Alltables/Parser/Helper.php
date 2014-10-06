<?php
namespace Animir\Alltables\Parser;
/**
 * Help functions for parse and processing data
 *
 * @author animir
 */
class Helper {
    
    /**
     * Strip tags from string
     * 
     * @param string $str
     * @param array $tags
     * @return string String without html tags in $tags array
     */
    public static function removeTags($str,array $tags) {
        $strTags = implode("|", $tags);
        return preg_replace("/<\/*($strTags)[^>]*>/i", "", $str);
    }
}
