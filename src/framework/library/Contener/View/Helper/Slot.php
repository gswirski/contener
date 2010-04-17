<?php

class Contener_View_Helper_Slot extends sfTemplateHelper
{
    protected $renderers = array();
    
    public function __construct()
    {
        $this->renderers['Contener_Slot_Container']['*'] = new Contener_View_SlotRenderer_Container;
    }
    
    public function getName()
    {
        return 'slot';
    }
    
    public function display($slot, $view = 'show')
    {
        $renderer = $this->getRenderer($slot, $view);
        if (is_object($renderer)) {
            return $renderer->display($slot, $view, $this);
        } else if (is_callable($renderer)) {
            return call_user_func($renderer, $slot, $view, $this);
        }
        
        throw new Exception('Couldn\'t display slot');
    }
    
    public function getRenderer($slot, $view = 'show')
    {
        $wasObject = false;
        if (is_object($slot)) {
            $slot = get_class($slot);
            $wasObject = true;
        }
        
        $group = $this->findRendererGroup($slot, $wasObject);
        
        if (array_key_exists($view, $group)) {
            $callback = $group[$view];
        } else {
            $callback = $group['*'];
        }
        
        return $callback;
    }
    
    protected function findRendererGroup($slot, $wasObject = false)
    {
        if (array_key_exists($slot, $this->renderers)) {
            return $this->renderers[$slot];
        } else {
            if ($wasObject == true) {
                $reflection = new ReflectionClass($slot);
                $parent = (array) $reflection->getParentClass();
                if (array_key_exists('name', $parent)) {
                    return $this->findRendererGroup($parent['name'], true);
                }
            }
        }
        
        throw new Exception('There is no renderer to display ' . $slot . ' slot');
    }
    
    public function addRenderer($class, $callback, $view = '*')
    {
        $this->renderers[$class][$view] = $callback;
    }
}