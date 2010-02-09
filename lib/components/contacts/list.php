<?php

class components_contacts_List extends k_Component
{
    function renderHtml()
    {
        $this->document->setTitle('yeah!');
        $embedded = $this->createComponent('components_contacts_Embedded', '');
        try {
            $hmm = $embedded->renderHtml();
        } catch (Exception $e) {
            echo $e;
        }
        //return new k_NotImplemented;
        return 'I like this: ' . $hmm;
    }
    function dispatch()
    {
        return $this->execute();
    }
}