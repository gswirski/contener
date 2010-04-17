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
    
    public function renderHtml()
    {
        ob_start();
        $slotManager = new Contener_Slot_Manager();
        
        $file = new Contener_Slot_Inline_File();
        $slotManager->addSlot($file);
        
        $view = $this->getService('view');
        $view->getHelperSet()->set(new Contener_View_Helper_Slot);
        
        $view->slot->addRenderer('Contener_Slot_Inline_File', array($this, 'renderFile'));
        
        
        
        $view->slot->display($slotManager);
        
        return '<h2>Media</h2><p>Przeglądanie listy plików</p><pre>' . ob_get_clean() . '</pre>';
    }
    
    public function renderFile($slot, $view)
    {
        echo $view . ': '; print_r($slot);
    }
    
    public function renderHtmlAdd()
    {
        return '<h2>Dodaj media</h2>';
    }
}
