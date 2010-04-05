<?php

class Contener_Application_Data
{
    static protected $managedDir;
    
    static public function setManagedDir($dir)
    {
        self::$managedDir = $dir;
    }
    
    static public function getManagedDir()
    {
        return self::$managedDir;
    }
}