<?php

class Contener_Navigation_Container
    implements Contener_Navigation_Interface, RecursiveIterator, Countable
{
    protected $pages = array();
    protected $active = false;
    
    public function __construct($page = array())
    {
        if ($page instanceof Doctrine_Record) {
            $page = $page->toArray();
        }
        
        foreach ($page as $paramName => $paramValue) {
            if ($paramName == 'pages' or $paramName == '__children') {
                $this->addPages($page[$paramName]);
                continue;
            }
            
            $this->$paramName = $paramValue;
        }
    }
    
    function addPage($page)
    {
        if (is_array($page)) {
            if (array_key_exists('class', $page)) {
                $class = $page['class'];
                $page = new $class($page);
            } else if (array_key_exists('path', $page)) {
                $page = new Contener_Navigation_Node($page);
            } else {
                $page = new Contener_Navigation_Container($page);
            }
        }
        
        if (!$page instanceof Contener_Navigation_Interface) {
            throw new Exception('Invalid argument: $page must be an instance of ' .
            'Contener_Navigation_Interface or an array');
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
        return $this;
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
    
    
    function hasPage(Contener_Navigation_Interface $page, $recursive = false)
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
    
    public function findOneBy($property, $value)
    {
        $iterator = new RecursiveIteratorIterator($this,
                            RecursiveIteratorIterator::SELF_FIRST);

        foreach ($iterator as $page) {
            if (isset($page->$property) && $page->$property == $value) {
                return $page;
            }
        }

        return null;
    }
    
    public function findAllBy($property, $value)
    {
        $found = array();

        $iterator = new RecursiveIteratorIterator($this,
                            RecursiveIteratorIterator::SELF_FIRST);

        foreach ($iterator as $page) {
            if (isset($page->$property) && $page->$property == $value) {
                $found[] = $page;
            }
        }

        return $found;
    }
    
    public function findBy($property, $value, $all = false)
    {
        if ($all) {
            return $this->findAllBy($property, $value);
        } else {
            return $this->findOneBy($property, $value);
        }
    }
    
    public function setActive($value)
    {
        $this->active = $value;
    }
    
    public function isActive()
    {
        if ($this->active) {
            return array('page' => true, 'tree' => true);
        } else {
            foreach ($this->pages as $page) {
                $sub = $page->isActive();
                if ($sub['tree']) {
                    return array('page' => false, 'tree' => true);
                }
            }
        }
        return array('page' => false, 'tree' => false);
    }
}
