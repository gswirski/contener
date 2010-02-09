<?php
/*
 *  $Id: NestedSet.php 5558 2009-02-27 04:02:18Z guilhermeblanco $
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://www.phpdoctrine.org>.
 */

/**
 * Doctrine_Tree_NestedSet
 *
 * @package     Doctrine
 * @subpackage  Tree
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link        www.phpdoctrine.org
 * @since       1.0
 * @version     $Revision: 5558 $
 * @author      Joe Simms <joe.simms@websites4.com>
 * @author      Roman Borschel <roman@code-factory.org>
 */
class Doctrine_Tree_PageHierarchy extends Doctrine_Tree_NestedSet
{
    private $_baseQuery;
    private $_baseAlias = "base";

    /**
     * constructor, creates tree with reference to table and sets default root options
     *
     * @param object $table                     instance of Doctrine_Table
     * @param array $options                    options
     */
    public function __construct(Doctrine_Table $table, $options)
    {
        $options['pathColumn'] = isset($options['pathColumn']) ? $options['pathColumn'] : 'id';
        
        parent::__construct($table, $options);
    }

    /**
     * used to define table attributes required for the NestetSet implementation
     * adds lft and rgt columns for corresponding left and right values
     *
     */
    public function setTableDefinition()
    {	
    	$this->table->setColumn('path', 'string', 255);
    	
        parent::setTableDefinition();
    }

    /**
     * Creates root node from given record or from a new record.
     *
     * Note: When using a tree with multiple root nodes (hasManyRoots), you MUST pass in a
     * record to use as the root. This can either be a new/transient record that already has
     * the root id column set to some numeric value OR a persistent record. In the latter case
     * the records id will be assigned to the root id. You must use numeric columns for the id
     * and root id columns.
     *
     * @param object $record        instance of Doctrine_Record
     */
    public function createRoot(Doctrine_Record $record = null)
    {	
    	$record->set('path', '/');
    	
        return parent::createRoot($record);
    }
}