<?php

class Contener_View_Widget
{
    protected $view;
    
    public function setView($view)
    {
        $this->view = $view;
        return $this;
    }
    
    public function getView()
    {
        return $this->view;
    }
}