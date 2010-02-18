<?php

class Contener_Page extends Contener_Navigation_Node
{
    protected $database;
    protected $slots;
    
    function __construct(Doctrine_Record $data)
    {
        $this->database = $data;
        
        $data = $data->toArray();
        $this->slots = $data['Slots'][0]['class']::wakeUp($data['Slots'][0]);
        unset($data['Slots']);
        
        parent::__construct($data);
    }
    
    function __get($key)
    {
        if ($this->database->getTable()->hasColumn($key)) {
            return $this->database->$key;
        }
        
        return $this->$key;
    }
    
    function __set($key, $value)
    {
        $this->$key = $value;
        if ($this->database->getTable()->hasColumn($key)) {
            $this->database->$key = $value;
        }
    }
    
    function isValid($data)
    {
        $valid = true;
        
        foreach ($this->slots as $slot) {
            $valid = $slot->isValid($data['slots'][$slot->getName()]) && $valid;
        }
        
        unset($data['slots']);
        
        foreach ($data as $name => $value) {
            $this->__set($name, $value);
        }
        
        return $valid;
    }
    
    public function save()
    {
        /*$old = $this->database->getModified(true);
        $permalink = explode('/', trim($old['permalink'], '/'));
        array_pop($permalink);
        $permalink[] = $this->permalink;
        
        $this->permalink = '/' . implode('/', $permalink) . '/';
        */
        $this->database->save();
        $this->saveSlots();
        
        return $this;
    }
    
    protected function saveSlots()
    {
        Doctrine_Query::create()->delete()->from('Contener_Domain_Slot s')->where('s.page_id = ?', $this->id)->execute();
        
        $slots = $this->slots->sleep();
        
        $root = new Contener_Domain_Slot();
        $root->page_id = $this->id;
        $root->name = 'root';
        $root->class = $slots['class'];
        $root->body = $slots['body'];
        $root->save();
        
        $treeObject = Doctrine_Core::getTable('Contener_Domain_Slot')->getTree();
        $treeObject->createRoot($root, $this->id);
        
        //print_r($slots);
        
        foreach ($slots['children'] as $slot) {
            $this->saveSlot($slot, $root);
        }
    }
    
    protected function saveSlot($data, $parent)
    {
        $slot = new Contener_Domain_Slot();
        $slot->page_id = $this->id;
        $slot->class = $data['class'];
        $slot->name = $data['name'];
        $slot->body = $data['body'];
        
        $slot->getNode()->insertAsLastChildOf($parent);
        
        if (array_key_exists('children', $data) and is_array($data['children'])) {
            if ($data['children']) {
                foreach ($data['children'] as $child) {
                    $this->saveSlot($child, $slot);
                }
            }
        }
    }
}