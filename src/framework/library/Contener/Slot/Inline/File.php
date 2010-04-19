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
                
                if (array_key_exists($extension, $this->allowedTypes)) {
                    $type = $this->allowedTypes[$extension];
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
    
    protected $allowedTypes = array(
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpe' => 'image/jpeg',
        'gif' => 'image/gif',
        'png' => 'image/png',
        'bmp' => 'image/bmp',
        'tif' => 'image/tiff',
        'tiff' => 'image/tiff',
        'ico' => 'image/x-icon',
        'asf' => 'video/asf',
        'asx' => 'video/asf',
        'wax' => 'video/asf',
        'wmv' => 'video/asf',
        'wmx' => 'video/asf',
        'avi' => 'video/avi',
        'divx' => 'video/divx',
        'flv' => 'video/x-flv',
        'mov' => 'video/quicktime',
        'qt' => 'video/quicktime',
        'mpeg' => 'video/mpeg',
        'mpg' => 'video/mpeg',
        'mpe' => 'video/mpeg',
        'txt' => 'text/plain',
        'c' => 'text/plain',
        'cc' => 'text/plain',
        'h' => 'text/plain',
        'rtx' => 'text/richtext',
        'css' => 'text/css',
        'htm' => 'text/html',
        'html' => 'text/html',
        'mp3' => 'audio/mpeg',
        'm4a' => 'audio/mpeg',
        'mp4' => 'video/mp4',
        'm4v' => 'video/mp4',
        'ra' => 'audio/x-realaudio',
        'ram' => 'audio/x-realaudio',
        'wav' => 'audio/wav',
        'ogg' => 'audio/ogg',
        'mid' => 'audio/midi',
        'midi' => 'audio/midi',
        'wma' => 'audio/wma',
        'rtf' => 'application/rtf',
        'js' => 'application/javascript',
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/msword',
        'pot' => 'application/vnd.ms-powerpoint',
        'pps' => 'application/vnd.ms-powerpoint',
        'ppt' => 'application/vnd.ms-powerpoint',
        'pptx' => 'application/vnd.ms-powerpoint',
        'wri' => 'application/vnd.ms-write',
        'xla' => 'application/vnd.ms-excel',
        'xls' => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.ms-excel',
        'xlt' => 'application/vnd.ms-excel',
        'xlw' => 'application/vnd.ms-excel',
        'mdb' => 'application/vnd.ms-access',
        'mpp' => 'application/vnd.ms-project',
        'swf' => 'application/x-shockwave-flash',
        'class' => 'application/java',
        'tar' => 'application/x-tar',
        'zip' => 'application/zip',
        'gz' => 'application/x-gzip',
        'gzip' => 'application/x-gzip',
        'exe' => 'application/x-msdownload',
        // openoffice formats
        'odt' => 'application/vnd.oasis.opendocument.text',
        'odp' => 'application/vnd.oasis.opendocument.presentation',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        'odg' => 'application/vnd.oasis.opendocument.graphics',
        'odc' => 'application/vnd.oasis.opendocument.chart',
        'odb' => 'application/vnd.oasis.opendocument.database',
        'odf' => 'application/vnd.oasis.opendocument.formula'
    );
}