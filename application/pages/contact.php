<?php

$this->addSlot(new Contener_Slot_Inline_Text(array('name' => 'text', 'label' => 'Wartość tekstowa')));

$this->addSlot(new Contener_Slot_Inline_Text(array(
    'name' => 'long_text',
    'label' => 'Długi tekst',
    'length' => 'long',
    'use_wysiwyg' => true
)));