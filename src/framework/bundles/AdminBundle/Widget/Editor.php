<?php

class AdminBundle_Widget_Editor extends Contener_View_Widget
{
    protected $slot;
    
    public function setSlot($slot) {
        $this->slot = $slot;
        return $this;
    }
    
    public function getSlot()
    {
        return $this->slot;
    }
    
    public function __toString()
    {
        $editable = $this->slot->editable();
        
        try {
            return $this->getView()->render(
                'slot_editor', 
                array('context' => $this->slot, 'editable_areas' => $editable)
            );
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
