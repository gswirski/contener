<?php

class Contener_Component extends k_Component 
{   
    public function __toString()
    {
        return (string) $this->renderHtml();
    }
    
    // @todo: okej, I know this sucks
    public function config($path = null, $default = null)
    {
        $search = $GLOBALS['config'];
        if ($path) {
            $parts = explode('.', $path);
            
            foreach ($parts as $part) {
                if (array_key_exists($part, $search)) {
                    $search = $search[$part];
                } else {
                    return $default;
                }
            }
        }
        
        return $search;
    }
    
    // @todo: this one sucks too
    public function baseUrl()
    {
        return $GLOBALS['baseUrl'];
    }
    
    public function path()
    {
        return rtrim(str_replace($GLOBALS['baseUrl'], '', $this->requestUri()), '/');
    }
}
