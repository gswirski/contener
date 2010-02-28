<?php

class Contener_Domain_PageType_Configurator
{
    protected $class;
    protected $manager;
    protected $templates;
    
    public function setClass($value)
    {
        $this->class = $value;
        return $this;
    }
    
    public function getClass()
    {
        return $this->class;
    }
    
    public function setSlotManager($value, $options)
    {
        $this->manager = new $value($options);
        return $this;
    }
    
    public function getSlotManager()
    {
        return $this->manager;
    }
    
    public function setTemplates(array $value)
    {
        $this->templates = $value;
        return $this;
    }
    
    public function getTemplates()
    {
        return $this->templates;
    }
    
    public function getData()
    {
        $spec = $this->manager->spec();
        
        foreach ($spec as $name => $value) {
            $method = 'get' . ucfirst($name);
            $spec[$name] = $this->manager->$method();
        }
        
        return array(
            'class' => $this->class,
            'body' => serialize($spec)
        );
    }
}
