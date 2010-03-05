<?php

/**
 * Contener_Domain_Node
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class Contener_Domain_Node 
    extends Contener_Domain_Base_Node 
    implements Contener_Navigation_Interface
{
    public function getSlotManager()
    {
        if (!isset($this->slotManager)) {
            $slots = $this->toArray();
            $slots = $slots['Slots'];
            
            $this->mapValue('slotManager', new $slots[0]['class']);
            $this->slotManager->setSerializedData($slots[0])->manage();
        }
        
        return $this->slotManager;
    }
    
    public function postSave($event)
    {
        $record = $event->data;
        
        $this->saveSlots($record);
    }
    
    static function fetch($id)
    {
        $page = Doctrine_Query::create()
            ->select()
            ->from('Contener_Domain_Node p, p.Slots s, p.Author a')
            ->where('p.id = ?', $id)
            ->orderBy('s.lft')
            ->fetchOne(array(), 'Contener_Database_Hydrator');
        
        return $page;
    }
    
    static function fetchAll()
    {
        $page = Doctrine_Query::create()
            ->select()
            ->from('Contener_Domain_Node p, p.Slots s, p.Author a')
            ->orderBy('p.lft, s.lft')
            ->execute(array(), 'Contener_Database_Hydrator');
        
        return $page;
    }
    
    protected $pages = array();
    protected $subNavigations = array();
    protected $active = false;
    
    function addPage($page)
    {
        if (is_array($page)) {
            $page = new Contener_Navigation_Node($page);
        }
    
        if (!$page instanceof Contener_Navigation_Interface) {
            throw new Exception('Invalid argument: $page must be an instance of ' .
            'Contener_Navigation_Node or an array');
        }
    
        $hash = spl_object_hash($page);
    
        if (array_key_exists($hash, $this->pages)) {
            return $this;
        }
    
        $this->pages[$hash] = $page;
    
        return $this;
    }
    
    function addPages(array $pages)
    {
        foreach ($pages as $page) {
            $this->addPage($page);
        }
    }
    
    function setPages($pages)
    {
        $this->removePages();
        $this->addPages($pages);
    
        return $this;
    }
    
    function getPages()
    {
        return $this->pages;
    }
    
    function removePage($page) {
        if ($page instanceof Contener_Navigation_Node) {
            $page = spl_object_hash($page);
        }
    
        unset($this->pages[$page]);
    
        return $this;
    }
    
    function removePages()
    {
        $this->pages = array();
    }
    
    
    function hasPage(Contener_Navigation_Interface $page, $recursive = false)
    {
        if (array_key_exists(spl_object_hash($page), $this->pages)) {
            return true;
        } elseif ($recursive) {
            foreach ($this->pages as $childPage) {
                if ($childPage->hasPage($page, true)) {
                    return true;
                }
            }
        }
    
        return false;
    }
    
    function hasPages()
    {
        return count($this->pages) > 0;
    }
    
    function addSubNavigation(Contener_Navigation_Interface $navigation)
    {
        $this->subNavigations[] = $navigation;
        return $this;
    }
    
    function current()
    {
        return current($this->pages);
    }
    
    function key()
    {
        return key($this->pages);
    }
    
    function next()
    {
        next($this->pages);
    }
    
    function rewind()
    {
        reset($this->pages);
    }
    
    function valid()
    {
        return current($this->pages) !== false;
    }
    
    function hasChildren()
    {
        return $this->hasPages();
    }
    
    function getChildren()
    {
        $hash = key($this->pages);
        return $this->pages[$hash];
    }
    
    public function count()
    {
        return count($this->pages);
    }
    
    public function findOneBy($property, $value)
    {
        $iterator = new RecursiveIteratorIterator($this,
                            RecursiveIteratorIterator::SELF_FIRST);
    
        foreach ($iterator as $page) {
            if (isset($page->$property) && $page->$property == $value) {
                return $page;
            }
        }
    
        return null;
    }
    
    public function findAllBy($property, $value)
    {
        $found = array();
    
        $iterator = new RecursiveIteratorIterator($this,
                            RecursiveIteratorIterator::SELF_FIRST);
    
        foreach ($iterator as $page) {
            if (isset($page->$property) && $page->$property == $value) {
                $found[] = $page;
            }
        }
    
        return $found;
    }
    
    public function findBy($property, $value, $all = false)
    {
        if ($all) {
            return $this->findAllBy($property, $value);
        } else {
            return $this->findOneBy($property, $value);
        }
    }
    
    public function setActive($value)
    {
        $this->active = $value;
    }
    
    public function isActive()
    {
        if ($this->active) {
            return array('page' => true, 'tree' => true);
        } else {
            foreach ($this->pages as $page) {
                $sub = $page->isActive();
                if ($sub['tree']) {
                    return array('page' => false, 'tree' => true);
                }
            }
    
            foreach ($this->subNavigations as $subNavigation) {
                $sub = $subNavigation->isActive();
                if ($sub['tree']) {
                    return array('page' => false, 'tree' => true);
                } 
            }
        }
        return array('page' => false, 'tree' => false);
    }
    
    protected function saveSlots($record = null)
    {
        if (!$record) {
            $record = $this;
        }
        
        Doctrine_Query::create()->delete()->from('Contener_Domain_Slot s')->where('s.node_id = ?', $record->id)->execute();
        
        $slots = $this->slotManager->sleep();
        
        $root = new Contener_Domain_Slot();
        $root->node_id = $record->id;
        $root->name = 'root';
        $root->class = $slots['class'];
        $root->body = $slots['body'];
        $root->save();
        
        $treeObject = Doctrine_Core::getTable('Contener_Domain_Slot')->getTree();
        $treeObject->createRoot($root, $record->id);
        
        //print_r($slots);
        
        foreach ($slots['children'] as $slot) {
            $this->saveSlot($slot, $root, $record);
        }
    }
    
    protected function saveSlot($data, $parent, $record = null)
    {
        if (!$record) {
            $record = $this;
        }
        
        $slot = new Contener_Domain_Slot();
        $slot->node_id = $record->id;
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
    
    function isValid($deep = false, $hooks = true)
    {
        if (count(func_get_args()) > 1) {
            return parent::isValid($deep, $hooks);
        } else {
            $data = $deep;
        }
        
        $valid = true;
        
        $slotManager = $this->getSlotManager();
        
        foreach ($slotManager as $slot) {
            $valid = $slot->isValid($data['slots'][$slot->getName()]) && $valid;
        }
        
        unset($data['slots']);
        
        $columns = $this->getTable()->getColumns();
        
        foreach ($data as $name => $value) {
            if (array_key_exists($name, $columns)) {
                $this->__set($name, $value);
            }
        }
        
        return $valid;
    }
}