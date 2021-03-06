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
 * @package Projects And Tasks
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ProjectsRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

    /**
     * find Projects by Cat and Status
     * 
     * @param int $category Category UID
     * @param int $status status uid
     * @return object
     */
    public function findByProjectCatAndStatus($category, $status) {
        $query = $this->createQuery();

        $query->matching(
                $query->logicalAnd(array(
                    $query->equals('projectCat', $category),
                    $query->equals('projectStatus.statusBehaviour', $status)
                ))
        );

        return $query->execute();
    }
    
        /**
     * find Projects by Status
     * 
     * @param int $status status uid
     * @return object
     */
    public function findByProjectByStatus($status) {
        $query = $this->createQuery();

        $query->matching(
                    $query->equals('projectStatus.statusBehaviour', $status)
                
        );

        return $query->execute();
    }
    
            /**
     * find Projects by Status and owner
     * 
     * @param int $status status uid
     * @param int $owner 
             * 
     * @return object
     */
    public function findByProjectByStatusAndOwnser($status, $owner) {
        $query = $this->createQuery();

        $query->matching(
                $query->logicalAnd(array(
                    $query->equals('projectStatus.statusBehaviour', $status),
                    $query->equals('projectOwner', $owner)
                    ))
        );

        return $query->execute();
    }
}

?>