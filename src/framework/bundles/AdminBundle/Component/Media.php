<?php

class AdminBundle_Component_Media extends Contener_Component
{
    public function dispatch()
    {
        $navigation = $this->getService('view')->getNavigation();
        $navigation->findOneBy('path', '/admin/media')->addPages(array(
            array(
                'title' => '<h3 class="opened">Media</h3>',
                'pages' => array(
                    array(
                        'title' => 'Dodaj media',
                        'path' => '/admin/media?add'
                    )
                )
            ),
            array(
                'title' => '<h3 class="opened" style="margin-top: 15px;">Przeglądaj</h3>',
                'pages' => array(
                    array(
                        'title' => 'Wszystkie',
                        'path' => '/admin/media'
                    ),
                    array(
                        'title' => 'Obrazki',
                        'path' => '/admin/media?type=image'
                    ),
                    array(
                        'title' => 'Pozostałe',
                        'path' => '/admin/media?type=other'
                    )
                )
            )
        ));
        
        return parent::dispatch();
    }
    
    public function renderHtml($data = array())
    {
        ob_start();
        $view = $this->getService('view');
        
        $files = Doctrine_Query::create()->select()->from('Contener_Database_Model_Asset a')->orderBy('a.created_at DESC')->limit(20);
        
        $type = 'wszystkie';
        
        if ($this->query('type') == 'image') {
            $files->where('a.type LIKE ?', 'image%');
            $type = 'obrazki';
        } else if ($this->query('type') == 'other') {
            $files->where('a.type NOT LIKE ?', 'image%');
            $type = 'pozostałe';
        }
        
        $files = $files->execute(array(), Doctrine_Core::HYDRATE_ARRAY);
        
        foreach ($files as $file) {
            echo '<a href="'.$view->url->build('admin/media?edit&id='.$file['id']). '" style="float: left; width: 75px; height: 75px; -moz-box-shadow: 0 0 5px #888; margin: 5px;">';
            if (substr($file['type'], 0, 5) == 'image') {
                echo '<img src="'.$view->assets->getUrl('uploads/'.$file['file']). '" width="75" height="75" style="display: block" />';
            } else {
                echo '<div style="height: 75px; width: 75px; overflow: hidden; text-align: center;">' . $file['type'] . '</div>';
            }
            echo '<div style="text-align: center; color: #333; padding-top: 3px;">' . $file['title'] . '</div>';
            echo '</a>';
        }
        
        return '<h2>Media: '.$type.'</h2>' . ob_get_clean();
        /*ob_start();
        
        $view = $this->getService('view');
        $view->getHelperSet()->set(new Contener_View_Helper_Slot);
        
        $stackElement = new Contener_Slot_Container();
        $stackElement->addSlot(new Contener_Slot_Inline_File(array('name' => 'file', 'label' => 'Plik')));
        $stackElement->addSlot(new Contener_Slot_Inline_Text(array('name' => 'title', 'label' => 'Tytuł')));
        
        $slot = new Contener_Slot_Container_Stack(array('name' => 'files', 'label' => 'Wybierz pliki'));
        $slot->setStackType($stackElement);
        
        $manager = new Contener_Slot_Manager();
        $manager->addSlot($slot);
        
        if ($data) {
            if ($manager->isValid($data['slots'])) {
                $assets = $slot->getSlots();
                foreach ($assets as $asset) {
                    $data = $asset->getData();
                    //print_r($data);
                    $toSave = new Contener_Database_Model_Asset;
                    $toSave['title'] = $data['slots']['title']->getValue();
                    $toSave['file']  = $data['slots']['file']->getFile();
                    $toSave['type']  = $data['slots']['file']->getMimeType();
                    $toSave->save();
                }
            }
        }
        
        echo $view->slot->display($manager);
        echo '<input type="submit" />';
        return '<h2>Media</h2><p>Przeglądanie listy plików</p>' . ob_get_clean();*/
    }
    
    public function renderFile($slot, $view)
    {
        echo $view . ': '; print_r($slot);
    }
    
    public function renderHtmlAdd($data = array())
    {
        ob_start();
        
        $view = $this->getService('view');
        $view->getHelperSet()->set(new Contener_View_Helper_Slot);
        
        $slot = new Contener_Slot_Inline_File(array('name' => 'file', 'label' => 'Wybierz plik'));
        
        if ($data) {
            if ($slot->isValid($data[$slot->getName()])) {
                $entity = new Contener_Database_Model_Asset;
                $entity['title'] = $slot->getFile();
                $entity['file']  = $slot->getFile();
                $entity['type']  = $slot->getMimeType();
                $entity->save();
                
                return new k_SeeOther($this->config('request.base_url') . '/admin/media?edit&id=' . $entity->id);
            }
        }
        
        echo $view->slot->display($slot);
        echo '<br /><br /><input type="submit" name="save-file" id="save-file" value="Zapisz plik" />';
        return '<h2>Dodaj media</h2>' . ob_get_clean();
    }
    
    public function renderHtmlEdit($data = array())
    {
        $view = $this->getService('view');
        $view->getHelperSet()->set(new Contener_View_Helper_Slot);
        $navigation = $view->getNavigation()->findOneBy('title', '<h3 class="opened">Media</h3>');
        $navigation->addPage(array('path' => '/admin/media?edit&id=' . $this->query('id'), 'title' => 'Edytuj obiekt'));
        
        $file = new Contener_Slot_Inline_File(array('name' => 'file', 'label' => 'Plik'));
        $title = new Contener_Slot_Inline_Text(array('name' => 'title', 'label' => 'Tytuł obiektu'));
        
        if ($data) {
            $db = Doctrine_Core::getTable('Contener_Database_Model_Asset')->findOneById($this->query('id', 0));
            $db->title = $data['title'];
            $db->save();
            return new k_SeeOther($this->config('request.base_url') . '/admin/media');
        } else {
            $db = Doctrine_Core::getTable('Contener_Database_Model_Asset')->findOneById($this->query('id', 0), Doctrine_Core::HYDRATE_ARRAY);
            $file->setFile($db['file']);
            $file->setMimeType($db['type']);
            $title->setValue($db['title']);
        }
        
        ob_start();
        
        echo $view->slot->display($file);
        echo $view->slot->display($title);
        
        echo '<input type="submit" name="edit-file" id="edit-file" value="Zapisz zmiany" />';
        
        return '<h2>Edytuj obiekt</h2>' . ob_get_clean();
    }
    
    public function postMultipart()
    {
        $data = $this->requestData();
        
        if (array_key_exists('save-file', $data)) {
            return $this->renderHtmlAdd($data);
        } else if (array_key_exists('edit-file', $data)) {
            return $this->renderHtmlEdit($data);
        } else {
            return $this->renderHtml($this->requestData());
        }
    }
}
