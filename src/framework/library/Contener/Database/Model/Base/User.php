<?php

/**
 * Contener_Database_Model_Base_User
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $login
 * @property string $password
 * @property string $name
 * @property string $email
 * @property string $language
 * @property boolean $use_wysiwyg
 * @property Doctrine_Collection $Nodes
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class Contener_Database_Model_Base_User extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('user');
        $this->hasColumn('login', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('password', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('name', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('email', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('language', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('use_wysiwyg', 'boolean', null, array(
             'type' => 'boolean',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Contener_Database_Model_Node as Nodes', array(
             'local' => 'id',
             'foreign' => 'author_id'));
    }
}