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
