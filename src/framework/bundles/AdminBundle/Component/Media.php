<?php

class AdminBundle_Component_Media extends Contener_Component
{
    public function dispatch()
    {
        $media = new Contener_Navigation(array(
            array(
                'title' => 'Dodaj media',
                'path' => '/admin/media?add'
            )
        ));
        
        $types = new Contener_Navigation(array(
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
        ));
        
        $mainNode = $this->context->area('menu')->findOneBy('path', '/admin/media');
        $mainNode->addPage($media);
        $mainNode->addPage($types);
        
        $media = new Contener_View_Widget_Navigation($this->getService('view'), $media);
        $types = new Contener_View_Widget_Navigation($this->getService('view'), $types);
        $this->context->area('left')->addModule('Media', $media);
        $this->context->area('left')->addModule('Przeglądaj', $types);
        
        return parent::dispatch();
    }
    
    public function renderHtml()
    {
        return '<h2>Media</h2><p>Przeglądanie listy plików</p>';
    }
    
    public function renderHtmlAdd()
    {
        return '<h2>Dodaj media</h2>';
    }
}
