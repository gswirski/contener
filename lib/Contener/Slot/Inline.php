<?php

abstract class Contener_Slot_Inline extends Contener_Slot_Abstract
{
    protected $value;
    
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
    
    public function getValue()
    {
        return $this->value;
    }
    
    public function renderSections(Contener_View $view)
    {
        if (is_string($this->getPlacement())) {
            return array(
                $this->getPlacement() => 'works'
            );
        }
    }
    
    public function isValid($data)
    {
        $valid = parent::isValid($data);
        
        foreach ($this->getValidators() as $validator) {
            if (!$validator->isValid($data)) {
                $valid = false;
                $errors = $validator->getMessages();
                $this->setErrors(array_merge($this->getErrors(), $errors));
            }
        }
        
        return $valid;
    }
}