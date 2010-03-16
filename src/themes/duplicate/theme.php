<?php

return array(
    'title' => 'Duplikat',
    'author' => 'Grzegorz Świrski',
    'description' => 'W końcu na czymś trzeba testować',
    'slots' => array(
        //'logo' => new Contener_Slot_Inline_Image(array('label' => 'Logo')),
        'footer' => new Contener_Slot_Inline_Text(array('label' => 'Stopka')),
    ),
    'templates' => array(
        'home' => array(
            'slots' => array()
        )
    )
);
