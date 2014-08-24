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
        if (!is_resource($this->handler)) {
            
            $methodName = 'get' . ucfirst($this->options['type']) . ucfirst($this->options['wrapper']) . 'Handler';
            if (method_exists($this,  $methodName)) {
                $this->handler = $this->$methodName();
            } else {
                throw new Exception('Method with name  "' . $methodName . '" not exists in class "Resource"');
            }

            if (!$this->handler) {
                $this->handler = null;
            }
        }
        return $this->handler;
    }
    
    private function getFtpZipHandler() {
        $ftpConnId = ftp_connect($this->options['src_name']);
        ftp_login($ftpConnId, 'anonymous', 'none');
        ftp_chdir($ftpConnId, $this->options['src_dir']);
        $tmpResource = fopen(sys_get_temp_dir() . '/' . $this->options['filename'], 'wb');
        ftp_fget($ftpConnId, $tmpResource, $this->options['filename'], FTP_BINARY, 0);
        fclose($tmpResource);
        return fopen($this->options['wrapper'] . '://' . sys_get_temp_dir() . '/' . $this->options['filename'] . '#' . $this->options['filename_in_arch'], 'rb');
    }
    
    private function getHttpHtmlHandler() {
        return fopen($this->options['type'] . '://' . $this->options['src_name'] . '/' . $this->options['src_dir'] . '/' . $this->options['filename'], 'r');
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
