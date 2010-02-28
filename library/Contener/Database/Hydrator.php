<?php

class Contener_Database_Hydrator extends Doctrine_Hydrator_RecordDriver
{
    public function hydrateResultSet($stmt)
    {
        $data = parent::hydrateResultSet($stmt);
        
        foreach ($data as $node) {
            foreach ($node->getReferences() as $reference) {
                if ($reference instanceof Doctrine_Collection) {
                    $reference->toHierarchy();
                }
            }
        }
        
        return $data->toHierarchy();
    }
}
