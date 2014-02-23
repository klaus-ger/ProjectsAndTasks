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
class Milestones extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * 
     * @var \T3developer\ProjectsAndTasks\Domain\Model\Projects
     * 
     */
    protected $msProject;

    /**
     * Contract Titel
     * @var \string
     * 
     */
    protected $msTitel;

    /**
     * Project Status
     * @var \string
     * 
     */
    protected $msText;

    /**
     * Contract Status
     * @var \DateTime
     * 
     */
    protected $msStart;

    /**
     * Contract Value
     * @var \DateTime
     * 
     */
    protected $msEnd;

    /**
     * Contract Description
     * @var \T3developer\ProjectsAndTasks\Domain\Model\Status
     * 
     */
    protected $msStatus;

    /**
     * Contract Description
     * @var \int
     * 
     */
    protected $msOrder;

    /**
     * Milestone Ticket Open - not stred in DB !
     * @var \int
     * 
     */
    protected $msTicketOpen;

    public function getMsProject() {
        return $this->msProject;
    }

    public function setMsProject($msProject) {
        $this->msProject = $msProject;
    }

    public function getMsTitel() {
        return $this->msTitel;
    }

    public function setMsTitel($msTitel) {
        $this->msTitel = $msTitel;
    }

    public function getMsText() {
        return $this->msText;
    }

    public function setMsText($msText) {
        $this->msText = $msText;
    }

    public function getMsStart() {
        return $this->msStart;
    }

    public function setMsStart($msStart) {
        $this->msStart = $msStart;
    }

    public function getMsEnd() {
        return $this->msEnd;
    }

    public function setMsEnd($msEnd) {
        $this->msEnd = $msEnd;
    }

    public function getMsStatus() {
        return $this->msStatus;
    }

    public function setMsStatus($msStatus) {
        $this->msStatus = $msStatus;
    }

    public function getMsOrder() {
        return $this->msOrder;
    }

    public function setMsOrder($msOrder) {
        $this->msOrder = $msOrder;
    }

    public function getMsTicketOpen() {
        return $this->msTicketOpen;
    }

    public function setMsTicketOpen($msTicketOpen) {
        $this->msTicketOpen = $msTicketOpen;
    }


}

?>