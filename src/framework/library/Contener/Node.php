<?php

class Contener_Node extends Contener_Navigation_Node
{
    protected $slotManager;
    
    public function getSlotManager()
    {
        if (!isset($this->slotManager)) {
            $this->slotManager = new Contener_Slot_Manager();
            
            if ($this->Slots) {
                $slots = $this->Slots;
                $this->slotManager->setSerializedData($slots[0])->manage();
            }
        }
        
        return $this->slotManager;
    }
    
    function isValid($data)
    {   
        $valid = true;
        
        $slotManager = $this->getSlotManager();
        
        foreach ($slotManager as $slot) {
            $valid = $slot->isValid($data['slots'][$slot->getName()]) && $valid;
        }
        
        unset($data['slots']);
        
        foreach ($data as $name => $value) {
            $this->$name = $value;
        }
        
        return $valid;
    }
    
    public function getParentPath()
    {
        $path = trim($this->permalink, '/');
        $path = substr($path, 0, 0 - strlen($this->filtered_title));
        
        return $path;
    }
}