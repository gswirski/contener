<?php

class Contener_Slot_Inline_Photo extends Contener_Slot_Inline_File
{
    public function setPhoto($photo)
    {
        return $this->setFile($photo);
    }
    
    public function getPhoto()
    {
        return $this->getFile();
    }
    
    public function editable()
    {
        $editable = parent::editable();
        $editable['file'] = 'photo';
        return $editable;
    }
}