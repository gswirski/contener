<?php

class Contener_Application_Data
{
    static protected $baseDir;
    
    protected $source;
    protected $path;
    const WEB = '/web/';
    const APPLICATION = '/application/data/';
    
    public function __construct($source = '', $scope = self::APPLICATION)
    {
        $this->setSource($source, $scope);
    }
    
    static public function setBaseDir($dir)
    {
        self::$baseDir = $dir;
    }
    
    static public function getBaseDir()
    {
        return self::$baseDir;
    }
    
    public function setSource($source, $scope = self::APPLICATION)
    {
        $this->source = $source;
        $this->setPath($source, $scope);
        return $this;
    }
    
    public function getSource()
    {
        return $this->source;
    }
    
    public function setPath($source, $scope = self::APPLICATION)
    {
        if (substr($source, 0, 1) != '/') {
            $source = self::getBaseDir() . $scope . $source;
        }
        
        $this->path = $source;
    }
    
    public function getPath()
    {
        return $this->path;
    }
    
    public function exists()
    {
        return file_exists($this->getPath());
    }
    
    public function write($data)
    {
        $source = $this->getPath();
        @mkdir(substr($source, 0, strrpos($source, '/')), 0777, true);
        
        if (is_string($data)) {
            return file_put_contents($this->getPath(), $data);
        } else {
            throw new Exception('Currently not supported');
        }
    }
    
    public function copy($destination)
    {
        @mkdir(substr($destination, 0, strrpos($destination, '/')), 0777, true);
        $this->_copy($this->getPath(), $destination);
    }
    
    protected function _copy($source, $destination)
    {
        if (is_dir($source)) {
            @mkdir($destination);
            $directory = dir($source);
            while ( FALSE !== ($readdirectory = $directory->read())) {
                if ( $readdirectory == '.' || $readdirectory == '..' ) {
                    continue;
                }
                $PathDir = $source . '/' . $readdirectory; 
                if ( is_dir( $PathDir ) ) {
                    $this->_copy( $PathDir, $destination . '/' . $readdirectory );
                    continue;
                }
                copy( $PathDir, $destination . '/' . $readdirectory );
            }

            $directory->close();
        }else {
            copy( $source, $destination );
        }
    }
    
}