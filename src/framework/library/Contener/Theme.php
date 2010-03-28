<?php

class Contener_Theme
{
    public $slotManager;
    public $data;
    protected $config;
    
    public function __construct($data)
    {
        $this->data = $data;
    }
    
    public function __get($key)
    {
        return $this->data->$key;
    }
    
    public function __set($key, $value)
    {
        return $this->data->$key = $value;
    }
    
    public function __call($function, $args)
    {
        return call_user_func_array(array($this->data, $function), $args);
    }
    
    public function getSlotManager()
    {
        if (!isset($this->slotManager)) {
            $this->slotManager = new Contener_Slot_Manager();
            
            $slots = $this->toArray();
            $slots = $slots['Slots'];
            if ($slots) {
                $this->slotManager->setSerializedData($slots[0]);
            }
        }
        
        return $this->slotManager;
    }
    
    public function setSlotManager($manager)
    {
        $this->slotManager = $manager;
    }
    
    public function getConfig($dir = null)
    {
        if (!$this->config) {
            $file = $dir . '/' . $this->data->file_path . '/theme.php';
            $this->config = include $file;
        }
        
        return $this->config;
    }
}