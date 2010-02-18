<?php

class Contener_Dispatcher extends Contener_Component {
    function renderHtml()
    {
        return 'Strona użytkownika';
    }
    
    function map($name)
    {
        if ($name == 'admin') {
            return 'Contener_Context_Admin';
        }
        
        return 'Contener_Context_Default';
    }
  /*function execute() {
    return $this->wrap(parent::execute());
  }
  function wrapHtml($content) {
    $t = new Contener_View("templates/document.tpl.php");
    
    return
      $t->render(
        $this,
        array(
          'content' => $content,
          'title' => $this->document->title(),
          'scripts' => $this->document->scripts(),
          'styles' => $this->document->styles(),
          'onload' => $this->document->onload()));
  }
  function renderHtml() {
      return $this->forward('Contener_Page');
  }
  
  function map($name)
  {
      if ($name == 'admin') {
          return 'Contener_Context_Admin';
      }
      
      return 'Contener_Page';
  }
  
  function dispatch()
  {
      return parent::dispatch();
  }*/
}
