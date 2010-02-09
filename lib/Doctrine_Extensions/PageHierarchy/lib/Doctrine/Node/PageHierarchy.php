<?php
/*
 *    $Id: NestedSet.php 5639 2009-04-11 09:19:37Z romanb $
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
 * Doctrine_Node_NestedSet
 *
 * @package    Doctrine
 * @subpackage Node
 * @license    http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link       www.phpdoctrine.org
 * @since      1.0
 * @version    $Revision: 5639 $
 * @author     Joe Simms <joe.simms@websites4.com>
 * @author     Roman Borschel <roman@code-factory.org>     
 */
class Doctrine_Node_PageHierarchy extends Doctrine_Node_NestedSet
{

    /**
     * inserts node as parent of dest record
     *
     * @return bool
     * @todo Wrap in transaction          
     */
    public function insertAsParentOf(Doctrine_Record $dest)
    {
        // cannot insert a node that has already has a place within the tree
        if ($this->isValidNode()) {
            return false;
        }
        // cannot insert as parent of root
        if ($dest->getNode()->isRoot()) {
            return false;
        }
        
        // cannot insert as parent of itself
        if (
		    $dest === $this->record ||
			($dest->exists() && $this->record->exists() && $dest->identifier() === $this->record->identifier())
		) {
            throw new Doctrine_Tree_Exception("Cannot insert node as parent of itself");

            return false;
        }

        $newLeft  = $dest->getNode()->getLeftValue();
        $newRight = $dest->getNode()->getRightValue() + 2;
        $newRoot  = $dest->getNode()->getRootValue();
		$newLevel = $dest->getNode()->getLevel();
		
		$pos = strrpos(rtrim($dest->node_path, '/'), '/');
		$childPath = substr($dest->node_path, 0, $pos+1);
		$childName = substr($dest->node_path, $pos);
		
		$replaceFrom = $dest->node_path;
		$replaceTo = $childPath . $this->getPrimaryColumnValue() . $childName;
		
		$newPath = $childPath . $this->getPrimaryColumnValue() . '/';
		
		$conn = $this->record->getTable()->getConnection();
		try {
		    $conn->beginInternalTransaction();
		    
		    // Make space for new node
            $this->shiftRLValues($dest->getNode()->getRightValue() + 1, 2, $newRoot);

            // Slide child nodes over one and down one to allow new parent to wrap them
    		$componentName = $this->_tree->getBaseComponent();		
            $q = new Doctrine_Query();
            $q->update($componentName);
            $q->set("$componentName.lft", "$componentName.lft + 1");
            $q->set("$componentName.rgt", "$componentName.rgt + 1");
            $q->set("$componentName.level", "$componentName.level + 1");
            $q->set('node_path', "REPLACE(`node_path`, '$replaceFrom', '$replaceTo')");
            $q->where("$componentName.lft >= ? AND $componentName.rgt <= ?", array($newLeft, $newRight));
    		$q = $this->_tree->returnQueryWithRootId($q, $newRoot);
    		$q->execute();

            $this->record['level'] = $newLevel;
    		$this->insertNode($newLeft, $newRight, $newPath, $newRoot);
    		
    		$conn->commit();
		} catch (Exception $e) {
		    $conn->rollback();
		    throw $e;
		}
        
        return true;
    }

    /**
     * inserts node as previous sibling of dest record
     *
     * @return bool
     * @todo Wrap in transaction  
     */
    public function insertAsPrevSiblingOf(Doctrine_Record $dest)
    {	
        // cannot insert a node that has already has a place within the tree
        if ($this->isValidNode()) {
            return false;
        }
        // cannot insert as sibling of itself
        if (
		    $dest === $this->record ||
			($dest->exists() && $this->record->exists() && $dest->identifier() === $this->record->identifier())
		) {
            throw new Doctrine_Tree_Exception("Cannot insert node as previous sibling of itself");

            return false;
        }

        $newLeft = $dest->getNode()->getLeftValue();
        $newRight = $dest->getNode()->getLeftValue() + 1;
        $newRoot = $dest->getNode()->getRootValue();
        
        $newPath = substr($dest->node_path, 0, $pos+1) . $this->getPrimaryColumnValue() . '/';
        
        $conn = $this->record->getTable()->getConnection();
        try {
            $conn->beginInternalTransaction();
            
            $this->shiftRLValues($newLeft, 2, $newRoot);
            $this->record['level'] = $dest['level'];
            $this->insertNode($newLeft, $newRight, $newRoot);
            // update destination left/right values to prevent a refresh
            // $dest->getNode()->setLeftValue($dest->getNode()->getLeftValue() + 2);
            // $dest->getNode()->setRightValue($dest->getNode()->getRightValue() + 2);
            
            $conn->commit();
        } catch (Exception $e) {
            $conn->rollback();
            throw $e;
        }
                        
        return true;
    }

