<?php

abstract class Contener_Slot_Abstract implements Contener_Slot_Interface
{
    protected $options;
    protected $value;
    protected $belongsTo = array();
    protected $errors = array();
    
    public function __construct($options = array())
    {
        $defaults = array('name' => '', 'label' => '<em>Edytuj obszar</em>', 'placement' => 'main', 'validators' => array());
        
        $this->setOptions(array_merge($defaults, $options));
        $this->init();
    }
    
    public function init() {}
    
    public static function create($options)
    {
        return new self($options);
    }
    
    public function setOptions($options)
    {
        foreach ($options as $name => $value) {
            $this->setOption($name, $value);
        }
        
        return $this;
    }
    
    public function setOption($name, $value)
    {
        $method = 'set' . ucfirst($name);
        if (method_exists($this, $method)) {
            $this->$method($value);
        } else {
            $this->options[$name] = $value;
        }
    }
    
    public function getOption($name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        } else {
            return $this->options[$name];
        }
    }
    
    public function getOptions()
    {
        return $this->options;
    }
    
    public function getName()
    {
        return $this->options['name'];
    }
    
    public function getLabel($name = null)
    {
        if ($name) {
            return $this->options['label']['name'];
        }
        return $this->options['label'];
    }
    
    public function getPlacement($name = null)
    {
        if ($name) {
            return $this->options['placement']['name'];
        }
        return $this->options['placement'];
    }
    
    public function getValidators($name = null)
    {
        if ($name) {
            return $this->options['validators']['name'];
        }
        return $this->options['validators'];
    }
    
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
    
    public function getValue()
    {
        return $this->value;
    }
    
    protected function setErrors($errors)
    {
        $this->errors = $errors;
    }
    
    public function hasErrors()
    {
        if ($this->errors) {
            return true;
        }
        
        return false;
    }
    
    public function getErrors()
    {
        return $this->errors;
    }
    
    public function setBelongsTo(array $belongs)
    {
        $this->belongsTo = $belongs;
        return $this;
    }
    
    public function getBelongsTo()
    {
        return $this->belongsTo;
    }
    
    public function getId()
    {
        if ($this->belongsTo) {
            $belongs = array_merge($this->getBelongsTo(), array($this->getName()));
            $name = implode('-', $belongs);
            
            return $name; 
        }
        
        return $this->getName();
    }
    
    public function getFullyQualifiedName()
    {
        if ($this->belongsTo) {
            $belongs = array_merge($this->getBelongsTo(), array($this->getName()));
            $base = array_shift($belongs);
            $name = $base . '[' . implode('][', $belongs) . ']';
            
            return $name; 
        }
        
        return $this->getName();
    }
    
    public function isValid($data)
    {
        $this->setValue($data);
        return true;
    }
    
    public function __toString()
    {
        return $this->render();
    }
}