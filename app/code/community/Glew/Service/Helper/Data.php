<?php 

class Glew_Service_Helper_Data extends Mage_Core_Helper_Abstract
{
	private static $connRead;
	private static $connWrite;
    
	private static $console;
	private static $filename = "glew.log";
	
	private static $debug = true;
	
    private $_config;
    
	public function getBaseDir()
	{
        return Mage::getBaseDir() . '/app/code/community/Glew/';
	}
    
    public function getLogDir()
    {
        return Mage::getBaseDir() . '/var/log/';
    }
    
    public function getTempDir()
    {
        return Mage::getBaseDir() . '/var/Glew/';
    }
	
	public function getDatabaseConnection()
	{
		return Mage::getSingleton('core/resource')->getConnection('glew_write');
	}
    
    public function getDatabaseReadConnection()
	{
        return Mage::getSingleton('core/resource')->getConnection('glew_read');
	}
    
    public function getConfig()
    {
        $config = array();
        $config['enabled'] = Mage::getStoreConfig('glew_settings/general/enabled');
        $config['security_token'] = Mage::getStoreConfig('glew_settings/general/security_token');
        
        $this->_config = $config;
        return $config;
    }
    
    public function formatDate($str)
    {
        if ($str) {
            if (stripos($str, ' ')) {
                $str = substr($str, 0, stripos($str, ' '));
            }
        }
        return $str;
    }
    
    public function toArray($value, $create = false)
    {
        if ($value !== false) {
            return is_array($value) ? $value : array($value);
        }  else {
            return $create ? array() : $value;
        }
    }
        
    public function ex($ex, $msg)
    {
        if ($this->_logging()) {
            $msg = "an exception has occurred during $msg: " . $ex->getMessage();
            $this->_write($msg);
        }
        return false;
    }
    
    public function debug($msg, $m1 = '', $m2 = '', $m3 = '', $m4 = '', $m5 = '', $m6 = '') 
    {
        if ($this->_logging(true)) {
            $msg = "debug: " . print_r($msg, true) . print_r($m1, true) . print_r($m2, true) . print_r($m3, true) . print_r($m4, true) . print_r($m5, true) . print_r($m6, true);
            $this->_write($msg);
        }
    }
    
    function splitArray($arr, $group_size)
    {
        $groups = array();
        if (is_array($arr) && count($arr) > 0) {
            $one_group = array();
            for ($i = 0; $i < count($arr); $i++) {
                if ($i > 0 && $i % $group_size == 0) {
                    if ($one_group) {
                        $groups[] = $one_group;
                    }
                    $one_group = array();
                }
                $one_group[] = $arr[$i];
            }
            if ($one_group) {
                $groups[] = $one_group;
            }
        }
        return $groups;
    }

    private function _logging($verbose = false)
    {
        return true;
    }
    
    private function _write($msg)
    {
        if (!self::$console) {
            date_default_timezone_set('UTC');
            $uri = $this->getLogDir() . self::$filename;
            self::$console = fopen($uri, "a");
        }
        
        if (self::$console) {
            $stats = fstat(self::$console);
            if ($stats) {
                $size = $stats['size'] / (1024*1000);
                if ($size > 10) {
                    @fclose(self::$console);
                    self::$console = @fopen($uri, "w");
                }
            }
        }
        
        if (self::$console) {
            $msg = strftime("%Y-%m-%d %H:%M:%S ") . " " . $msg;
            
            fwrite(self::$console, print_r($msg, true)."\n");
            fflush(self::$console);
        }
    }
}
