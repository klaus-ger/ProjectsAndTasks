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
class Projects extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * The Project Number
     * This Number is calculated based on the uid and not stored in the DB
     * @var \string
     * 
     */
    protected $projectNumber;
       
    /**
     * The Project Titel
     * @var \string
     * 
     */
    protected $projectTitel;

    /**
     * Project create Date
     * @var \DateTime
     * 
     */
    protected $projectDate;

    /**
     * Project Status
     * @var \T3developer\ProjectsAndTasks\Domain\Model\Status
     * 
     */
    protected $projectStatus;

    /**
     * Project Text
     * @var \string
     * 
     */
    protected $projectText;

    /**
     * Open Tickets Not stored in the DB!
     * @var \string
     * 
     */
    protected $openTickets;

    /**
     * The project Owner
     * @var \int
     * 
     */
    protected $projectOwner;

    /**
     * The Project Short Text
     * @var \string
     * 
     */
    protected $projectShort;
    
        /**
     * The Project Short Text
     * @var \T3developer\ProjectsAndTasks\Domain\Model\Projectcats
     * 
     */
    protected $projectCat;
    
        /**
     * The Project Short Text
     * @var \T3developer\ProjectsAndTasks\Domain\Model\Company
     * 
     */
    protected $projectClient;

    public function getProjectNumber() {
       return 'P-' . str_pad($this->uid, 3, "0", STR_PAD_LEFT) ;
    }
    
    public function getProjectTitel() {
        return $this->projectTitel;
    }

    public function setProjectTitel($projectTitel) {
        $this->projectTitel = $projectTitel;
    }

    public function getProjectDate() {
        return $this->projectDate;
    }

    public function setProjectDate($projectDate) {
        $this->projectDate = $projectDate;
    }

    public function getProjectStatus() {
        return $this->projectStatus;
    }

    public function setProjectStatus($projectStatus) {
        $this->projectStatus = $projectStatus;
    }

    public function getProjectText() {
        return $this->projectText;
    }

    public function setProjectText($projectText) {
        $this->projectText = $projectText;
    }

    public function getOpenTickets() {
        return $this->openTickets;
    }

    public function setOpenTickets($openTickets) {
        $this->openTickets = $openTickets;
    }
    public function getProjectOwner() {
        return $this->projectOwner;
    }

    public function setProjectOwner($projectOwner) {
        $this->projectOwner = $projectOwner;
    }

    public function getProjectShort() {
        return $this->projectShort;
    }

    public function setProjectShort($projectShort) {
        $this->projectShort = $projectShort;
    }

    public function getProjectCat() {
        return $this->projectCat;
    }

    public function setProjectCat($projectCat) {
        $this->projectCat = $projectCat;
    }

    public function getProjectClient() {
        return $this->projectClient;
    }

    public function setProjectClient($projectClient) {
        $this->projectClient = $projectClient;
    }



}

?>