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
class Sprints extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {


    
     /**
     * Project ID
     * @var \T3developer\ProjectsAndTasks\Domain\Model\Projects
     * 
     */
    protected $sprintProject;
    

    
    /**
     * The Ticket Titel
     * @var \string
     * 
     */
    protected $sprintTitel;

        /**
     * The Ticket Text
     * @var \string
     * 
     */
    protected $sprintText;
    
    /**
     * Ticket create Date
     * @var \DateTime
     * 
     */
    protected $sprintStart;
    
        /**
     * Ticket create Date
     * @var \DateTime
     * 
     */
    protected $sprintEnd;
    
        /**
     * Sprint Status
     * @var \T3developer\ProjectsAndTasks\Domain\Model\Status
     * 
     */
    protected $sprintStatus;
    
    public function getSprintProject() {
        return $this->sprintProject;
    }

    public function setSprintProject($sprintProject) {
        $this->sprintProject = $sprintProject;
    }

    public function getSprintTitel() {
        return $this->sprintTitel;
    }

    public function setSprintTitel($sprintTitel) {
        $this->sprintTitel = $sprintTitel;
    }

    public function getSprintStart() {
        return $this->sprintStart;
    }

    public function setSprintStart($sprintStart) {
        $this->sprintStart = $sprintStart;
    }

    public function getSprintEnd() {
        return $this->sprintEnd;
    }

    public function setSprintEnd($sprintEnd) {
        $this->sprintEnd = $sprintEnd;
    }

    public function getSprintText() {
        return $this->sprintText;
    }

    public function setSprintText($sprintText) {
        $this->sprintText = $sprintText;
    }

    public function getSprintStatus() {
        return $this->sprintStatus;
    }

    public function setSprintStatus($sprintStatus) {
        $this->sprintStatus = $sprintStatus;
    }




}

?>