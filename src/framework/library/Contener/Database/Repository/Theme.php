<?php

class Contener_Database_Repository_Theme extends Contener_Database_Repository
{
    protected $themeConfig;
    
    public function setThemeConfig(array $themeConfig)
    {
        $this->themeConfig = $themeConfig;
    }
    
    public function buildEntity($data)
    {
        $entity = new Contener_Theme($data);
        $entity->getSlotManager()->addSlots($this->themeConfig['slots']);
        
        return $entity;
    }
    
    public function findOneBy($column, $value)
    {
        $theme = Doctrine_Query::create()
            ->select()
            ->from('Contener_Database_Model_Theme t, t.Slots s');
        
        if ($value) {
            $theme->where('t.'.$column.' = ?', $value);
        } else {
            $theme->where('t.is_active = ?', true);
        }
        
        $data = $theme->orderBy('s.lft')->fetchOne(array(), 'Contener_Database_Hydrator');
        return $this->buildEntity($data);
    }
    
    public function listAll($selected, $baseDir)
    {
        $databaseThemesData = Doctrine_Query::create()->select()->from('Contener_Database_Model_Theme t')->fetchArray();
        $databaseThemes = array();
        foreach ($databaseThemesData as $databaseThemeData) {
            $databaseThemes[$databaseThemeData['name']] = $databaseThemeData;
            
            if ($databaseThemeData['is_active'] == true) {
                $activatedTheme = $databaseThemeData['name'];
                
                if (!$selected) {
                    $selected = $databaseThemeData['name'];
                }
            }
        }
        
        $themes = array();
        $themesDirectory = $baseDir . '/application/themes';
        $themesIterator = new DirectoryIterator($themesDirectory);
        
        foreach ($themesIterator as $theme) {
            $name = $theme->getFilename();
            
            if ($theme->isDot() || !$theme->isDir()) { continue; }
            if (!file_exists($themeFile = $theme->getPathname() . '/theme.php')) { continue; }
            
            $themeConfig = include $themeFile;
            if ($selected == $name) {
                $themeConfig['is_selected'] = true;
            } else {
                $themeConfig['is_selected'] = false;
            }
            
            if ($activatedTheme == $name) {
                $themeConfig['is_active'] = true;
            } else {
                $themeConfig['is_active'] = false;
            }
            
            /*$slots = new Contener_Slot_Manager();
            foreach($themeConfig['slots'] as $slotName => $slotObject) {
                $slotObject->setName($slotName);
                $slots->addSlot($slotObject);
            }
            $themeConfig['slots'] = $slots;*/
            
            if (array_key_exists($name, $databaseThemes)) {
                unset($databaseThemes[$name]);
            } else {
                $databaseTheme = new Contener_Database_Model_Theme;
                $databaseTheme->name = $name;
                $databaseTheme->is_active = false;
                $databaseTheme->file_path = str_replace($baseDir . '/', '', $theme->getPathname());
                $databaseTheme->save();
            }
            
            $themes[$name] = $themeConfig;
        }
        
        $toDelete = array_keys($databaseThemes);
        if ($toDelete) {
            Doctrine_Query::create()->delete('Contener_Database_Model_Theme t')->whereIn('t.name', $toDelete)->execute();
        }
        return $themes;
    }
    
    public function activate($name)
    {
        Doctrine_Query::create()
            ->update('Contener_Database_Model_Theme t')
            ->set('t.is_active', '?', false)
            ->where('t.is_active = ?', true)
            ->execute();
        
        Doctrine_Query::create()
            ->update('Contener_Database_Model_Theme t')
            ->set('t.is_active', '?', true)
            ->where('t.name = ?', $name)
            ->execute();
    }
    
    public function store($entity)
    {
        $record = $entity->data;
        $record->save();
        
        if ($entity->slotManager) {
            $this->saveSlots($record, $entity->slotManager);
        }
    }
    
    protected function saveSlots($record = null, $slotManager)
    {
        if (!$record) {
            $record = $this;
        }
        
        Doctrine_Query::create()->delete()->from('Contener_Database_Model_Slot_Theme s')->where('s.root_id = ?', $record->id)->execute();
        
        $slots = $slotManager->getSerializedData();
        
        $root = new Contener_Database_Model_Slot_Theme();
        $root->root_id = $record->id;
        $root->name = $slots['name'];
        $root->class = $slots['class'];
        $root->body = $slots['body'];
        $root->save();
        
        $treeObject = Doctrine_Core::getTable('Contener_Database_Model_Slot_Theme')->getTree();
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
        
        $slot = new Contener_Database_Model_Slot_Theme();
        $slot->root_id = $record->id;
        $slot->class = $data['class'];
        $slot->name = $data['name'];
        $slot->body = $data['body'];
        
        $slot->getNode()->insertAsLastChildOf($parent);
        
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