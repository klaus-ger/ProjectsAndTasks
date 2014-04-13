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
class TicketsRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

    /**
     * findOpenTickets
     * 
     * @return object
     */
    public function findOpenTickets() {
        $query = $this->createQuery();

        $query->matching(
                $query->equals('ticketStatus.statusBehaviour', 0)
        );

        return $query->execute();
    }
    
        /**
     * findOpenTickets ordered by scheduel
     * 
     * @return object
     */
    public function findOpenTicketsScheduled() {
        $orderings = array('ticketScheduleDate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
        $query = $this->createQuery();
        $query->setOrderings($orderings);
        $query->matching(
                $query->equals('ticketStatus.statusBehaviour', 0)
        );

        return $query->execute();
    }

        /**
     * findOpenTickets
     * @param int $userId Description
         * 
     * @return object
     */
    public function findOpenTicketsByUser($userId) {
        $query = $this->createQuery();

        $query->matching(
                $query->logicalAnd(array(
                $query->equals('ticketStatus.statusBehaviour', 0),
                $query->equals('ticketAssigned', $userId)
                    ))
        );

        return $query->execute();
    }
    
    
    /**
     * findOpenTickets by Project
     * 
     * @param int $project ProjectUid
     * @return object
     */
    public function countOpenTicketsByProject($project) {
        $query = $this->createQuery();

        $query->matching(
                $query->logicalAnd(array(
                    $query->lessThan('ticketStatus', '4'),
                    $query->equals('ticketProject', $project)
                ))
        );

        return $query->execute()->count();
    }
    
        /**
     * findOpenTickets by Milestone
     * 
     * @param int $milestone Milestone
     * @return object
     */
    public function countOpenTicketsByMilestone($milestone) {
        $query = $this->createQuery();

        $query->matching(
                $query->logicalAnd(array(
                    $query->lessThan('ticketStatus', '4'),
                    $query->equals('ticketMilestone', $milestone)
                ))
        );

        return $query->execute()->count();
    }

            /**
     * findOpenTickets by Project
     * 
     * @param int $project ProjectUid
     * @param int $status Ticketstatus
     * @return object
     */
    public function findTicketsByProjectAndStatusOrderDate($project, $status) {
       $orderings = array('ticketDate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
        $query = $this->createQuery();
        //$query->setDefaultOrderings(array('ticketMilestone' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
        $query->setOrderings($orderings);
        $query->matching(
                $query->logicalAnd(array(
                    $query->equals('ticketStatus.statusBehaviour', $status),
                    $query->equals('ticketProject', $project)
                ))
        );

        return $query->execute();
    }
    
                /**
     * findOpenTickets by Project
     * 
     * @param int $project ProjectUid
     * @param int $status Ticketstatus
     * @return object
     */
    public function findTicketsByProjectAndStatusOrderUid($project, $status) {
       
        $query = $this->createQuery();
        $query->matching(
                $query->logicalAnd(array(
                    $query->equals('ticketStatus.statusBehaviour', $status),
                    $query->equals('ticketProject', $project)
                ))
        );

        return $query->execute();
    }
        /**
     * findOpenTickets by Project
     * 
     * @param int $project ProjectUid
     * @param int $status Ticketstatus
     * @return object
     */
    public function findTicketsByProjectAndStatus($project, $status) {
       $orderings = array('ticketMilestone.msOrder' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
        $query = $this->createQuery();
        //$query->setDefaultOrderings(array('ticketMilestone' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
        $query->setOrderings($orderings);
        $query->matching(
                $query->logicalAnd(array(
                    $query->equals('ticketStatus.statusBehaviour', $status),
                    $query->equals('ticketProject', $project)
                ))
        );

        return $query->execute();
    }
    
          /**
     * find OpenTickets by Project and Milestone
     * 
     * @param int $project ProjectUid
     * @param int $status Ticketstatus
     * @param int $milestone Ticketstatus
     * 
     * @return object
     */
    public function findTicketsByProjectMsAndStatus($project, $milestone, $status) {
       $orderings = array('ticketMilestone.msOrder' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
        $query = $this->createQuery();
        //$query->setDefaultOrderings(array('ticketMilestone' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
        //$query->setOrderings($orderings);
        $query->matching(
                $query->logicalAnd(array(
                    $query->equals('ticketStatus.statusBehaviour', $status),
                    $query->equals('ticketProject', $project),
                    $query->equals('ticketMilestone', $milestone)
                ))
        );

        return $query->execute();
    }
    
              /**
     * find OpenTickets by Project and Sprint
     * 
     * @param int $project ProjectUid
     * @param int $status Ticketstatus
     * @param int $sprint Sprint
     * 
     * @return object
     */
    public function findTicketsByProjectSprintAndStatus($project, $sprint, $status) {
       
        $query = $this->createQuery();
        $query->matching(
                $query->logicalAnd(array(
                    $query->equals('ticketStatus.statusBehaviour', $status),
                    $query->equals('ticketProject', $project),
                    $query->equals('ticketSprint', $sprint)
                ))
        );

        return $query->execute();
    }
    
    /**
     * find OpenTickets by Day (Calender Function)
     * 
     * @param int $start timestamp Start Day
     * @param int $end   timestamp end day
     * @param int $status status
     * 
     * @return object
     */
    public function findPerDayandStatus($start, $end, $status) {
       
        $query = $this->createQuery();

        $query->matching(
                $query->logicalAnd(array(
                    $query->equals('ticketStatus.statusBehaviour', $status),
                    $query->greaterThanOrEqual('ticketScheduleDate', $start),
                    $query->lessThanOrEqual('ticketScheduleDate', $end)
                ))
        );

        return $query->execute();
    }
    
       /**
     * find OpenTickets befor actual day (Calender Function)
     * 
     * @param int $start timestamp Start Day
     * @param int $status status
     * 
     * @return object
     */
    public function findPerDelayedandStatus($start, $status) {
       
        $query = $this->createQuery();

        $query->matching(
                $query->logicalAnd(array(
                    $query->equals('ticketStatus.statusBehaviour', $status),
                    $query->lessThan('ticketScheduleDate', $start),
                    $query->greaterThan('ticketScheduleDate', 0)
                ))
        );

        return $query->execute();
    }
}

?>