<?php

class Contener_Slot_Manager extends Contener_Slot_Container
{
    protected $slotsConfiguration = array();
    protected $file;
    
    function setSlots($slots)
    {
        $this->slotsConfiguration = $slots;
        return $this;
    }
    
    function manage()
    {
        print_r($this->slotConfiguration);
        /*$repository = new Contener_Database_Repository_Theme();
        $path = $repository->findOneBy('is_active', true)->file_path;
        
        if (file_exists($file = '../' . $path . '/theme.php')) {
            $config = include $file;
            
            if (array_key_exists($this->getFile(), $config['templates'])) {
                foreach ($config['templates'][$this->getFile()]['slots'] as $slot) {
                    $this->addSlot($slot);
                }
            }
        }
        
        foreach ($this->slotsConfiguration as $slot) {
            $this->slots[$slot['name']]->setData($slot);
        }
        
        unset($this->slotsConfiguration);*/
    }
    
    function sleep()
    {
        $children = array();
        foreach ($this->slots as $slot) {
            $children[] = $slot->sleep();
        }
        
        return array(
            'class' => 'Contener_Slot_Manager',
            'name' => 'slots',
            'body' => '',
            'children' => $children
        );
    }
    
    function getName()
    {
        return 'slots';
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
