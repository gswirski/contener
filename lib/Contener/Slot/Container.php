<?php

class Contener_Slot_Container extends Contener_Slot_Abstract
    implements RecursiveIterator, Countable
{
    protected $slots = array();
    
    public function setData($data) {
        if (array_key_exists('__children', $data)) {
            $data['slots'] = $data['__children'];
            unset($data['__children']);
        }
        
        parent::setData($data);
    }
    
    public function addSlot(Contener_Slot_Interface $slot)
    {
        $this->slots[$slot->getName()] = $slot;
        $slot->setBelongsTo(array_merge($this->getBelongsTo(), array($this->getName())));
    }
    
    public function addSlots($slots)
    {
        foreach ($slots as $slot) {
            if (is_array($slots)) {
                if (array_key_exists($slot['name'], $this->slots)) {
                    $this->slots[$slot['name']]->setData($slot);
                } else {
                    //$this->slots[$slot['name']] = new $slot['class']($slot);
                }
            } else {
                $this->addSlot($slot);
            }
        }
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
    
    public function setSlots($slots)
    {
        $this->slots = array();
        $this->addSlots($slots);
        
        return $this;
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
