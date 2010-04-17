<?php

class Contener_View_SlotRenderer_Container extends Contener_View_SlotRenderer
{
    public function display($slot, $view, $rendererSchema)
    {
        $return = '';
        
        foreach ($slot->getSlots() as $child) {
            $renderer = $rendererSchema->getRenderer($child, $view);
            
            if (is_object($renderer)) {
                $return .= $renderer->display($child, $view, $this);
            } else if (is_callable($renderer)) {
                $return .= call_user_func($renderer, $child, $view, $this);
            } else {
                throw new Exception('Couldn\'t display slot');
            }
        }
        
        return $return;
    }
}