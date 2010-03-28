<?php

class Contener_Database_Repository_Node extends Contener_Database_Repository
{
    protected $themeConfig;
    protected $template = null;
    
    public function setThemeConfig(array $themeConfig)
    {
        $this->themeConfig = $themeConfig;
    }
    
    public function setTemplate($template)
    {
        $this->template = $template;
    }
    
    public function buildEntity($data)
    {
        $node = new Contener_Node($data->toArray());
        
        if ($this->template !== null) {
            $template = $this->template;
        } else {
            $template = $node->template;
        }
        
        if (isset($this->themeConfig['templates']) && isset($this->themeConfig['templates'][$template]) && isset($this->themeConfig['templates'][$template]['slots'])) {
            $slots = $this->themeConfig['templates'][$template]['slots'];
            if (isset($this->themeConfig['templates'][$template]['is_open']) && $this->themeConfig['templates'][$template]['is_open']) {
                $node->getSlotManager()->addSlots($slots);
            } else {
                $node->getSlotManager()->setSlots($slots);
            }
        }
        
        return $node;
    }
    
    public function listAll($style = 'tree')
    {
        if ($style == 'tree') {
            $hydration = Doctrine_Core::HYDRATE_ARRAY_HIERARCHY;
        } else if ($style == 'flat') {
            $hydration = Doctrine_Core::HYDRATE_ARRAY;
        }
        
        return Doctrine_Query::create()
            ->select()
            ->from('Contener_Database_Model_Node p')
            ->where('p.level != ?', 0)
            ->orderBy('p.lft')
            ->execute(array(), $hydration);
    }
    
    public function findOneBy($column, $value, $buildEntity = true)
    {
        $node = Doctrine_Query::create()
            ->select()
            ->from('Contener_Database_Model_Node p, p.Slots s, p.Author a')
            ->where('p.'.$column.' = ?', $value)
            ->orderBy('s.lft')
            ->fetchOne(array(), 'Contener_Database_Hydrator');
        
        if ($buildEntity) {
            return $this->buildEntity($node);
        } else {
            return $node;
        }
    }
    
    public function store($entity)
    {
        $slotManager = $entity->getSlotManager();
        $entity = (array) $entity;
        
        if (isset($entity['id']) && $entity['id']) {
            $model = Doctrine_Core::getTable('Contener_Database_Model_Node')->find($entity['id']);
        } else {
            $model = new Contener_Database_Model_Node;
        }
        
        if (array_key_exists('filtered_title', $entity)) {
            $permalink = explode('/', trim($entity['permalink'], '/'));
            array_pop($permalink);
            $permalink[] = $entity['filtered_title'];
            $entity['permalink'] = '/' . implode('/', $permalink) . '/';
        }
        
        $columns = Doctrine_Core::getTable('Contener_Database_Model_Node')->getColumns();
        foreach ((array) $entity as $name => $value) {
            if (array_key_exists($name, $columns)) {
                $model->$name = $value;
            }
        }
        $model->save();
        
        $this->saveSlots($model, $slotManager);
    }
    
    protected function saveSlots($record = null, $slotManager)
    {
        if (!$record) {
            $record = $this;
        }
        
        Doctrine_Query::create()->delete()->from('Contener_Database_Model_Slot_Node s')->where('s.root_id = ?', $record->id)->execute();
        
        $slots = $slotManager->getSerializedData();
        
        $root = new Contener_Database_Model_Slot_Node();
        $root->root_id = $record->id;
        $root->name = $slots['name'];
        $root->class = $slots['class'];
        $root->body = $slots['body'];
        $root->save();
        
        $treeObject = Doctrine_Core::getTable('Contener_Database_Model_Slot_Node')->getTree();
        $treeObject->createRoot($root, $record->id);
        
        $slots['slots'] = array_reverse($slots['slots']);
        foreach ($slots['slots'] as $slot) {
            $this->saveSlot($slot, $root, $record);
        }
    }
    
    protected function saveSlot($data, $parent, $record = null)
    {
        if (!$record) {
            $record = $this;
        }
        
        $slot = new Contener_Database_Model_Slot_Node();
        $slot->root_id = $record->id;
        $slot->class = $data['class'];
        $slot->name = $data['name'];
        $slot->body = $data['body'];
        
        $slot->getNode()->insertAsFirstChildOf($parent);
        
        if (array_key_exists('slots', $data) and is_array($data['slots'])) {
            if ($data['slots']) {
                $data['slots'] = array_reverse($data['slots']);
                foreach ($data['slots'] as $child) {
                    $this->saveSlot($child, $slot);
                }
            }
        }
    }
}