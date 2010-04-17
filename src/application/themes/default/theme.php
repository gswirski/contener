<?php

return array(
    'title' => 'Domyślny szablon',
    'author' => 'Grzegorz Świrski',
    'description' => 'Prosta skórka ułatwiająca przegląd możliwości systemu Contener CMS.',
    'slots' => array(
        array(
            'class' => 'Contener_Slot_Inline_Text',
            'name' => 'footer',
            'label' => 'stopka'
        ),
        array(
            'class' => 'Contener_Slot_Inline_Text',
            'name' => 'lorem',
            'label' => 'To kurna'
        ),
        array(
            'class' => 'Contener_Slot_Inline_Text',
            'name' => 'ipsum',
            'label' => 'Działa'
        )
    ),
    'templates' => array(
        'homepage' => array(
            'title' => 'Strona główna',
            'is_open' => false,
            'slots' => array(
                array(
                    'class' => 'Contener_Slot_Inline_Text',
                    'name' => 'default',
                    'label' => 'Test działania',
                    'defaults' => array('value' => 'Wartość domyślna')
                ),
                array(
                    'class' => 'Contener_Slot_Inline_Photo',
                    'name' => 'photo',
                    'label' => 'Zdjęcie nagłówkowe'
                ),
                array(
                    'class' => 'Contener_Slot_Inline_Text',
                    'name' => 'text',
                    'label' => 'Pole tekstowe',
                    'length' => 'long'
                )
            )
        ),
        'contact' => array(
            'title' => 'Kontakt',
            'is_open' => false,
            'slots' => array(
                array(
                    'class' => 'Contener_Slot_Inline_Text',
                    'name' => 'mail',
                    'label' => 'Adres e-mail',
                    'defaults' => array('value' => 'adres@email.pl')
                )
            )
        )
    )
);
