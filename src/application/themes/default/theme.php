<?php

return array(
    'title' => 'Domyślny szablon',
    'author' => 'Grzegorz Świrski',
    'description' => 'Prosta skórka ułatwiająca przegląd możliwości systemu Contener CMS.',
    'slots' => array(
        //'logo' => new Contener_Slot_Inline_Image(array('label' => 'Logo')),
        'footer' => new Contener_Slot_Inline_Text(array('label' => 'Stopka')),
        'lorem' => new Contener_Slot_Inline_Text(array('label' => 'To kurna')),
        'ipsum' => new Contener_Slot_Inline_Text(array('label' => 'działa'))
    ),
    'templates' => array(
        'home' => array(
            'slots' => array()
        )
    )
);
