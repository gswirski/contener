<?php

class Contener_Slot_Manager_Template extends Contener_Slot_Container
{
    protected $slotsConfiguration = array();
    protected $file;
    
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }
    
    public function getFile()
    {
        return ($this->file) ? $this->file : 'homepage.php';
    }
    
    
    function setSlots($slots)
    {
        $this->slotsConfiguration = $slots;
        return $this;
    }
    
    function manage()
    {
        if (file_exists($file = 'application/pages/' . $this->getFile() . '.php')) {
            include $file;
        } else {
            //throw new Exception('Unable to find slot schema for this page');
        }
        
        foreach ($this->slotsConfiguration as $slot) {
            $this->slots[$slot['name']]->setData($slot);
        }
        
        unset($this->slotsConfiguration);
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
            'body' => serialize(array('file' => $this->getFile())),
            'children' => $children
        );
    }
    
    function getName()
    {
        return 'slots';
    }
}