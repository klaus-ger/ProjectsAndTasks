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
class ProjectRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

  //  protected $defaultOrderings = array('swCommentDate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
	   
    
    /**
     * Find openProjects
     * 
     * @param $status
     * @return Tx_ProjectsAndTasks_Domain_Model_Project
     */
    public function findByProjectsByStatus( $status) {
        $query = $this->createQuery();
        
        $query->matching(
                    $query->equals('status','0')
        );
        return $query->execute();
    } 
    
        /**
     * Find own Projects
     * 
     * @param $owner
     * @return Tx_ProjectsAndTasks_Domain_Model_Project
     */
    public function findByOwner( $owner) {
        $query = $this->createQuery();
        
        $query->matching(
                    $query->equals('projectOwner', $owner)
        );
        return $query->execute();
    } 

//    /**
//     * Find plans by uid and pid
//     * 
//     * @param $storagePid
//     * @return Tx_ProjectsAndTasks_Domain_Model_Plan
//     */
//    public function findByUidAndPid( $uid, $storagePid) {
//        $query = $this->createQuery();
//        $query->getQuerySettings()->setRespectStoragePage(FALSE);
//        $query->matching(
//        $query->logicalAnd(
//            $query->equals('uid', $uid),
//            $query->equals('pid', $storagePid)
//            )
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