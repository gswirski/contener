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