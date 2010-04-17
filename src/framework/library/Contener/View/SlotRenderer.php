<?php

abstract class Contener_View_SlotRenderer
{
    abstract function display($slot, $view, $rendererSchema);
}