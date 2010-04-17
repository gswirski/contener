<?php

class Contener_Slot_Inline_File extends Contener_Slot_Inline
{
    protected $file;
    
    /**
     * Used when waking from database
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }
    
    public function getFile()
    {
        return $this->file;
    }
    
    /**
     * Used to point where uploaded file is
     */
    public function setValue($value)
    {
        if (array_key_exists('tmp_name', $value) && $value['tmp_name']) {
            if (array_key_exists('name', $value)) {
                $file = new k_adapter_UploadedFile($value, $this->getId, new k_adapter_DefaultUploadedFileAccess());
            } else {
                throw new Exception('Unexpected situation');
            }
            
            $handler = new Contener_Application_Data($file->tmp_name(), Contener_Application_Data::WEB);
            $handler->copy('uploads/' . $file->name());
            $this->setFile($file->name());
        }
        
        return parent::setValue(null);
    }
    
    public function editable()
    {
        return array_merge(parent::editable(),
            array(
                'file' => 'file'
            )
        );
    }
}