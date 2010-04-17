<?php

class Contener_Slot_Container_Stack extends Contener_Slot_Container
{
    protected $stackType;
    
    public function setStackType($class)
    {
        $class->setBelongsTo(array_merge($this->getBelongsTo(), array($this->getName())));
        $this->stackType = $class;
        return $this;
    }
    
    public function getStackType()
    {
        return $this->stackType;
    }
    
    public function setBelongsTo(array $belongs)
    {
        parent::setBelongsTo($belongs);
        if ($this->stackType) {
            $this->stackType->setBelongsTo(array_merge($this->getBelongsTo(), array($this->getName())));
        }
        return $this;
    }
    
    public function isValid($data)
    {
        $new = $data['n']; unset($data['n']);
        
        $keys = array_keys($data);
        if ($keys) {
            $newName = array_pop($keys) + 1;
        } else {
            $newName = 0;
        }
        
        $data[$newName] = $new;
        
        foreach ($data as $key => $value) {
            $element = clone $this->getStackType();
            $this->addSlot($element->setName($key));
        }
        
        return parent::isValid($data);
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