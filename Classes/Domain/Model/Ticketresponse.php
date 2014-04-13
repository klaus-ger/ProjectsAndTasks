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
class Ticketresponse extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * The Ticket
     * @var \T3developer\ProjectsAndTasks\Domain\Model\Tickets
     * 
     */
    protected $trTicket;

    /**
     * The Status Text
     * @var \T3developer\ProjectsAndTasks\Domain\Model\Status
     * 
     */
    protected $trTyp;

    /**
     * The Status Text
     * @var \string
     * 
     */
    protected $trTitel;

    /**
     * The Status Text
     * @var \string
     * 
     */
    protected $trText;

    /**
     * The Status Text
     * @var \DateTime
     * 
     */
    protected $trDate;

    /**
     * The Status Text
     * @var \string
     * 
     */
    protected $trStart;

    /**
     * The Status Text
     * @var \string
     * 
     */
    protected $trEnd;

    /**
     * The Status Text
     * @var \int
     * 
     */
    protected $trTime;

    /**
     * owner of the note
     * @var \T3developer\ProjectsAndTasks\Domain\Model\User
     * 
     */
    protected $trOwner;

    public function getTrTyp() {
        return $this->trTyp;
    }

    public function setTrTyp($trTyp) {
        $this->trTyp = $trTyp;
    }

    public function getTrTitel() {
        return $this->trTitel;
    }

    public function setTrTitel($trTitel) {
        $this->trTitel = $trTitel;
    }

    public function getTrText() {
        return $this->trText;
    }

    public function setTrText($trText) {
        $this->trText = $trText;
    }

    public function getTrDate() {
        return $this->trDate;
    }

    public function setTrDate($trDate) {
        $this->trDate = $trDate;
    }

    public function getTrStart() {
        return $this->trStart;
    }

    public function setTrStart($trStart) {
        $this->trStart = $trStart;
    }

    public function getTrEnd() {
        return $this->trEnd;
    }

    public function setTrEnd($trEnd) {
        $this->trEnd = $trEnd;
    }

    public function getTrTime() {
        return $this->trTime;
    }

    public function setTrTime($trTime) {
        $this->trTime = $trTime;
    }

    public function getTrTicket() {
        return $this->trTicket;
    }

    public function setTrTicket($trTicket) {
        $this->trTicket = $trTicket;
    }

    public function getTrOwner() {
        return $this->trOwner;
    }

    public function setTrOwner($trOwner) {
        $this->trOwner = $trOwner;
    }

}

?>