    /**
     * inserts node as next sibling of dest record
     *
     * @return bool
     * @todo Wrap in transaction           
     */    
    public function insertAsNextSiblingOf(Doctrine_Record $dest)
    {   
        // cannot insert a node that has already has a place within the tree
        if ($this->isValidNode()) {
            return false;
        }
        // cannot insert as sibling of itself
        if (
		    $dest === $this->record ||
			($dest->exists() && $this->record->exists() && $dest->identifier() === $this->record->identifier())
		) {
            throw new Doctrine_Tree_Exception("Cannot insert node as next sibling of itself");

            return false;
        }

        $newLeft = $dest->getNode()->getRightValue() + 1;
        $newRight = $dest->getNode()->getRightValue() + 2;
        $newRoot = $dest->getNode()->getRootValue();
        
        $newPath = substr($dest->node_path, 0, $pos+1) . $this->getPrimaryColumnValue() . '/';

        $conn = $this->record->getTable()->getConnection();
        try {
            $conn->beginInternalTransaction();
            
            $this->shiftRLValues($newLeft, 2, $newRoot);
            $this->record['level'] = $dest['level'];
            $this->insertNode($newLeft, $newRight, $newRoot);
            // update destination left/right values to prevent a refresh
            // no need, node not affected
            
            $conn->commit();
        } catch (Exception $e) {
            $conn->rollback();
            throw $e;
        }

        return true;
    }

    /**
     * inserts node as first child of dest record
     *
     * @return bool
     * @todo Wrap in transaction         
     */
    public function insertAsFirstChildOf(Doctrine_Record $dest)
    {
        // cannot insert a node that has already has a place within the tree
        if ($this->isValidNode()) {
            return false;
        }
        // cannot insert as child of itself
        if (
		    $dest === $this->record ||
			($dest->exists() && $this->record->exists() && $dest->identifier() === $this->record->identifier())
		) {
            throw new Doctrine_Tree_Exception("Cannot insert node as first child of itself");

            return false;
        }

        $newLeft = $dest->getNode()->getLeftValue() + 1;
        $newRight = $dest->getNode()->getLeftValue() + 2;
        $newRoot = $dest->getNode()->getRootValue();
        
        $newPath = $dest->get('path') . $this->getPrimaryColumnValue() . '/';

        $conn = $this->record->getTable()->getConnection();
        try {
            $conn->beginInternalTransaction();
            
            $this->shiftRLValues($newLeft, 2, $newRoot);
            $this->record['level'] = $dest['level'] + 1;
            $this->insertNode($newLeft, $newRight, $newPath, $newRoot);
            
            // update destination left/right values to prevent a refresh
            // $dest->getNode()->setRightValue($dest->getNode()->getRightValue() + 2);
            
            $conn->commit();
        } catch (Exception $e) {
            $conn->rollback();
            throw $e;
        }

        return true;
    }

    /**
     * inserts node as last child of dest record
     *
     * @return bool
     * @todo Wrap in transaction            
     */
    public function insertAsLastChildOf(Doctrine_Record $dest)
    {
        // cannot insert a node that has already has a place within the tree
        if ($this->isValidNode()) {
            return false;
        }
        
        // cannot insert as child of itself
        if (
		    $dest === $this->record ||
			($dest->exists() && $this->record->exists() && $dest->identifier() === $this->record->identifier())
		) {
            throw new Doctrine_Tree_Exception("Cannot insert node as last child of itself");

            return false;
        }
        
        $newLeft = $dest->getNode()->getRightValue();
        $newRight = $dest->getNode()->getRightValue() + 1;
        $newRoot = $dest->getNode()->getRootValue();
        
        $destOldPath = $dest->get('path');
        $primaryValue = $this->getPrimaryColumnValue();
        $newPath = $destOldPath . $primaryValue . '/';

        $conn = $this->record->getTable()->getConnection();
        try {
            $conn->beginInternalTransaction();
            
            $this->shiftRLValues($newLeft, 2, $newRoot);
            $this->record['level'] = $dest['level'] + 1;
            $this->insertNode($newLeft, $newRight, $newPath, $newRoot);

            // update destination left/right values to prevent a refresh
            // $dest->getNode()->setRightValue($dest->getNode()->getRightValue() + 2);
            
            $conn->commit();
        } catch (Exception $e) {
            $conn->rollback();
            throw $e;
        }
        
        return true;
    }

