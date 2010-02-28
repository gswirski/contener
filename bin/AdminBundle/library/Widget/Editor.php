<?php

class AdminBundle_Widget_Editor
{
    protected $slot;
    
    public function __construct($slot) {
        $this->slot = $slot;
    }
    
    public function __toString()
    {
        $editable = $this->slot->editable();
        
        try {
            $t = new Contener_View('slot_editor');
            return $t->render($this->slot, array('editable_areas' => $editable));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
