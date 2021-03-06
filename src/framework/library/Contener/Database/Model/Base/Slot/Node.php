<?php

/**
 * Contener_Database_Model_Base_Slot_Node
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property Contener_Database_Model_Node $Node
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class Contener_Database_Model_Base_Slot_Node extends Contener_Database_Model_Slot
{
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('slot__node');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Contener_Database_Model_Node as Node', array(
             'local' => 'root_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}