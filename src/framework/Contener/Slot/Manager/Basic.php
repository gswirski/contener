<?php

class Contener_Slot_Manager_Basic extends Contener_Slot_Container
{
    protected $slotsConfiguration;
    
    function sleep()
    {
        $children = array();
        foreach ($this->slots as $slot) {
            $children[] = $slot->sleep();
        }
        
        return array(
            'class' => 'Contener_Slot_Manager_Basic',
            'name' => 'root',
            'body' => '',
            'children' => $children
        );
    }
    
    function setSlots($slots)
    {
        $this->slotsConfiguration = $slots;
        return $this;
    }
    
    function manage()
    {
        foreach ($this->slotsConfiguration as $slot) {
            $this->slots[$slot['name']]->setSerializedData($slot);
        }
        
        unset($this->slotsConfiguration);
    }
    
    function spec()
    {
        if ($this->slotConfiguration) {
            return array('slotConfiguration' => 'object');
        }
        
        if ($this->file) {
            return array('file' => 'string');
        }
    }
}
