<?php

class Contener_Node extends Contener_Navigation_Node
{
    protected $slotManager;
    
    public function __constuct($data = array())
    {
        if (isset($data['Slots']) && isset($data['Slots'][0])) {
            $slots = $data['Slots'][0];
            unset($data['Slots']);
            
            $this->getSlotManager()->setSerializedData($slots);
        }
        
        parent::__construct($data);
    }
    
    public function getSlotManager()
    {
        if (!isset($this->slotManager)) {
            $this->slotManager = new Contener_Slot_Manager();
            
            if ($this->Slots) {
                $slots = $this->Slots;
                $this->slotManager->setSerializedData($slots[0]);
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
    
    /**
     * @todo: Bad way to hide notices
     */
    public function __get($key)
    {
        return '';
    }
}