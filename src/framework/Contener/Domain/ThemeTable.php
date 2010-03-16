<?php
/**
 */
class Contener_Domain_ThemeTable extends Doctrine_Table
{
    public function listThemes($active, $baseDir)
    {
        $databaseThemesData = Doctrine_Query::create()->select()->from('Contener_Domain_Theme t')->fetchArray();
        $databaseThemes = array();
        foreach ($databaseThemesData as $databaseThemeData) {
            $databaseThemes[$databaseThemeData['name']] = $databaseThemeData;
        }
        
        $themes = array();
        $themesDirectory = $baseDir . '/themes';
        $themesIterator = new DirectoryIterator($themesDirectory);
        
        foreach ($themesIterator as $theme) {
            $name = $theme->getFilename();
            
            if ($theme->isDot() || !$theme->isDir()) { continue; }
            if (!file_exists($themeFile = $theme->getPathname() . '/theme.php')) { continue; }
            
            $themeConfig = include $themeFile;
            if ($active == $name) {
                $themeConfig['is_active'] = true;
            } else {
                $themeConfig['is_active'] = false;
            }
            
            $slots = new Contener_Slot_Container(array('name' => 'slots'));
            foreach($themeConfig['slots'] as $slotName => $slotObject) {
                $slotObject->setName($slotName);
                $slots->addSlot($slotObject);
            }
            $themeConfig['slots'] = $slots;
            
            if (array_key_exists($name, $databaseThemes)) {
                unset($databaseThemes[$name]);
            } else {
                $databaseTheme = new Contener_Domain_Theme;
                $databaseTheme->name = $name;
                $databaseTheme->is_active = false;
                $databaseTheme->file_path = $theme->getPathname();
                $databaseTheme->save();
            }
            
            $themes[$name] = $themeConfig;
        }
        
        $toDelete = array_keys($databaseThemes);
        if ($toDelete) {
            Doctrine_Query::create()->delete('Contener_Domain_Theme t')->whereIn('t.name', $toDelete)->execute();
        }
        return $themes;
    }
}