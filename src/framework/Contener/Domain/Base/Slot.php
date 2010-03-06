<?php

/**
 * Contener_Domain_Base_Slot
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $node_id
 * @property string $class
 * @property string $name
 * @property clob $body
 * @property Contener_Domain_Node $Node
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class Contener_Domain_Base_Slot extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('slot');
        $this->hasColumn('node_id', 'integer', 8, array(
             'type' => 'integer',
             'length' => '8',
             ));
        $this->hasColumn('class', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('name', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('body', 'clob', null, array(
             'type' => 'clob',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Contener_Domain_Node as Node', array(
             'local' => 'node_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $nestedset0 = new Doctrine_Template_NestedSet(array(
             'hasManyRoots' => true,
             'rootColumnName' => 'node_id',
             ));
        $this->actAs($nestedset0);
    }
}