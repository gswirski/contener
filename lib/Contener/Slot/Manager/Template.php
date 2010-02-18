<?php

class Contener_Slot_Manager_Template extends Contener_Slot_Container
{   
    protected $options = array();
    
    function __construct($options)
    {   
        $this->options = $options;
        
        if (file_exists($file = 'application/pages/' . $options['name'] . '.php')) {
            include $file;
        } else {
            //throw new Exception('Unable to find slot schema for this page');
        }
    }
    
    static function wakeUp($data)
    {
        $body = unserialize($data['body']);
        $object = new self($body);
        
        foreach ($data['__children'] as $child) {
            $object->getSlot($child['name'])->wakeUp($child);
        }
        
        return $object;
    }
    
    function sleep()
    {
        $children = array();
        foreach ($this->slots as $slot) {
            $children[] = $slot->sleep();
        }
        
        return array(
            'class' => 'Contener_Slot_Manager_Template',
            'name' => 'root',
            'body' => serialize($this->options),
            'children' => $children
        );
    }
    
    function getName()
    {
        return 'slots';
    }
}