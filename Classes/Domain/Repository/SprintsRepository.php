<?php

namespace T3developer\ProjectsAndTasks\Domain\Repository;

/* * *************************************************************
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
 * ************************************************************* */

/**
 *
 *
 * @package Projects And Tasks
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class SprintsRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

        /**
     * find Sprint by Project and Status
     * 
     * @param $project int   
     * @param $status int 
     * 
     * @return object
     */
    public function findSprintsByProjectAndStatus($project, $status) {
        $query = $this->createQuery();

        $query->matching(
                $query->logicalAnd(array(
                    $query->equals('sprintProject', $project),
                    $query->equals('sprintStatus', $status)
                ))
        );

        return $query->execute();
    }
   
}

?>