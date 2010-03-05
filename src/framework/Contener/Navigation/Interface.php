<?php

interface Contener_Navigation_Interface
{
    function addPage($page);
    function addPages(array $pages);
    function setPages($pages);
    function getPages();
    function removePage($page);
    function removePages();
    function hasPage(Contener_Navigation_Interface $page, $recursive = false);
    function hasPages();
    function addSubNavigation(Contener_Navigation_Interface $navigation);
    function findOneBy($property, $value);
    function findAllBy($property, $value);
    function findBy($property, $value, $all = false);
    function setActive($value);
    function isActive();
}