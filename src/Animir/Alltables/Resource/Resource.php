<?php
/**
 * @author Animir
 */
namespace Animir\Alltables\Resource;

use Animir\Alltables\Options;

class Resource {
    protected $options;
    /**
     * @var resource
     */
    protected $handler;
    
    public function getHandler() {
        $srcPrefix = !isset($this->options['wrapper']) ? '' : $this->options['wrapper'] . '://';
        if (!is_resource($this->handler)) {
            
            switch($this->options['type']) {
                case 'ftp':
                    $ftpConnId = ftp_connect($this->options['src_name']);
                    ftp_login($ftpConnId , 'anonymous' , 'none');
                    ftp_chdir($ftpConnId, $this->options['src_dir']);
                    $tmpResource = fopen(sys_get_temp_dir() . '/' . $this->options['filename'], 'wb');
                    ftp_fget($ftpConnId, $tmpResource, $this->options['filename'], FTP_BINARY, 0);
                    fclose($tmpResource);   
                    $this->handler = fopen($this->options['wrapper'] . '://'. sys_get_temp_dir() . '/' . $this->options['filename'] . '#' . $this->options['filename_in_arch'], 'rb');
                break;
                default:
                break;
            }
           
            if (!$this->handler) {
                $this->handler = null;
            }
        }
        return $this->handler;
    }
    
    public function __construct($options) {
        if (!is_array($options)) {
            $this->options = (array) $options;
        } else {
            $this->options = $options;
        }
    }
    public function __destruct() {
        if (is_resource($this->handler)) {
            fclose($this->handler);
        }
    }
    public function close() {
        if (is_resource($this->handler)) {
            fclose($this->handler);
        }
    }
}
