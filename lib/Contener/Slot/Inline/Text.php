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
    
    public function render($template = null, $view = null)
    {
        $class = 'box';
        $error = '';
        if ($this->hasErrors()) {
            $class .= ' error';
            
            $error = '<ul class="errors"><li>';
            $error .= implode('</li><li>', $this->getErrors());
            $error .= '</li></ul>';
        }
        return '
            <label for="'.$this->getId().'">'.$this->getLabel().'</label>
            '.$error.'
            <div class="input">'.$this->renderEditorTag().'</div>
        ';
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
    
    protected function renderEditorTag()
    {
        if ($this->getOption('length') == 'short') {
            return '<input type="text" id="'.$this->getId().'" name="'.$this->getFullyQualifiedName().'" value="'.$this->getValue().'" />';
        } else if ($this->getOption('length') == 'long') {
            $class = '';
            if ($this->getOption('use_wysiwyg')) {
                $class = ' class="wysiwyg"';
            }
            return '<textarea id="'.$this->getId().'"'.$class.' name="'.$this->getFullyQualifiedName().'">'.$this->getValue().'</textarea>';
        }
    }
}