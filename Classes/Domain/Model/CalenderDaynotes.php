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
 * @package projects_and_tasks
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CalenderDaynotes extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * The Date
     * @var \DateTime
     * 
     */
    protected $calenderDate;

    /**
     * The User
     * @var \int
     * 
     */
    protected $calenderUser;

    /**
     * The Daynote
     * @var \string
     * 
     */
    protected $calenderDaynote;

    public function getCalenderDate() {
        return $this->calenderDate;
    }

    public function setCalenderDate($calenderDate) {
        $this->calenderDate = $calenderDate;
    }

    public function getCalenderUser() {
        return $this->calenderUser;
    }

    public function setCalenderUser($calenderUser) {
        $this->calenderUser = $calenderUser;
    }

    public function getCalenderDaynote() {
        return $this->calenderDaynote;
    }

    public function setCalenderDaynote($calenderDaynote) {
        $this->calenderDaynote = $calenderDaynote;
    }


}

?>