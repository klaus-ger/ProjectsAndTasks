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
class BoardmessageRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

    //protected $defaultOrderings = array('cyShort' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);

    
       /**
     * find Messages by Topic
     * 
     * @param int $topicUid 
     * @return object
     */
    public function countByTopic($topicUid) {
        $query = $this->createQuery();

        $query->matching(
                $query->equals('bmTopic', $topicUid)
                
        );

        return $query->execute()->count();
    }
    
     /**
     * Find last Message by Topic
     * 
     * @param int $topicUid
     */
    public function findLastMessageByTopic($topicUid ){
        $orderings = array('bmDate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING);
        $query = $this->createQuery();
        $query->setOrderings($orderings);
        $query->setLimit(1);
                
		$query->matching(
			$query->equals('bmTopic', $topicUid)
                           
		);

		return $query->execute();
    }
}

?>