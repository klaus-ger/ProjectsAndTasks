<?php

namespace T3developer\ProjectsAndTasks\Domain\Model;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2013 
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
 * @package t3gists
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tickets extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * Tickert Nummer
     * @var \int
     * 
     */
    protected $ticketNummer;

    /**
     * Project ID
     * @var \T3developer\ProjectsAndTasks\Domain\Model\Projects
     * 
     */
    protected $ticketProject;

    /**
     * Project ID
     * @var \T3developer\ProjectsAndTasks\Domain\Model\Milestones
     * 
     */
    protected $ticketMilestone;

    /**
     * Project ID
     * @var \T3developer\ProjectsAndTasks\Domain\Model\Sprints
     * 
     */
    protected $ticketSprint;

    /**
     * The Ticket Titel
     * @var \string
     * 
     */
    protected $ticketTitel;

    /**
     * Ticket create Date
     * @var \DateTime
     * 
     */
    protected $ticketDate;

    /**
     * Ticket scheduled Date
     * @var \DateTime
     * 
     */
    protected $ticketScheduleDate;

    /**
     * Ticket scheduled Time
     * @var \int
     * 
     */
    protected $ticketScheduleTime;

    /**
     * Ticket Status
     * @var \T3developer\ProjectsAndTasks\Domain\Model\Status
     * 
     */
    protected $ticketStatus;

    /**
     * Ticket Status
     * @var \T3developer\ProjectsAndTasks\Domain\Model\Status
     * 
     */
    protected $ticketTyp;

    /**
     * Ticket Text
     * @var \string
     * 
     */
    protected $ticketText;

    /**
     * Ticket Text
     * @var \string
     * 
     */
    protected $ticketCustomId;

    /**
     * Ticket Owner
     * @var \int
     * 
     */
    protected $ticketOwner;
    
    /**
     * Ticket assigned to
     * @var \T3developer\ProjectsAndTasks\Domain\Model\User
     * 
     */
    protected $ticketAssigned;

    public function getTicketNummer() {
        return '#' . str_pad($this->uid, 4, "0", STR_PAD_LEFT);
    }

    public function getTicketProject() {
        return $this->ticketProject;
    }

    public function setTicketProject($ticketProject) {
        $this->ticketProject = $ticketProject;
    }

    public function getTicketTitel() {
        return $this->ticketTitel;
    }

    public function setTicketTitel($ticketTitel) {
        $this->ticketTitel = $ticketTitel;
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

    public function getTicketText() {
        return $this->ticketText;
    }

    public function setTicketText($ticketText) {
        $this->ticketText = $ticketText;
    }

    public function getTicketTyp() {
        return $this->ticketTyp;
    }

    public function setTicketTyp($ticketTyp) {
        $this->ticketTyp = $ticketTyp;
    }

    public function getTicketScheduleDate() {
        return $this->ticketScheduleDate;
    }

    public function setTicketScheduleDate($ticketScheduleDate) {
        $this->ticketScheduleDate = $ticketScheduleDate;
    }

    public function getTicketScheduleTime() {
        return $this->ticketScheduleTime;
    }

    public function setTicketScheduleTime($ticketScheduleTime) {
        $this->ticketScheduleTime = $ticketScheduleTime;
    }

    public function getTicketMilestone() {
        return $this->ticketMilestone;
    }

    public function setTicketMilestone($ticketMilestone) {
        $this->ticketMilestone = $ticketMilestone;
    }

    public function getTicketCustomId() {
        return $this->ticketCustomId;
    }

    public function setTicketCustomId($ticketCustomId) {
        $this->ticketCustomId = $ticketCustomId;
    }

    public function getTicketSprint() {
        return $this->ticketSprint;
    }

    public function setTicketSprint($ticketSprint) {
        $this->ticketSprint = $ticketSprint;
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