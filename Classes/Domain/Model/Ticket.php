<?php

namespace T3developer\ProjectsAndTasks\Domain\Model;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Klaus Heuer | <klaus.heuer@t3-developer.com>
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
 * @package projects_and_tasks
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Ticket extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * Ticket Project
     * @var \T3developer\ProjectsAndTasks\Domain\Model\Project
     * 
     */
    protected $ticketProject;

    /**
     * Ticket customer
     * @var \int
     * 
     */
    protected $ticketCustomer;

    /**
     * The Ticket Title
     * @var \string
     * 
     */
    protected $ticketTitle;

    /**
     * Budget Title
     * @var \string
     * 
     */
    protected $ticketText;

    /**
     * Ticket Time
     * @var \int
     * 
     */
    protected $ticketTime;

    /**
     * Ticket Deadline
     * @var \DateTime
     * 
     */
    protected $ticketDeadline;

    /**
     * Ticket Date
     * @var \DateTime
     * 
     */
    protected $ticketDate;

    /**
     * Ticket Status
     * @var \int
     * 
     */
    protected $ticketStatus;

    /**
     * Ticket Owner
     * @var \T3developer\ProjectsAndTasks\Domain\Model\User
     * 
     */
    protected $ticketOwner;

    /**
     * Ticket Assigned
     * @var \T3developer\ProjectsAndTasks\Domain\Model\User
     * 
     */
    protected $ticketAssigned;

    /**
     * Ticket No
     * @var \int
     * 
     */
    protected $ticketNo;




    public function getTicketNo() {
        $uid = $this->uid;
        $no = '#' . str_pad($uid, '5', '0', STR_PAD_LEFT);

        return $no;
    }

    public function getTicketProject() {
        return $this->ticketProject;
    }

    public function setTicketProject($ticketProject) {
        $this->ticketProject = $ticketProject;
    }

    public function getTicketCustomer() {
        return $this->ticketCustomer;
    }

    public function setTicketCustomer($ticketCustomer) {
        $this->ticketCustomer = $ticketCustomer;
    }

    public function getTicketTitle() {
        return $this->ticketTitle;
    }

    public function setTicketTitle($ticketTitle) {
        $this->ticketTitle = $ticketTitle;
    }

    public function getTicketText() {
        return $this->ticketText;
    }

    public function setTicketText($ticketText) {
        $this->ticketText = $ticketText;
    }

    public function getTicketTime() {
        return $this->ticketTime;
    }

    public function setTicketTime($ticketTime) {
        $this->ticketTime = $ticketTime;
    }

    public function getTicketDeadline() {
        return $this->ticketDeadline;
    }

    public function setTicketDeadline($ticketDeadline) {
        $this->ticketDeadline = $ticketDeadline;
    }

    public function getTicketDate() {
        return $this->ticketDate;
    }

    public function setTicketDate($ticketDate) {
        $this->ticketDate = $ticketDate;
    }

    public function getTicketStatus() {
        return $this->ticketStatus;
    }

    public function setTicketStatus($ticketStatus) {
        $this->ticketStatus = $ticketStatus;
    }

    public function getTicketOwner() {
        return $this->ticketOwner;
    }

    public function setTicketOwner($ticketOwner) {
        $this->ticketOwner = $ticketOwner;
    }

    public function getTicketAssigned() {
        return $this->ticketAssigned;
    }

    public function setTicketAssigned($ticketAssigned) {
        $this->ticketAssigned = $ticketAssigned;
    }


}

?>