    /**
     * Accomplishes moving of nodes between different trees.
     * Used by the move* methods if the root values of the two nodes are different.
     *
     * @param Doctrine_Record $dest
     * @param unknown_type $newLeftValue
     * @param unknown_type $moveType
     * @todo Better exception handling/wrapping
     */
    protected function _moveBetweenTrees(Doctrine_Record $dest, $newLeftValue, $moveType)
    {
        $conn = $this->record->getTable()->getConnection();
            
        try {
            $conn->beginInternalTransaction();

            // Move between trees: Detach from old tree & insert into new tree
            $newRoot = $dest->getNode()->getRootValue();
            $oldRoot = $this->getRootValue();
            $oldLft = $this->getLeftValue();
            $oldRgt = $this->getRightValue();
            $oldLevel = $this->record['level'];

            // Prepare target tree for insertion, make room
            $this->shiftRlValues($newLeftValue, $oldRgt - $oldLft - 1, $newRoot);

            // Set new root id for this node
            $this->setRootValue($newRoot);
            $this->record->save();

            // Close gap in old tree
            $first = $oldRgt + 1;
            $delta = $oldLft - $oldRgt - 1;
            $this->shiftRLValues($first, $delta, $oldRoot);

            // Insert this node as a new node
            $this->setRightValue(0);
            $this->setLeftValue(0);

            switch ($moveType) {
                case 'moveAsPrevSiblingOf':
                    $this->insertAsPrevSiblingOf($dest);
                break;
                case 'moveAsFirstChildOf':
                    $this->insertAsFirstChildOf($dest);
                break;
                case 'moveAsNextSiblingOf':
                    $this->insertAsNextSiblingOf($dest);
                break;
                case 'moveAsLastChildOf':
                    $this->insertAsLastChildOf($dest);
                break;
                default:
                    throw new Exception("Unknown move operation: $moveType.");
            }

            $diff = $oldRgt - $oldLft;
            $this->setRightValue($this->getLeftValue() + ($oldRgt - $oldLft));
            $this->record->save();

            $newLevel = $this->record['level'];
            $levelDiff = $newLevel - $oldLevel;

            // Relocate descendants of the node
            $diff = $this->getLeftValue() - $oldLft;
            $componentName = $this->_tree->getBaseComponent();
            $rootColName = $this->_tree->getAttribute('rootColumnName');

            // Update lft/rgt/root/level for all descendants
            $q = new Doctrine_Query($conn);
            $q = $q->update($componentName)
                    ->set($componentName . '.lft', $componentName.'.lft + ?', $diff)
                    ->set($componentName . '.rgt', $componentName.'.rgt + ?', $diff)
                    ->set($componentName . '.level', $componentName.'.level + ?', $levelDiff)
                    ->set($componentName . '.' . $rootColName, '?', $newRoot)
                    ->where($componentName . '.lft > ? AND ' . $componentName . '.rgt < ?',
                    array($oldLft, $oldRgt));
            $q = $this->_tree->returnQueryWithRootId($q, $oldRoot);
            $q->execute();

            $conn->commit();
     
	        return true;
        } catch (Exception $e) {
            $conn->rollback();
            throw $e;
        }
        
        return false;
    }

    /**
     * moves node as prev sibling of dest record
     * 
     */     
    public function moveAsPrevSiblingOf(Doctrine_Record $dest)
    {
    	$componentName = $this->_tree->getBaseComponent();
    	
    	$path = $this->getPathValue();
    	$replaceFrom = substr($path, 0, strrpos(rtrim($path, '/'), '/')+1);
    	$replaceTo = substr($dest->path, 0, strrpos(rtrim($dest->path, '/'), '/')+1);
    	
    	$replacePath = "REPLACE(`$componentName`.`path`, '$replaceFrom', '$replaceTo')";
    	$newPath = $replaceTo . $this->getPrimaryColumnValue() . '/';
    	
        if (
		    $dest === $this->record ||
			($dest->exists() && $this->record->exists() && $dest->identifier() === $this->record->identifier())
		) {
            throw new Doctrine_Tree_Exception("Cannot move node as previous sibling of itself");

			return false;
		}

        if ($dest->getNode()->getRootValue() != $this->getRootValue()) {
            // Move between trees
            return $this->_moveBetweenTrees($dest, $dest->getNode()->getLeftValue(), __FUNCTION__);
        } else {
            // Move within the tree
            $oldLevel = $this->record['level'];
            $this->record['level'] = $dest['level'];
            $this->updateNode($dest->getNode()->getLeftValue(), $this->record['level'] - $oldLevel, $newPath, $replacePath);
        }
        
        return true;
    }

