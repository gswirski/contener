<?php

/**
 * Contener_Domain_Base_NodeType
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $title
 * @property clob $body
 * @property Doctrine_Collection $Nodes
 * @property Doctrine_Collection $Templates
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class Contener_Domain_Base_NodeType extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('node_type');
        $this->hasColumn('title', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('body', 'clob', null, array(
             'type' => 'clob',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Contener_Domain_Node as Nodes', array(
             'local' => 'id',
             'foreign' => 'node_type_id'));

        $this->hasMany('Contener_Domain_NodeTemplate as Templates', array(
             'local' => 'id',
             'foreign' => 'type_id'));
    }
}