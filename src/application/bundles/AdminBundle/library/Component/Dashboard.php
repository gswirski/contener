<?php

class AdminBundle_Component_Dashboard extends Contener_Component
{
    function dispatch()
    {   
        $dashboard = new Contener_Navigation(array(
            array(
                'title' => 'Dashboard',
                'path' => '/admin'
            ),
            array(
                'title' => 'Dodaj stronę',
                'path' => '/admin/node?add'
            )
        ));
        
        $data = Doctrine_Query::create()
            ->select()
            ->from('Contener_Domain_Node p')
            ->where('p.level != ?', 0)
            ->orderBy('p.lft')
            ->execute(array(), Doctrine_Core::HYDRATE_RECORD_HIERARCHY);
        $pages = new Contener_Navigation($data);
        
        
        
        $mainNode = $this->context->area('menu')->findOneBy('path', '/admin');
        $mainNode->addPage($dashboard);
        $mainNode->addPage($pages);
        
        $this->context->area('left')->addModule('Dashboard', $dashboard);
        $this->context->area('left')->addModule('Zarządzaj stronami', $pages);
        
        return parent::execute();
    }
    
    function renderHtml()
    {
        return '<h2>Dashboard</h2>
        <p>Kiedyś na pewno będę miał więcej do napisania.</p>
        <p>To powinno być całkiem wygodne miejsce do zarządzania głównymi wersjami (branching), logowaniem zdarzeń, statystykami, notatkami, ulubionymi skrótami i czego tylko dusza zapragnie.</p>
        
        <h2>Release Notes</h2>
        <h3>Build 2.0 - under development</h3>
        <ul style="list-style-type: disc; margin: 0px 23px 15px 23px; font-size: 11px; line-height: 16px;">
            <li>Zupełnie nowe międzymordzie</li>
        </ul>
        
        <h3>Build 1.8</h3>
        <ul style="list-style-type: disc; margin: 0px 23px 15px 23px; font-size: 11px; line-height: 16px;">
            <li style="color: red">Przemieszczanie stron w obrębie całego drzewa</li>
            <li style="color: red">Utrwalanie pozycji strony w drzewie</li>
            <li style="color: red">Uzupełnienie podstawowych typów slotów (plik, obrazek, lista rozwijalna...)</li>
        </ul>
        
        <h3>Build 1.7</h3>
        <ul style="list-style-type: disc; margin: 0px 23px 15px 23px; font-size: 11px; line-height: 16px;">
            <li>Nowy model tworzenia stron</li>
            <li>Usuwanie stron</li>
            <li>Poprawki w zachowaniu przycisku "dodaj stronę" - ukrywanie po klinięciu poza obrębem panelu</li>
            <li>Root w tabeli slots jako nazwa szablonu strony</li>
            <li>Obsługa slotów typu container</li>
        </ul>
        
        <h3>Build 1.6</h3>
        <ul style="list-style-type: disc; margin: 0px 23px 15px 23px; font-size: 11px; line-height: 16px;">
            <li>Silnik obsługi modułów strony (slotów) wraz z najprostszym polem tekstowym</li>
            <li>Podstawowe opcje edycji: zmiana tytułu, bezpośredniego odnośnika, tekstu modułów na stronie</li>
            <li>Połączenie edytora z bazą danych: formularz, utrwalanie wprowadzonych danych</li>
            <li>Sprawdzanie poprawności danych w formularzu</li>
            <li>Dostosowywanie edytora do typu strony</li>
            <li>Zalążek panelu konfiguracji</li>
            <li>Drobne poprawki interfejsu</li>
        </ul>
        
        <h3>Build 1.5</h3>
        <ul style="list-style-type: disc; margin: 0px 23px 15px 23px; font-size: 11px; line-height: 16px;">
            <li>Nowy system zarządzania drzewem stron - oznaczanie aktualnie otwartych</li>
            <li>Likwidacja zakładki "strony" na rzecz Dashboardu jako punktu startowego do ich edycji. W przyszłości może powróci jako zbiór szybkich linków</li>
            <li>Odświeżony panel tworzenia nowych działów serwisu</li>
            <li>Przemieszczanie stron w drzewie dokumentów na jednym poziomie</li>
            <li>Zalążek panelu publikacji</li>
        </ul>';
    }
}