    /**
     * moves node as next sibling of dest record
     *        
     */
    public function moveAsNextSiblingOf(Doctrine_Record $dest)
    {
    	$componentName = $this->_tree->getBaseComponent();
    	
    	$path = $this->getPathValue();
    	$replaceFrom = substr($path, 0, strrpos(rtrim($path, '/'), '/')+1);
    	$replaceTo = substr($dest->path, 0, strrpos(rtrim($dest->path, '/'), '/')+1);
    	
    	$replacePath = "REPLACE(`$componentName`.`path`, '$replaceFrom', '$replaceTo')";
    	$newPath = $replaceTo . $this->getPrimaryColumnValue() . '/';
    	
        if (
		    $dest === $this->record ||
			($dest->exists() && $this->record->exists() && $dest->identifier() === $this->record->identifier())
		) {
            throw new Doctrine_Tree_Exception("Cannot move node as next sibling of itself");
            
            return false;
        }

        if ($dest->getNode()->getRootValue() != $this->getRootValue()) {
            // Move between trees
            return $this->_moveBetweenTrees($dest, $dest->getNode()->getRightValue() + 1, __FUNCTION__);
        } else {
            // Move within tree
            $oldLevel = $this->record['level'];
            $this->record['level'] = $dest['level'];
            $this->updateNode($dest->getNode()->getRightValue() + 1, $this->record['level'] - $oldLevel, $newPath, $replacePath);
        }
        
        return true;
    }

    /**
     * moves node as first child of dest record
     *            
     */
    public function moveAsFirstChildOf(Doctrine_Record $dest)
    {
    	$componentName = $this->_tree->getBaseComponent();

    	$newPath = $dest->path . $this->getPrimaryColumnValue() . '/';
    	
    	$replaceFrom = $this->getPathValue();
    	$replaceTo = $dest->path . $this->getPrimaryColumnValue() . '/';
    	$replacePath = "REPLACE(`$componentName`.`path`, '$replaceFrom', '$replaceTo')";
    	    	
        if (
		    $dest === $this->record ||
			($dest->exists() && $this->record->exists() && $dest->identifier() === $this->record->identifier())
		) {
            throw new Doctrine_Tree_Exception("Cannot move node as first child of itself");

			return false;
		}

		if ($dest->getNode()->getRootValue() != $this->getRootValue()) {
            // Move between trees
            return $this->_moveBetweenTrees($dest, $dest->getNode()->getLeftValue() + 1, __FUNCTION__);
        } else {
            // Move within tree
            $oldLevel = $this->record['level'];
            $this->record['level'] = $dest['level'] + 1;
            $this->updateNode($dest->getNode()->getLeftValue() + 1, $this->record['level'] - $oldLevel, $newPath, $replacePath);
        }

        return true;
    }

    /**
     * moves node as last child of dest record
     *        
     */
    public function moveAsLastChildOf(Doctrine_Record $dest)
    {
    	$componentName = $this->_tree->getBaseComponent();

    	$newPath = $dest->path . $this->getPrimaryColumnValue() . '/';
    	
    	$replaceFrom = $this->getPathValue();
    	$replaceTo = $dest->path . $this->getPrimaryColumnValue() . '/';
    	$replacePath = "REPLACE(`$componentName`.`path`, '$replaceFrom', '$replaceTo')";
    	
        if (
		    $dest === $this->record ||
			($dest->exists() && $this->record->exists() && $dest->identifier() === $this->record->identifier())
		) {
            throw new Doctrine_Tree_Exception("Cannot move node as last child of itself");

			return false;
		}

        if ($dest->getNode()->getRootValue() != $this->getRootValue()) {
            // Move between trees
            return $this->_moveBetweenTrees($dest, $dest->getNode()->getRightValue(), __FUNCTION__);
        } else {
            // Move within tree
            $oldLevel = $this->record['level'];
            $this->record['level'] = $dest['level'] + 1;
            $this->updateNode($dest->getNode()->getRightValue(), $this->record['level'] - $oldLevel, $newPath, $replacePath);
        }
        
        return true;
    }

