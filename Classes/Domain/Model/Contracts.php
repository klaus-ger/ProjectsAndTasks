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
class Contracts extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * The Conract Typ 1: Offer 2: Order
     * @var \int
     * 
     */
    protected $contractTyp;

    /**
     * Contract Titel
     * @var \string
     * 
     */
    protected $contractTitel;

    /**
     * Project Status
     * @var \T3developer\ProjectsAndTasks\Domain\Model\Projects
     * 
     */
    protected $contractProject;

    /**
     * Contract Status
     * @var \T3developer\ProjectsAndTasks\Domain\Model\Status
     * 
     */
    protected $contractStatus;

    /**
     * Contract Value
     * @var \int
     * 
     */
    protected $contractValue;

    /**
     * Contract Description
     * @var \string
     * 
     */
    protected $contractDescription;

    public function getContractTyp() {
        return $this->contractTyp;
    }

    public function setContractTyp($contractTyp) {
        $this->contractTyp = $contractTyp;
    }

    public function getContractTitel() {
        return $this->contractTitel;
    }

    public function setContractTitel($contractTitel) {
        $this->contractTitel = $contractTitel;
    }

    public function getContractProject() {
        return $this->contractProject;
    }

    public function setContractProject($contractProject) {
        $this->contractProject = $contractProject;
    }

    public function getContractStatus() {
        return $this->contractStatus;
    }

    public function setContractStatus($contractStatus) {
        $this->contractStatus = $contractStatus;
    }

    public function getContractValue() {
        return $this->contractValue;
    }

    public function setContractValue($contractValue) {
        $this->contractValue = $contractValue;
    }

    public function getContractDescription() {
        return $this->contractDescription;
    }

    public function setContractDescription($contractDescription) {
        $this->contractDescription = $contractDescription;
    }




}

?>