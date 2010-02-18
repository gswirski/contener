<?php

class Contener_Slot_Container extends Contener_Slot_Abstract
    implements RecursiveIterator, Countable
{
    protected $slots = array();
    
    public function __construct($options = array())
    {
        parent::__construct($options);
    }
    
    public function addSlot(Contener_Slot_Interface $slot)
    {
        $this->slots[$slot->getName()] = $slot;
        $slot->setBelongsTo(array_merge($this->getBelongsTo(), array($this->getName())));
    }
    
    public function removeSlot($name)
    {
        unset($this->slots[$name]);
    }
    
    public function getSlots()
    {
        return $this->slots;
    }
    
    function getSlot($name)
    {
        return $this->slots[$name];
    }
    
    public function isValid($data)
    {
        $valid = true;
        
        foreach ($this->slots as $slot) {
            $valid = $slot->isValid($data[$slot->getName()]) && $valid;
        }
        
        return $valid;
    }
    
    public function render($template = null, $view = null)
    {
        $return = '';
        foreach ($this->slots as $slot) {
            $return .= $slot->render(null, $view);
        }
        
        return $return;
    }
    
    function current()
    {
        return current($this->slots);
    }

    function key()
    {
        return key($this->slots);
    }

    function next()
    {
        next($this->slots);
    }

    function rewind()
    {
        reset($this->slots);
    }

    function valid()
    {
        return current($this->slots) !== false;
    }

    function hasChildren()
    {
        return ($this->getSlots() == true);
    }

    function getChildren()
    {
        return $this->getSlots();
    }
    
    public function count()
    {
        return count($this->slots);
    }
}