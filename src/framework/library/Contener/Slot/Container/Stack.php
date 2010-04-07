<?php

class Contener_Slot_Container_Stack extends Contener_Slot_Container
{
    protected $stackType;
    
    public function setStackType($class)
    {
        $this->stackType = $class;
        return $this;
    }
    
    public function getStackType()
    {
        return $this->stackType;
    }
    
    public function editable()
    {
        return array_merge(
            parent::editable(), 
            array('elements' => array(
                'type' => 'array',
                'child' => 'photo'
            ))
        );
    }
}