<?php

class Contener_Slot_Inline_Text extends Contener_Slot_Inline
{
    protected $length;
    
    public function setLength($length)
    {
        $this->length = $length;
        return $this;
    }
    
    public function getLength()
    {
        return ($this->length) ? $this->length : 'short';
    }
    
    public function wakeUp($data)
    {
        $this->setValue($data['body']);
    }
    
    public function sleep()
    {
        return array(
            'class' => 'Contener_Slot_Text',
            'name' => $this->getName(),
            'body' => $this->getValue()
        );
    }
    
    public function editable()
    {
        if ($this->getLength() == 'short') {
            $length = 'string';
        } else if ($this->getLength() == 'long') {
            $length = 'text';
        } else {
            throw new Exception('Slot length must be `short` or `long`');
        }
        return array_merge(parent::editable(),
            array(
                'value' => $length
            )
        );
    }
}