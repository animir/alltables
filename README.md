alltables
=========

This repo is core of alltables.info project. 
It consist of parser classes and some helpful classes for save and load data.

# Create new parser
To create new table you must create new class in dir 'src/Animir/Alltables/Parser/' and extends it from AbstractParser:

```php
class Unicode extends AbstractParser {
    public static function getDefaultOptions() {
        return [

        ];
    }
    
    public function parse() {
        return [
        
        ];
    }
}
```
Abstract class AbstractParser require to realize two functions:
* static function getDefaultOptions() - get array of options for parse data, such as: source uri, columns naming or using wrapper for read data
* function parse() - it return array of data (you can read about details below)
