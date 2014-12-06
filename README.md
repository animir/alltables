alltables
=========

This repo is core of alltables.info project.
It consist of parser classes and some helpful classes for save and load data.
You can add any table what you want.

# Create new parser

1) __Create new class__ in dir 'src/Animir/Alltables/Parser/' and extends it from AbstractParser:

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

2) __Fill array with options__. Now you can use next options:

| Option | Description | Example | Required |
| ------------ | ------------- | ------------- | ------------- |
|`name` | Name of table (must coincides with class name with no case-sensitivity of first letter) |`unicode`,`PhpFopenMode` | [x] |
|`type` | Protocol of connection to source of info | `ftp`, `http` | [x] |
|`wrapper` | Wrapper for access to data | `zip`, `html` | [x] |
|`src_name` | Name of resource | `www.unicode.org`, `php.net` | [x] |
|`src_dir` | Path to data | `Public/UCD/latest/ucdxml`, `manual/en` | [x] |
|`filename` | Filename | `ucd.nounihan.flat.zip`, | [x] |
|`filename_in_arch` | Filename in archive | `function.fopen.php` |  |
|`cnt_rows` | Max count of rows to parse | `512` |  |
|`header` | Array of header cells of table (count equals to count of columns) | `['cp' => 'Code point', 'sym' => 'Symbol', 'html' => 'HTML spec', 'htmldec' => 'HTML numerical', 'url' => 'URL encode', 'na' => 'Name']` | |
|`imp_fields` | Distinguished columns in table (have larg font size) | `['sym']` | |
|`expire` | Expire of cache table data in seconds | `3600` | |

Options that not exists, can be added.

3) If private function with name `get . ucfirst($options['type']) . ucfirst($options['wrapper'])) . Handler` exists in
__class `Resource`__  (forexample, `getFtpZipHandler`), you need no anything to do in this case. 
Otherwise, you must add such function. It have no paramters (all parameters get from options).
It returns a file pointer resource on success or `false` on error.
Example:

```php
private function getFtpZipHandler() {
    $ftpConnId = ftp_connect($this->options['src_name']);
    ftp_login($ftpConnId, 'anonymous', 'none');
    ftp_chdir($ftpConnId, $this->options['src_dir']);
    $tmpResource = fopen(sys_get_temp_dir() . '/' . $this->options['filename'], 'wb');
    ftp_fget($ftpConnId, $tmpResource, $this->options['filename'], FTP_BINARY, 0);
    fclose($tmpResource);
    return fopen($this->options['wrapper'] . '://' . sys_get_temp_dir() . '/' . $this->options['filename'] . '#' . $this->options['filename_in_arch'], 'rb');
}
```

4) Declare __public function parse()__. It returns array of data with header of table in first element. Count of columns must be equal to count of elements in `header` array in options. You can use simple class `TableArray` to add row, header, subheader etc.
Example code parsing table from php.net with curl options:
```php
        $tableArrayClass = new TableArray();
        $tableArrayClass->addRow($this->getOptions()['header']);

        $resource = $this->getResource()->getHandler(); // use function by `type` and `wrapper` from options
        $translator = new Translator; // simple class for work with DOM, XML, HTML
        $sourceContent = stream_get_contents($resource);
        $sourceContent = Helper::removeTags($sourceContent, ["strong", "code", "em"]); // use helper for remove tags from html
        $pageDataXml = $translator->getXmlFromString($sourceContent);
        $tables = $pageDataXml->xpath("//div[@id='refsect1-function.curl-setopt-parameters']//table[@class='doctable informaltable']");
        foreach ($tables as $table) { // prepare array
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
```

