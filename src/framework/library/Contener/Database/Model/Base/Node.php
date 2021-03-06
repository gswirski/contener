<?php

/**
 * Contener_Database_Model_Base_Node
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $title
 * @property string $filtered_title
 * @property boolean $in_navigation
 * @property string $navigation
 * @property string $permalink
 * @property string $template
 * @property integer $publish_status
 * @property integer $author_id
 * @property string $class
 * @property Contener_Database_Model_User $Author
 * @property Doctrine_Collection $Slots
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class Contener_Database_Model_Base_Node extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('node');
        $this->hasColumn('title', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('filtered_title', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('in_navigation', 'boolean', null, array(
             'type' => 'boolean',
             ));
        $this->hasColumn('navigation', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('permalink', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('template', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('publish_status', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('author_id', 'integer', 8, array(
             'type' => 'integer',
             'length' => '8',
             ));
        $this->hasColumn('class', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));

        $this->setSubClasses(array(
             'Contener_Database_Model_Node_Page' => 
             array(
              'class' => 'Contener_Database_Model_Node_Page',
             ),
             'Contener_Database_Model_Node_Link' => 
             array(
              'class' => 'Contener_Database_Model_Node_Link',
             ),
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Contener_Database_Model_User as Author', array(
             'local' => 'author_id',
             'foreign' => 'id'));

        $this->hasMany('Contener_Database_Model_Slot_Node as Slots', array(
             'local' => 'id',
             'foreign' => 'root_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $nestedset0 = new Doctrine_Template_NestedSet();
        $this->actAs($timestampable0);
        $this->actAs($nestedset0);
    }
}