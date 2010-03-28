<?php

class Contener_Slot_Container extends Contener_Slot_Abstract
    implements RecursiveIterator, Countable
{
    protected $slots = array();
    
    protected function _serialize($data)
    {
        $slots = array();
        
        if (array_key_exists('slots', $data)) {
            $slots = $data['slots'];
            unset($data['slots']);
        }
        
        foreach ($slots as $key => $value) {
            if ($value instanceof Contener_Slot_Abstract) {
                $slots[$key] = $value->getSerializedData();
            }
        }
        
        return array_merge(parent::_serialize($data), array('slots' => $slots));
    }
    
    protected function _unserialize($data)
    {
        if (array_key_exists('__children', $data)) {
            foreach ($data['__children'] as $key => $child) {
                $data['__children'][$key] = $this->_unserialize($child);
            }
        }
        
        return parent::_unserialize($data);
    }
    
    public function setData($data, $precedence = true)
    {
        foreach ($data as $key => $value) {
            if ($key == 'slots' or $key == '__children') {
                if ($value) {
                    $this->setSlots($value);
                }
                continue;
            }
            if (!$precedence and $this->getOption($key)) {
                continue;
            } 
            $this->setOption($key, $value);
        }
        return $this;
    }
    
    public function addSlot(Contener_Slot_Interface $slot)
    {
        $this->slots[$slot->getName()] = $slot;
        $slot->setBelongsTo(array_merge($this->getBelongsTo(), array($this->getName())));
    }
    
    public function addSlots($slots)
    {
        if (!$slots) { return $this; }
        foreach ($slots as $slot) {
            if ($slot instanceof Contener_Slot_Abstract) {
                $this->addSlot($slot);
            } else if (is_array($slot)) {
                if (array_key_exists($slot['name'], $this->slots)) {
                    $this->slots[$slot['name']]->setData($slot);
                } else {
                    $this->addSlot(new $slot['class']($slot));
                }
            } else {
                throw new Exception('Slot must be array or instance of Contener_Slot_Abstract');
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
    
    public function setSlots(array $slots)
    {
        $old = $this->slots;
        
        $this->slots = array();
        $this->addSlots($slots);
        
        foreach ($old as $name => $slot) {
            if (isset($this->slots[$name])) {
                $this->slots[$name]->setData($slot->getData());
            }
        }
        
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
    
    public function spec()
    {
        return array_merge(parent::spec(), array('slots' => 'array'));
    }
}
