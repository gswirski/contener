<?php

abstract class Contener_Slot_Abstract implements Contener_Slot_Interface
{   
    protected $name;
    protected $label;
    protected $validators = array();
    
    protected $belongsTo = array();
    protected $errors = array();
    
    public function __construct($data = array(), $serialized = false)
    {
        $this->init();
        
        if ($data) {
            if ($serialized) {
                $this->setSerializedData($data);
            } else {
                $this->setData($data);
            }
        }
    }
    
    public function init() {}
    
    public function setSerializedData($data)
    {
        $data =  $this->_unserialize($data);
        $this->setData($data);
        
        return $this;
    }
    
    protected function _unserialize($data) {
        foreach ($data['__children'] as $key => $child) {
            $data['__children'][$key] = $this->_unserialize($child);
        }
        
        if (substr($data['body'], 0, 2) == 'a:') {
            $new = unserialize($data['body']);
        } else {
            $new = array('value' => $data['body']);
        }
        
        $data = array_merge($data, $new);
        
        return $data;
    }
    
    public function setData($data)
    {
        foreach ($data as $key => $value) {
            $this->setOption($key, $value);
        }
        
        return $this;
    }
    
    public function getOption($name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        } else {
            //return $this->options[$name];
        }
    }
    
    public function setOption($name, $value)
    {
        $method = 'set' . ucfirst($name);
        if (method_exists($this, $method)) {
            $this->$method($value);
        } else {
            //$this->options[$name] = $value;
        }
        
        return $this;
    }
    
    public function getName()
    {
        return ($this->name)?$this->name:'';
    }
    
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    public function getLabel()
    {
        return ($this->label)?$this->label:'<em>Edytuj obszar</em>';
    }
    
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }
    
    public function getValidators()
    {
        return $this->validators;
    }
    
    public function setValidators($validators)
    {
        $this->validators = array();
        $this->addValidators($validators);
        return $this;
    }
    
    public function addValidators($validators)
    {
        $this->validators = $this->validators + $validators;
        return $this;
    }
    
    public function addValidator($validator)
    {
        $this->validators[] = $validator;
        return $this;
    }
    
    public function removeValidators()
    {
        $this->validators = array();
        return $this;
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
    
    public function __get($name)
    {
        return $this->getOption($name);
    }
    
    public function __set($name, $value)
    {
        $this->setOption($name, $value);
    }
}