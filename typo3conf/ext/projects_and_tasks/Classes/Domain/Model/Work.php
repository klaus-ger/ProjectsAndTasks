<?php
namespace T3developer\ProjectsAndTasks\Domain\Model;

/***************************************************************
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
 ***************************************************************/

/**
 *
 *
 * @package commentreply
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Work extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {


    
    
    /**
     * The ProjectTitle
     * @var \int
     * 
     */
    protected $workProject;

    /**
     * The ProjectShort
     * @var \T3developer\ProjectsAndTasks\Domain\Model\User
     * 
     */
    protected $workUser;


    /**
     * The Task ProjectSort
     * @var \string
     * 
     */
    protected $workTitle;

    /**
     * The Task ProjectStatus
     * @var \string
     * 
     */
    protected $workDescription;

    /**
     * The Task ProjectStatus
     * @var \int
     * 
     */
    protected $workStatus;
    
       /**
     * The Task ProjectStatus
     * @var \DateTime
     * 
     */
    protected $workDate;
    
     /**
     * The Task ProjectStatus
     * @var \int
     * 
     */
    protected $workStart;

    /**
     * The Task ProjectStatus
     * @var \int
     * 
     */
    protected $workEnd;


    public function getWorkProject() {
        return $this->workProject;
    }

    public function setWorkProject($workProject) {
        $this->workProject = $workProject;
    }

    public function getWorkUser() {
        return $this->workUser;
    }

    public function setWorkUser($workUser) {
        $this->workUser = $workUser;
    }

    public function getWorkTitle() {
        return $this->workTitle;
    }

    public function setWorkTitle($workTitle) {
        $this->workTitle = $workTitle;
    }

    public function getWorkDescription() {
        return $this->workDescription;
    }

    public function setWorkDescription($workDescription) {
        $this->workDescription = $workDescription;
    }

    public function getWorkStatus() {
        return $this->workStatus;
    }

    public function setWorkStatus($workStatus) {
        $this->workStatus = $workStatus;
    }

    public function getWorkDate() {
        return $this->workDate;
    }

    public function setWorkDate($workDate) {
        $this->workDate = $workDate;
    }

    public function getWorkStart() {
        return $this->workStart;
    }

    public function setWorkStart($workStart) {
        $this->workStart = $workStart;
    }

    public function getWorkEnd() {
        return $this->workEnd;
    }

    public function setWorkEnd($workEnd) {
        $this->workEnd = $workEnd;
    }




}

?>