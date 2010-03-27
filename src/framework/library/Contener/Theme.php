<?php

class Contener_Theme
{
    public $slotManager;
    public $data;
    
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
            $slots = $this->toArray();
            $slots = $slots['Slots'];
            
            $this->slotManager = new $slots[0]['class'];
            $this->slotManager->setSerializedData($slots[0])->manage();
        }
        
        return $this->slotManager;
    }
    
    public function setSlotManager($manager) {
        $this->slotManager = $manager;
    }
}