    /**
     * Makes this node a root node. Only used in multiple-root trees.
     *
     * @todo Exception handling/wrapping
     */
    public function makeRoot($newRootId)
    {
        // TODO: throw exception instead?
        if ($this->getLeftValue() == 1 || ! $this->_tree->getAttribute('hasManyRoots')) {
            return false;
        }
        
        $oldRgt = $this->getRightValue();
        $oldLft = $this->getLeftValue();
        $oldRoot = $this->getRootValue();
        $oldLevel = $this->record['level'];
        
        $oldPath = $this->getPathValue();
        
        $conn = $this->record->getTable()->getConnection();
        try {
            $conn->beginInternalTransaction();
            
            // Update descendants lft/rgt/root/level values
            $diff = 1 - $oldLft;
            $newRoot = $newRootId;
            $componentName = $this->_tree->getBaseComponent();
            $rootColName = $this->_tree->getAttribute('rootColumnName');
            $q = new Doctrine_Query($conn);
            $q = $q->update($componentName)
                    ->set($componentName . '.lft', $componentName.'.lft + ?', $diff)
                    ->set($componentName . '.rgt', $componentName.'.rgt + ?', $diff)
                    ->set($componentName . '.level', $componentName.'.level - ?', $oldLevel)
                    ->set($componentName . '.path', "REPLACE($componentName.path, '$oldPath', '/'")
                    ->set($componentName . '.' . $rootColName, '?', $newRoot)
                    ->where($componentName . '.lft > ? AND ' . $componentName . '.rgt < ?',
                    array($oldLft, $oldRgt));
            $q = $this->_tree->returnQueryWithRootId($q, $oldRoot);
            $q->execute();
            
            // Detach from old tree (close gap in old tree)
            $first = $oldRgt + 1;
            $delta = $oldLft - $oldRgt - 1;
            $this->shiftRLValues($first, $delta, $this->getRootValue());
            
            // Set new lft/rgt/root/level values for root node
            $this->setLeftValue(1);
            $this->setRightValue($oldRgt - $oldLft + 1);
            $this->setPathValue('/');
            $this->setRootValue($newRootId);
            $this->record['level'] = 0;
            
            $this->record->save();
            
            $conn->commit();
            
            return true;
        } catch (Exception $e) {
            $conn->rollback();
            throw $e;
        }
        
        return false;
    }

    /**
     * sets node's left and right values and save's it
     *
     * @param int     $destLeft     node left value
     * @param int        $destRight    node right value
     */    
    protected function insertNode($destLeft = 0, $destRight = 0, $destPath = '', $destRoot = 1)
    {
    	$this->setPathValue($destPath);
    	
        parent::insertNode($destLeft, $destRight, $destRoot);    
    }

    /**
     * move node's and its children to location $destLeft and updates rest of tree
     *
     * @param int     $destLeft    destination left value
     * @todo Wrap in transaction
     */
    protected function updateNode($destLeft, $levelDiff, $destPath = '', $replacePath = '')
    { 
        $componentName = $this->_tree->getBaseComponent();
        $left = $this->getLeftValue();
        $right = $this->getRightValue();
        $rootId = $this->getRootValue();

        $treeSize = $right - $left + 1;

        $conn = $this->record->getTable()->getConnection();
        try {
            $conn->beginInternalTransaction();
            
            // Make room in the new branch
            $this->shiftRLValues($destLeft, $treeSize, $rootId);

            if ($left >= $destLeft) { // src was shifted too?
                $left += $treeSize;
                $right += $treeSize;
            }

            // update level for descendants
            $q = new Doctrine_Query();
            $q = $q->update($componentName)
                    ->set($componentName . '.level', $componentName.'.level + ?')
                    ->where($componentName . '.lft > ? AND ' . $componentName . '.rgt < ?',
                            array($levelDiff, $left, $right));
            
            if ($replacePath) {
            	$q->set("$componentName.path", $replacePath);
            }
                            
            $q = $this->_tree->returnQueryWithRootId($q, $rootId);
            $q->execute();

            // now there's enough room next to target to move the subtree
            $this->shiftRLRange($left, $right, $destLeft - $left, $rootId);

            // correct values after source (close gap in old tree)
            $this->shiftRLValues($right + 1, -$treeSize, $rootId);
			
            $this->record->path = $destPath;
            
            $this->record->save();
            $this->record->refresh();
            
            $conn->commit();
        } catch (Exception $e) {
            $conn->rollback();
            throw $e;
        }
        
        return true;
    }
	
    /**
     * gets record's path value
     *
     * @return string            
     */
    public function getPathValue()
    {
    	return $this->record->get('path');
    }
    
    /**
     * sets record's path value
     *
     * @param string            
     */  
    public function setPathValue($path)
    {
    	$this->record->set('path', $path);
    }
    
    public function getPrimaryColumnValue()
    {
    	return $this->record->get($this->_tree->getAttribute('primaryColumn'));
    }
}