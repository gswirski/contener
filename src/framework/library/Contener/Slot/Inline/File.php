<?php

class Contener_Slot_Inline_File extends Contener_Slot_Inline
{
    protected $file;
    protected $mimeType;
    
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
    
    public function setMimeType($mime)
    {
        $this->mimeType = $mime;
        return $this;
    }
    
    public function getMimeType()
    {
        return $this->mimeType;
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
            
            $type = $file->type();
            
            if ($type == 'application/octet-stream') {
                $parts = explode('.', $file->name());
                $extension = array_pop($parts);
                
                switch ($extension) {
                    case 'png':
                        $type = 'image/png';
                        break;
                    case 'jpg':
                    case 'jpeg':
                        $type = 'image/jpeg';
                        break;
                }
            }
            
            $this->setMimeType($type);
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