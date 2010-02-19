<?php

class Contener_Context_Admin_Includes_Editor
{
    protected $slot;
    
    public function __construct($slot) {
        $this->slot = $slot;
    }
    
    public function __toString()
    {
        try {
            $t = new Contener_View('admin/' . get_class($this->slot));
            return $t->render($this->slot, array());
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}