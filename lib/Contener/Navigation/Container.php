<?php

abstract class Contener_Navigation_Container
    implements RecursiveIterator, Countable
{
    protected $pages = array();
    
    function addPage($page)
    {
        if (is_array($page)) {
            $page = new Contener_Navigation_Node($page);
        }
        
        if (!$page instanceof Contener_Navigation_Container) {
            throw new Exception('Invalid argument: $page must be an instance of ' .
            'Contener_Navigation_Node or an array');
        }
        
        $hash = spl_object_hash($page);
        
        if (array_key_exists($hash, $this->pages)) {
            return $this;
        }
        
        $this->pages[$hash] = $page;
        
        return $this;
    }
    
    function addPages(array $pages)
    {
        foreach ($pages as $page) {
            $this->addPage($page);
        }
    }
    
    function setPages($pages)
    {
        $this->removePages();
        $this->addPages($pages);
        
        return $this;
    }
    
    function getPages()
    {
        return $this->pages;
    }
    
    function removePage($page) {
        if ($page instanceof Contener_Navigation_Node) {
            $page = spl_object_hash($page);
        }
        
        unset($this->pages[$page]);
        
        return $this;
    }
    
    function removePages()
    {
        $this->pages = array();
    }
    
    
    function hasPage(Contener_Navigation_Container $page, $recursive = false)
    {
        if (array_key_exists(spl_object_hash($page), $this->pages)) {
            return true;
        } elseif ($recursive) {
            foreach ($this->pages as $childPage) {
                if ($childPage->hasPage($page, true)) {
                    return true;
                }
            }
        }

        return false;
    }

    function hasPages()
    {
        return count($this->pages) > 0;
    }
    
    function current()
    {
        return current($this->pages);
    }

    function key()
    {
        return key($this->pages);
    }

    function next()
    {
        next($this->pages);
    }

    function rewind()
    {
        reset($this->pages);
    }

    function valid()
    {
        return current($this->pages) !== false;
    }

    function hasChildren()
    {
        return $this->hasPages();
    }

    function getChildren()
    {
        $hash = key($this->pages);
        return $this->pages[$hash];
    }
    
    public function count()
    {
        return count($this->pages);
    }
}