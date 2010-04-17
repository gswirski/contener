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
        $view->getHelperSet()->set(new Contener_View_Helper_Slot);
        
        $stackElement = new Contener_Slot_Container();
        $stackElement->addSlot(new Contener_Slot_Inline_File(array('name' => 'file', 'label' => 'Plik')));
        $stackElement->addSlot(new Contener_Slot_Inline_Text(array('name' => 'title', 'label' => 'Tytuł')));
        
        $slot = new Contener_Slot_Container_Stack(array('name' => 'files', 'label' => 'Wybierz pliki'));
        $slot->setStackType($stackElement);
        
        $manager = new Contener_Slot_Manager();
        $manager->addSlot($slot);
        
        if ($data) {
            $manager->isValid($data['slots']);
        }
        
        echo $view->slot->display($manager);
        echo '<input type="submit" />';
        return '<h2>Media</h2><p>Przeglądanie listy plików</p>' . ob_get_clean();
    }
    
    public function renderFile($slot, $view)
    {
        echo $view . ': '; print_r($slot);
    }
    
    public function renderHtmlAdd()
    {
        return '<h2>Dodaj media</h2>';
    }
    
    public function postMultipart()
    {
        return $this->renderHtml($this->requestData());
    }
}
