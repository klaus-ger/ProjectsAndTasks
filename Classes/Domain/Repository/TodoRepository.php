<?php
namespace T3developer\ProjectsAndTasks\Domain\Repository;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Klaus Heuer | t3-developer.com
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package T3 Contact
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class TodoRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

  //  protected $defaultOrderings = array('swCommentDate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
   
    /**
     * Find todos by list and status
     * 
     * @param $list $status
     * @return Tx_ProjectsAndTasks_Domain_Model_todo
     */
    public function findByListAndStatus( $list, $status) {
        $query = $this->createQuery();
        
        $query->matching(
        $query->logicalAnd(
            $query->equals('todoList', $list),
            $query->lessThan('todoStatus', $status)
            )
        );
        return $query->execute();
   }	   
    
    /**
     * Count all Todos per List
     * 
     * @param $list 
     * @return Tx_ProjectsAndTasks_Domain_Model_todo
     */
    public function countAllPerList( $list) {
        $query = $this->createQuery();
        
        $query->matching(
            $query->equals('todoList', $list)
        );
        return $query->execute()->count();
   }	   
   
       /**
     * Count all Todos per List
     * 
     * @param $list 
     * @return Tx_ProjectsAndTasks_Domain_Model_todo
     */
    public function countOpenPerList( $list) {
        $query = $this->createQuery();
        
        $query->matching(
        $query->logicalAnd(
            $query->equals('todoList', $list),
            $query->lessThan('todoStatus', '6')
            )
        );
        return $query->execute()->count();
   }	
   
   	/**
	 * Returns the next todoNumber
	 * @return number
	 */
	public function getNextNumber($list) {
		$query = $this->createQuery();
                $query ->setOrderings(array(
			'todoNr' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
		));
                $query->matching(
                    $query->equals('todoList', $list)
                );
                $last = $query->setLimit(1)->execute();
                
		if ($last[0] != null) {
			$number = $last[0]->getTodoNr();
				return $number + 1;
		}
		return "1";
	}
        
        
   
    /**
     * Find ToDos By User and Status
     * Needed for the Inbox View
     * 
     * @param $user $status
     * @return Tx_ProjectsAndTasks_Domain_Model_Project
     */
    public function findByUserAndStatus($user, $status) {
        $query = $this->createQuery();
        
        $query->matching(
                $query->logicalAnd(
                    $query->equals('todoAssigned',$user),
                    $query->equals('todoStatus',$status)
                     )
        );
        return $query->execute();
    } 
//    
//        /**
//     * Find own Projects
//     * 
//     * @param $owner
//     * @return Tx_ProjectsAndTasks_Domain_Model_Project
//     */
//    public function findByOwner( $owner) {
//        $query = $this->createQuery();
//        
//        $query->matching(
//                    $query->equals('projectOwner', $owner)
//        );
//        return $query->execute();
//    } 


//
//    /**
//     * Find plans by parent and pid
//     * 
//     * @param $parent $storagePid
//     * @return Tx_ProjectsAndTasks_Domain_Model_Plan
//     */
//    public function findByParentAndPid( $parent, $storagePid) {
//        $query = $this->createQuery();
//        $query->getQuerySettings()->setRespectStoragePage(FALSE);
//        $query->matching(
//        $query->logicalAnd(
//            $query->equals('planParent', $parent),
//            $query->equals('pid', $storagePid)
//            )
//        );
//        return $query->execute();
//    }
    
}

?>